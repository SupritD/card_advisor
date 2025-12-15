<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MstCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('user.chats.index');
    }


 

}
