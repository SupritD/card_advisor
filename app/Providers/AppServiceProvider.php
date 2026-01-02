<?php

namespace App\Providers;

use App\Models\ChatSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        View::composer('layouts.user-dashboard', function ($view) {
            $user = Auth::user();

            $sessions = $user
                ? ChatSession::where('user_id', $user->id)->latest()->get()
                : collect();

            $view->with('chatSessions', $sessions);
        });
    }
}
