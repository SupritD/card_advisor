<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ChatSession;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Defensive: auth middleware already exists, but never assume
        if (! $user) {
            abort(403);
        }

        $sessions = ChatSession::where('user_id', $user->id)
            ->latest()
            ->get();

        return view('user.chats.index', compact('sessions'));
    }
}
