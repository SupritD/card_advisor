<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect user to Google OAuth
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback from Google
     */
    public function callback()
    {
        try {
            // Get user details from Google
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Google login failed. Try again.');
        }

        // Find or create user
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name'       => $googleUser->getName(),
                'google_id'  => $googleUser->getId(),
                'avatar'     => $googleUser->getAvatar(),
                'password'   => bcrypt(str()->random(16)), // random password for security
            ]
        );

        // Log the user in
        Auth::login($user);

        // Redirect to dashboard
        return redirect()->route('dashboard');
    }
}
