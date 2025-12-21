<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\ChatSession;
use App\Models\ChatMessage;

class ChatController extends Controller
{
    protected function getOrCreateSession(Request $request)
    {
        $token = $request->input('session_token') ?? $request->header('X-Chat-Session');
        $session = null;

        if ($token) {
            $session = ChatSession::where('token', $token)->first();

            // If a user is authenticated and the session exists but has no owner, attach it.
            if ($session && $request->user() && !$session->user_id) {
                $session->user_id = $request->user()->id;
                $session->save();
            }
        }

        if (!$session) {
            $session = ChatSession::createForUser($request->user());
        }

        return $session;
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'model' => 'nullable|string',
            'language' => 'nullable|string|in:auto,en,zh,es,fr',
            'session_token' => 'nullable|string',
        ]);

        $message = $request->input('message');
        $model = $request->input('model', 'deepseek-ai/DeepSeek-V3.2:novita');
        $language = $request->input('language', 'en');

        $apiKey = config('services.huggingface.key') ?? env('HUGGINGFACE_API_KEY');

        if (empty($apiKey)) {
            return response()->json(['error' => 'HuggingFace API key not configured'], 500);
        }

        try {
            // get or create session
            $session = $this->getOrCreateSession($request);

            // persist user message
            $userMsg = ChatMessage::create([
                'chat_session_id' => $session->id,
                'role' => 'user',
                'content' => $message,
            ]);

            // Build messages for the model. Include a system instruction to force language
            $messages = [];

            if ($language !== 'auto') {
                $langNames = [
                    'en' => 'English',
                    'zh' => 'Chinese',
                    'es' => 'Spanish',
                    'fr' => 'French',
                ];

                $langName = $langNames[$language] ?? $language;

                $messages[] = [
                    'role' => 'system',
                    'content' => "You are a helpful assistant. Always reply in {$langName}.",
                ];
            }

            // include recent history
            $history = $session->messages()->orderBy('created_at', 'desc')->limit(20)->get()->reverse();
            foreach ($history as $h) {
                $messages[] = ['role' => $h->role, 'content' => $h->content];
            }

            // current user message already saved but include it for context
            $messages[] = [
                'role' => 'user',
                'content' => $message,
            ];

            $payload = [
                'messages' => $messages,
                'model' => $model,
                'stream' => false,
            ];

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type' => 'application/json',
            ])->post('https://router.huggingface.co/v1/chat/completions', $payload);

            if ($response->failed()) {
                Log::error('HuggingFace API error', ['status' => $response->status(), 'body' => $response->body()]);
                return response()->json(['error' => 'Upstream API error'], 500);
            }

            $data = $response->json();

            // Try to extract assistant content
            $content = null;
            if (isset($data['choices'][0]['message']['content'])) {
                $content = $data['choices'][0]['message']['content'];
            } elseif (isset($data['choices'][0]['content'])) {
                $content = $data['choices'][0]['content'];
            }

            // persist assistant reply
            $assistantMsg = ChatMessage::create([
                'chat_session_id' => $session->id,
                'role' => 'assistant',
                'content' => $content ?? '',
                'meta' => $data,
            ]);

            return response()->json(['reply' => $content ?? 'No reply from model', 'raw' => $data, 'session_token' => $session->token]);
        } catch (\Exception $e) {
            Log::error('ChatController exception', ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'Exception calling upstream API'], 500);
        }
    }

    /**
     * Return historical messages for a session token
     */
    public function history(Request $request)
    {
        $request->validate([
            'session_token' => 'nullable|string',
        ]);

        $token = $request->input('session_token') ?? $request->query('session_token');
        if (!$token) {
            return response()->json(['messages' => []]);
        }

        $session = ChatSession::where('token', $token)->first();
        if (!$session) {
            return response()->json(['messages' => []]);
        }

        $messages = $session->messages()->orderBy('created_at', 'asc')->get()->map(function ($m) {
            return ['role' => $m->role, 'content' => $m->content, 'created_at' => $m->created_at->toDateTimeString()];
        });

        return response()->json(['messages' => $messages, 'session_token' => $session->token]);
    }

    /**
     * Stream chat responses token-by-token from Hugging Face to the client.
     */
    public function stream(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'model' => 'nullable|string',
            'language' => 'nullable|string|in:auto,en,zh,es,fr',
            'session_token' => 'nullable|string',
        ]);

        $message = $request->input('message');
        $model = $request->input('model', 'deepseek-ai/DeepSeek-V3.2:novita');
        $language = $request->input('language', 'en');

        $apiKey = config('services.huggingface.key') ?? env('HUGGINGFACE_API_KEY');

        if (empty($apiKey)) {
            return response()->json(['error' => 'HuggingFace API key not configured'], 500);
        }

        // get or create session and persist user message
        $session = $this->getOrCreateSession($request);
        $userMsg = ChatMessage::create([
            'chat_session_id' => $session->id,
            'role' => 'user',
            'content' => $message,
        ]);

        // Build messages with language system instruction
        $messages = [];
        if ($language !== 'auto') {
            $langNames = [
                'en' => 'English',
                'zh' => 'Chinese',
                'es' => 'Spanish',
                'fr' => 'French',
            ];
            $langName = $langNames[$language] ?? $language;
            $messages[] = [
                'role' => 'system',
                'content' => "You are a helpful assistant. Always reply in {$langName}.",
            ];
        }

        // include recent history
        $history = $session->messages()->orderBy('created_at', 'desc')->limit(20)->get()->reverse();
        foreach ($history as $h) {
            $messages[] = ['role' => $h->role, 'content' => $h->content];
        }

        $messages[] = ['role' => 'user', 'content' => $message];

        $payload = [
            'messages' => $messages,
            'model' => $model,
            'stream' => true,
        ];

        try {
            // Make a streaming request to Hugging Face (Guzzle PSR response)
            $psrResponse = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type' => 'application/json',
            ])->withOptions(['stream' => true, 'timeout' => 0])->post('https://router.huggingface.co/v1/chat/completions', $payload)->toPsrResponse();

            $body = $psrResponse->getBody();

            return response()->stream(function () use ($body, $session) {
                // Ensure script doesn't time out
                set_time_limit(0);

                // notify client of session token at the start
                echo "data: " . json_encode(['session_token' => $session->token]) . "\n\n";
                @ob_flush(); @flush();

                $buffer = '';
                $assistantContent = '';
                $metaChunks = [];

                while (!$body->eof()) {
                    $chunk = $body->read(1024);
                    if ($chunk === '') {
                        usleep(100000);
                        continue;
                    }

                    $buffer .= $chunk; // keep raw chunks for later meta capture

                    // Process all complete events separated by double-newline
                    while (true) {
                        $posR = strpos($buffer, "\r\n\r\n");
                        $posN = strpos($buffer, "\n\n");

                        if ($posR === false && $posN === false) {
                            break; // no complete event yet
                        }

                        if ($posR !== false && ($posN === false || $posR < $posN)) {
                            $pos = $posR;
                            $sep = "\r\n\r\n";
                        } else {
                            $pos = $posN;
                            $sep = "\n\n";
                        }

                        $part = substr($buffer, 0, $pos);
                        $buffer = substr($buffer, $pos + strlen($sep));

                        $part = trim($part);
                        if ($part === '') {
                            continue;
                        }

                        // strip data: prefix if present
                        $part = preg_replace('/^data:\s*/', '', $part);
                        if ($part === '[DONE]') {
                            // persist final assistant message
                            if ($assistantContent !== '') {
                                ChatMessage::create([
                                    'chat_session_id' => $session->id,
                                    'role' => 'assistant',
                                    'content' => $assistantContent,
                                    'meta' => ['chunks' => $metaChunks],
                                ]);
                            }

                            echo "data: {\"done\":true}\n\n";
                            @ob_flush(); @flush();
                            return;
                        }

                        $json = json_decode($part, true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            // Try to find a delta token or content field
                            $delta = null;
                            if (isset($json['choices'][0]['delta']['content'])) {
                                $delta = $json['choices'][0]['delta']['content'];
                            } elseif (isset($json['choices'][0]['message']['content'])) {
                                $delta = $json['choices'][0]['message']['content'];
                            } elseif (isset($json['choices'][0]['content'])) {
                                $delta = $json['choices'][0]['content'];
                            }

                            if ($delta !== null) {
                                $assistantContent .= $delta;
                                echo "data: " . json_encode(['delta' => $delta]) . "\n\n";
                                @ob_flush(); @flush();
                            }
                        } else {
                            // Attempt to extract JSON objects inside the part (in case multiple were glued together)
                            if (preg_match_all('/\{.*\}/sU', $part, $matches)) {
                                foreach ($matches[0] as $m) {
                                    $j = json_decode($m, true);
                                    if (json_last_error() === JSON_ERROR_NONE) {
                                        // collect meta
                                        $metaChunks[] = $j;

                                        $delta = null;
                                        if (isset($j['choices'][0]['delta']['content'])) {
                                            $delta = $j['choices'][0]['delta']['content'];
                                        } elseif (isset($j['choices'][0]['message']['content'])) {
                                            $delta = $j['choices'][0]['message']['content'];
                                        } elseif (isset($j['choices'][0]['content'])) {
                                            $delta = $j['choices'][0]['content'];
                                        }

                                        if ($delta !== null) {
                                            $assistantContent .= $delta;
                                            echo "data: " . json_encode(['delta' => $delta]) . "\n\n";
                                            @ob_flush(); @flush();
                                        }
                                    }
                                }
                            } else {
                                // Send raw chunk as fallback (should be rare)
                                echo "data: " . json_encode(['chunk' => $part]) . "\n\n";
                                @ob_flush(); @flush();
                            }
                        }
                    }
                }

                // Process any remaining buffer when stream ends
                $leftover = trim($buffer);
                if ($leftover !== '') {
                    $leftover = preg_replace('/^data:\s*/', '', $leftover);
                    $json = json_decode($leftover, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $delta = null;
                        if (isset($json['choices'][0]['delta']['content'])) {
                            $delta = $json['choices'][0]['delta']['content'];
                        } elseif (isset($json['choices'][0]['message']['content'])) {
                            $delta = $json['choices'][0]['message']['content'];
                        } elseif (isset($json['choices'][0]['content'])) {
                            $delta = $json['choices'][0]['content'];
                        }

                        if ($delta !== null) {
                            $assistantContent .= $delta;
                            echo "data: " . json_encode(['delta' => $delta]) . "\n\n";
                            @ob_flush(); @flush();
                        }
                    }
                }

                // persist assistant final content
                if ($assistantContent !== '') {
                    ChatMessage::create([
                        'chat_session_id' => $session->id,
                        'role' => 'assistant',
                        'content' => $assistantContent,
                        'meta' => ['chunks' => $metaChunks],
                    ]);
                }

                echo "data: {\"done\":true}\n\n";
                @ob_flush(); @flush();
            }, 200, [
                'Content-Type' => 'text/event-stream',
                'Cache-Control' => 'no-cache',
                'Connection' => 'keep-alive',
            ]);
        } catch (\Exception $e) {
            Log::error('Chat stream exception', ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'Exception streaming upstream API'], 500);
        }
    }

    /**
     * Delete a chat session and its messages (optional) — requires session_token
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'session_token' => 'nullable|string',
        ]);

        $token = $request->input('session_token') ?? $request->header('X-Chat-Session');
        if (!$token) {
            return response()->json(['status' => 'no-token'], 200);
        }

        $session = ChatSession::where('token', $token)->first();
        if (!$session) {
            return response()->json(['status' => 'not-found'], 404);
        }

        $session->delete();

        return response()->json(['status' => 'deleted']);
    }

    /**
     * List chat sessions for the current authenticated user
     */
    public function sessions(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['sessions' => []]);
        }

        $sessions = ChatSession::where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($s) {
                $last = $s->messages()->orderBy('created_at', 'desc')->first();
                return [
                    'id' => $s->id,
                    'token' => $s->token,
                    'created_at' => $s->created_at->toDateTimeString(),
                    'last_message' => $last ? substr($last->content ?? '', 0, 200) : null,
                ];
            });

        return response()->json(['sessions' => $sessions]);
    }

    /**
     * Create a new chat session for the authenticated user
     */
    public function createSession(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $session = ChatSession::createForUser($user);

        return response()->json(['session_token' => $session->token]);
    }
}
