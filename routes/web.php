<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Admin\CardController;
use App\Http\Controllers\User\CardController; // 👈 IMPORTANT


Route::get('/', function () {
    return view('index');
});
// Route::get('/', function () {
//     return view('index3');
// });
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    // return view('layouts.login-master');
    return view('layouts.user-dashboard');
    // return view('login-dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::prefix('dashboard')->group(function () {
        // =========================
        // USER CARDS ROUTES  ✅
        // =========================
        Route::get('/my-cards', [CardController::class, 'index'])
            ->name('user.cards.index');

        Route::post('/my-cards', [CardController::class, 'store'])
            ->name('user.cards.store');

    });


});

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);






require __DIR__ . '/auth.php';
