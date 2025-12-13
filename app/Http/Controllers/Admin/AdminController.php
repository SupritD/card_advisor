<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //

    // public function user()
    // {
    //     $users = User::latest()->get();
    //     return view('admin.users.index', compact('users'));
    // }
    public function user()
    {
        $users = User::withCount('cards')
            ->latest()
            ->get();

        return view('admin.users.index', compact('users'));
    }


    public function show(User $user)
    {
        // $user->load('cards');  // eager load selected cards
         $user->load([
        'cards' => function ($query) {
            $query->orderBy('user_cards.created_at', 'desc');
        }
    ]);
        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        // If user has related cards (pivot), delete link
        $user->cards()->detach();

        // Now delete user
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }

}
