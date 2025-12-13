<?php

use App\Http\Controllers\Admin\AdminController;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\CardController;


/*
|--------------------------------------------------------------------------
| Admin Guest (login, etc)
|--------------------------------------------------------------------------
*/
Route::middleware('guest:admin')->group(function () {

    Route::get('/login', function () {
        return view('admin.login');
    })->name('login');

    Route::post('/login', function (Request $request) {

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid admin credentials'
        ]);
    })->name('login.post');

    Route::get('/register', function () {
        return view('admin.register');
    })->name('register');

    Route::post('/register', function (Request $request) {

        // Validate form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|confirmed|min:6',
        ]);

        // Create admin
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Login admin after registration
        Auth::guard('admin')->login($admin);

        return redirect()->route('admin.dashboard');
    })->name('register.post');

});


/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('layouts.admin-dashboard');
    })->name('dashboard');

    Route::post('/logout', function () {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    })->name('logout');


    /*
    |--------------------------------------------------------------------------
    | Cards
    |--------------------------------------------------------------------------
    */
    Route::prefix('cards')->name('cards.')->group(function () {

        Route::get('/', [CardController::class, 'index'])->name('index');
        Route::get('/create', [CardController::class, 'create'])->name('create');
        Route::post('/', [CardController::class, 'store'])->name('store');

        // Show card details
        Route::get('/{card}', [CardController::class, 'show'])->name('show');

        // Edit form
        Route::get('/{card}/edit', [CardController::class, 'edit'])->name('edit');

        // Update card
        Route::put('/{card}', [CardController::class, 'update'])->name('update');

        // Delete card
        Route::delete('/{card}', [CardController::class, 'destroy'])->name('destroy');

    });
    Route::get('/users', [AdminController::class, 'user'])->name('users.index');
Route::get('/users/{user}', [AdminController::class, 'show'])->name('users.show');
Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');


});
