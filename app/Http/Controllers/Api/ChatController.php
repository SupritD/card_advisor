<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'model' => 'nullable|string',
            'language' => 'nullable|string|in:auto,en,zh,es,fr',
        ]);

        $message = $request->input('message');
        $model = $request->input('model', 'deepseek-ai/DeepSeek-V3.2:novita');
        $language = $request->input('language', 'en');

        $apiKey = config('services.huggingface.key') ?? env('HUGGINGFACE_API_KEY');

        if (empty($apiKey)) {
            return response()->json(['error' => 'HuggingFace API key not configured'], 500);
        }

        try {
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

            return response()->json(['reply' => $content ?? 'No reply from model', 'raw' => $data]);
        } catch (\Exception $e) {
            Log::error('ChatController exception', ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'Exception calling upstream API'], 500);
        }
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
        ]);

        $message = $request->input('message');
        $model = $request->input('model', 'deepseek-ai/DeepSeek-V3.2:novita');
        $language = $request->input('language', 'en');

        $apiKey = config('services.huggingface.key') ?? env('HUGGINGFACE_API_KEY');

        if (empty($apiKey)) {
            return response()->json(['error' => 'HuggingFace API key not configured'], 500);
        }

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

            return response()->stream(function () use ($body) {
                // Ensure script doesn't time out
                set_time_limit(0);

                $buffer = '';

                while (!$body->eof()) {
                    $chunk = $body->read(1024);
                    if ($chunk === '') {
                        usleep(100000);
                        continue;
                    }

                    $buffer .= $chunk;

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
                                echo "data: " . json_encode(['delta' => $delta]) . "\n\n";
                                @ob_flush(); @flush();
                            }
                        } else {
                            // Attempt to extract JSON objects inside the part (in case multiple were glued together)
                            if (preg_match_all('/\{.*\}/sU', $part, $matches)) {
                                foreach ($matches[0] as $m) {
                                    $j = json_decode($m, true);
                                    if (json_last_error() === JSON_ERROR_NONE) {
                                        $delta = null;
                                        if (isset($j['choices'][0]['delta']['content'])) {
                                            $delta = $j['choices'][0]['delta']['content'];
                                        } elseif (isset($j['choices'][0]['message']['content'])) {
                                            $delta = $j['choices'][0]['message']['content'];
                                        } elseif (isset($j['choices'][0]['content'])) {
                                            $delta = $j['choices'][0]['content'];
                                        }

                                        if ($delta !== null) {
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
                            echo "data: " . json_encode(['delta' => $delta]) . "\n\n";
                            @ob_flush(); @flush();
                        }
                    }
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
}
