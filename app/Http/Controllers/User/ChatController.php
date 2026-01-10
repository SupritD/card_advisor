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

    public function create()
    {
        $session = ChatSession::createForUser(Auth::user());

        return redirect()->route('user.chat.show', $session->token);
    }

    public function show($token = null)
    {
        $user = Auth::user();

        $sessions = $user->chatSessions()->latest()->get();

        $activeSession = null;
        $messages = collect();

        if ($token) {
            $activeSession = ChatSession::where('token', $token)
                ->where('user_id', $user->id)
                ->firstOrFail();

            $messages = $activeSession->messages()->get();
        }

        return view('user.chats.index', compact(
            'sessions',
            'activeSession',
            'messages'
        ));
    }
}
