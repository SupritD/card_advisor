<?php

use App\Http\Controllers\Api\ChatController;
use Illuminate\Http\Request;
// Chat endpoints are protected by Sanctum (must authenticate via cookie/token)
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/chat', [ChatController::class, 'chat']);
    Route::post('/chat/stream', [ChatController::class, 'stream']);

    Route::get('/chat/history', [ChatController::class, 'history']);

    // Route::middleware('auth:sanctum')->group(function () {
    // Route::post('/chat/stream', [ChatController::class, 'stream']);
    Route::get('/chat/sessions', [ChatController::class, 'sessions']);
    Route::post('/chat/session', [ChatController::class, 'createSession']);
    Route::delete('/chat/session', [ChatController::class, 'destroy']);
    // });

    // Helper endpoint for the frontend to check authentication status
    Route::get('/user', function (Request $request) {
        return $request->user() ?: response()->json(['message' => 'Unauthenticated.'], 401);
    });
});
