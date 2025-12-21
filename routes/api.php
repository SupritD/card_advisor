<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatController;

Route::post('/chat', [ChatController::class, 'chat']);
Route::post('/chat/stream', [ChatController::class, 'stream']);
Route::get('/chat/history', [ChatController::class, 'history']);
Route::delete('/chat/session', [ChatController::class, 'destroy']);
