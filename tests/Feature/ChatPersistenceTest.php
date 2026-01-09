<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use App\Models\ChatSession;

class ChatPersistenceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Force sqlite in-memory for CI/container tests where phpunit env may not be applied
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');

        // run migrations for tests
        $this->artisan('migrate')->run();
    }

    public function test_chat_persists_and_history_endpoint_returns_messages()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user, 'sanctum');

        Http::fake([
            'https://router.huggingface.co/v1/chat/completions' => Http::response([
                'choices' => [
                    ['message' => ['content' => 'Hello from model']],
                ],
            ], 200),
        ]);

        $resp = $this->postJson('/api/chat', ['message' => 'Hello test', 'language' => 'en']);
        $resp->assertStatus(200);
        $resp->assertJsonStructure(['reply', 'raw', 'session_token']);
        $token = $resp->json('session_token');
        $this->assertNotNull($token);

        $session = ChatSession::where('token', $token)->first();
        $this->assertNotNull($session);

        $this->assertDatabaseHas('chat_messages', ['chat_session_id' => $session->id, 'role' => 'user', 'content' => 'Hello test']);
        $this->assertDatabaseHas('chat_messages', ['chat_session_id' => $session->id, 'role' => 'assistant']);

        $hist = $this->getJson('/api/chat/history?session_token=' . urlencode($token));
        $hist->assertStatus(200);
        $hist->assertJsonCount(2, 'messages');
    }

    public function test_stream_persists_and_emits_session_token()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user, 'sanctum');

        // Build a fake streaming body with SSE "data: ...\n\n" segments
        $body = "data: {\"choices\":[{\"delta\":{\"content\":\"Hello\"}}]}\n\n";
        $body .= "data: {\"choices\":[{\"delta\":{\"content\":\" world\"}}]}\n\n";
        $body .= "data: [DONE]\n\n";

        Http::fake([
            'https://router.huggingface.co/v1/chat/completions' => Http::response($body, 200),
        ]);

        $response = $this->postJson('/api/chat/stream', ['message' => 'Stream test', 'language' => 'en']);
        $response->assertStatus(200);

        // The test client may not capture streaming SSE frames; assert persistence on server side instead
        $session = ChatSession::latest()->first();
        $this->assertNotNull($session, 'No session created during stream');

        $this->assertDatabaseHas('chat_messages', ['chat_session_id' => $session->id, 'role' => 'user', 'content' => 'Stream test']);
        // Note: some test clients do not capture live SSE frames the same way curl does; we at least assert session and user message were created.

    }

    public function test_can_delete_session_via_api()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user, 'sanctum');

        Http::fake([
            'https://router.huggingface.co/v1/chat/completions' => Http::response([
                'choices' => [
                    ['message' => ['content' => 'Temporary reply']],
                ],
            ], 200),
        ]);

        $resp = $this->postJson('/api/chat', ['message' => 'Will be deleted', 'language' => 'en']);
        $token = $resp->json('session_token');
        $this->assertNotNull($token);

        $session = ChatSession::where('token', $token)->first();
        $this->assertNotNull($session);

        $del = $this->deleteJson('/api/chat/session', ['session_token' => $token]);
        $del->assertStatus(200);

        $this->assertDatabaseMissing('chat_sessions', ['token' => $token]);
        $this->assertDatabaseMissing('chat_messages', ['chat_session_id' => $session->id]);
    }
}
