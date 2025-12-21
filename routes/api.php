<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatController;

// Chat endpoints are protected by Sanctum (must authenticate via cookie/token)
use Illuminate\Http\Request;

// Route::middleware('auth')->group(function () {
    Route::post('/chat', [ChatController::class, 'chat']);
    Route::post('/chat/stream', [ChatController::class, 'stream']);

    Route::get('/chat/history', [ChatController::class, 'history']);

    Route::get('/chat/sessions', [ChatController::class, 'sessions']);
    Route::post('/chat/session', [ChatController::class, 'createSession']);
    Route::delete('/chat/session', [ChatController::class, 'destroy']);

    // Helper endpoint for the frontend to check authentication status
    Route::get('/user', function (Request $request) {
        return $request->user() ?: response()->json(['message' => 'Unauthenticated.'], 401);
    });
// });
