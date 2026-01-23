<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CardController;
use App\Http\Controllers\User\ChatController;
use App\Http\Controllers\User\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});
// Route::get('/', function () {
//     return view('index3');
// });
// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     // return view('layouts.login-master');
//     return view('layouts.user-dashboard');
//     // return view('login-dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/cards', [CardController::class, 'index'])->name('cards.index');
    Route::post('/cards/toggle', [CardController::class, 'toggleCard'])->name('cards.toggle');
    Route::post('/cards/update', [CardController::class, 'updateUserCards'])->name('cards.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('dashboard')->group(function () {
        // =========================
        // USER home ROUTES  ✅
        // =========================
        Route::get('/', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
        // =========================
        // USER CARDS ROUTES  ✅
        // =========================
        Route::get('/my-cards', [CardController::class, 'index'])
            ->name('user.cards.index');

        Route::post('/my-cards', [CardController::class, 'store'])
            ->name('user.cards.store');


        // =========================
        // USER CHAT ROUTES  ✅
        // =========================
        Route::get('/my-chat', [ChatController::class, 'index'])
            ->name('user.chat.index');
        Route::post('/dashboard/my-chat', [ChatController::class, 'create'])
            ->name('user.chat.create');

        Route::get('/my-chat/{token?}', [ChatController::class, 'show'])
            ->name('user.chat.show');
    });

});

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

require __DIR__ . '/auth.php';
