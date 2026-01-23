<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //

    public function index()
    {
        $user = Auth::user();

        // Defensive: auth middleware already exists, but never assume
        if (! $user) {
            abort(403);
        }

        // Fetch user cards

        // return view('user.index', compact(
        //     'cards',
        //     'cardNames',
        //     'bankNames',
        //     'cardTypes',
        //     'networks',
        //     'userCards',
        //     'userCardIds'
        // ));
        
        return view('user.index');
    }
}
