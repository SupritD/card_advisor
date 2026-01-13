<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MstCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    // public function index()
    // {
    //     $user = Auth::user();

    //     $cards = MstCard::where('status', 'active')->get();

    //     $userCards = $user->cards;
    //     $userCardIds = $userCards->pluck('id')->toArray();

    //     return view('user.cards.index', compact(
    //         'cards',
    //         'userCards',
    //         'userCardIds'
    //     ));
    // }

    public function index(Request $request)
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Base Query (Filter Ready)
        |--------------------------------------------------------------------------
        */
        $query = MstCard::where('status', 'active');

        if ($request->filled('cardname')) {
            $query->where('card_name', $request->cardname);
        }

        if ($request->filled('bankname')) {
            $query->where('bank_name', $request->bankname);
        }

        if ($request->filled('cardtype')) {
            $query->where('card_category', $request->cardtype);
        }

        if ($request->filled('network')) {
            $query->where('network_type', $request->network);
        }

        /*
        |--------------------------------------------------------------------------
        | Fetch Cards
        |--------------------------------------------------------------------------
        */
        $cards = $query->paginate(9)->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Dropdown Values (Optimized)
        |--------------------------------------------------------------------------
        */
        $cardNames = MstCard::where('status', 'active')->distinct()->pluck('card_name');
        $bankNames = MstCard::where('status', 'active')->distinct()->pluck('bank_name');
        $cardTypes = MstCard::where('status', 'active')->distinct()->pluck('card_category');
        $networks = MstCard::where('status', 'active')->distinct()->pluck('network_type');

        /*
        |--------------------------------------------------------------------------
        | User Selected Cards
        |--------------------------------------------------------------------------
        */
        $userCards = $user->cards;
        $userCardIds = $user->cards()->pluck('mst_cards.id')->toArray();

        return view('user.cards.index', compact(
            'cards',
            'cardNames',
            'bankNames',
            'cardTypes',
            'networks',
            'userCards',
            'userCardIds'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cards' => 'array',
            'cards.*' => 'exists:mst_cards,id',
        ]);

        $user = Auth::user();

        // Prevent duplicates and nulls
        $cards = collect($request->cards ?? [])
            ->unique()
            ->values()
            ->toArray();

        $user->cards()->sync($cards);

        return redirect()
            ->route('user.cards.index')
            ->with('success', 'Cards updated successfully.');
        // // Add / remove cards safely
        // $user->cards()->sync($request->cards ?? []);

        // return redirect()
        //     ->route('user.cards.index')
        //     ->with('success', 'Your cards have been updated successfully.');
    }

    public function toggleCard(Request $request)
    {
        $request->validate([
            'card_id' => 'required|exists:mst_cards,id',
            'action' => 'required|in:add,remove'
        ]);

        $user = Auth::user();
        $cardId = $request->card_id;

        if ($request->action === 'add') {
            $user->cards()->syncWithoutDetaching([$cardId]);
            $message = 'Card added to wallet';
        } else {
            $user->cards()->detach($cardId);
            $message = 'Card removed from wallet';
        }

        // Fetch card details for frontend DOM injection
        $card = MstCard::find($cardId);

        return response()->json([
            'success' => true,
            'message' => $message,
            'card' => $card,
            'total_count' => $user->cards()->count()
        ]);
    }
}
