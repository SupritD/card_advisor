<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Socialite;

class FacebookController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback()
    {
        $fbUser = Socialite::driver('facebook')->user();

        $user = User::firstOrCreate(
            ['email' => $fbUser->getEmail()],
            ['name' => $fbUser->getName()]
        );

        Auth::login($user);

        return redirect('/dashboard');
    }
}
