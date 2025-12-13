<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MstCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $cards = MstCard::where('status', 'active')->get();

        $userCards = $user->cards;
        $userCardIds = $userCards->pluck('id')->toArray();

        return view('user.cards.index', compact(
            'cards',
            'userCards',
            'userCardIds'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cards' => 'nullable|array',
            'cards.*' => 'exists:mst_cards,id',
        ]);

        $user = Auth::user();

        // Add / remove cards safely
        $user->cards()->sync($request->cards ?? []);

        return redirect()
            ->route('user.cards.index')
            ->with('success', 'Your cards have been updated successfully.');
    }

 

}
