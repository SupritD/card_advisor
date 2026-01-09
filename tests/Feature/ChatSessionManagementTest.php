<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use App\Models\ChatSession;
use App\Models\User;

class ChatSessionManagementTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        // ensure in-memory sqlite and run migrations inside tests
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');
        $this->artisan('migrate')->run();
    }

    public function test_authenticated_user_can_create_and_list_sessions()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum');

        // create session through explicit endpoint
        $post = $this->postJson('/api/chat/session');
        $post->assertStatus(200);
        $token = $post->json('session_token');
        $this->assertNotNull($token);

        $session = ChatSession::where('token', $token)->first();
        $this->assertNotNull($session);
        $this->assertEquals($user->id, $session->user_id);

        $list = $this->getJson('/api/chat/sessions');
        $list->assertStatus(200);
        $list->assertJsonStructure(['sessions']);
        $this->assertCount(1, $list->json('sessions'));
    }

    public function test_session_is_associated_when_user_uses_existing_token()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        // create session anonymously (simulate external session)
        $s = ChatSession::createForUser(null);

        // use chat endpoint while authenticated and include token
        Http::fake([
            'https://router.huggingface.co/v1/chat/completions' => Http::response([
                'choices' => [[ 'message' => ['content' => 'Hi'] ]],
            ], 200),
        ]);

        $resp = $this->postJson('/api/chat', ['message' => 'Hello', 'language' => 'en', 'session_token' => $s->token]);
        $resp->assertStatus(200);

        $s->refresh();
        $this->assertEquals($user->id, $s->user_id, 'Session should be attached to authenticated user when used');
    }
}
