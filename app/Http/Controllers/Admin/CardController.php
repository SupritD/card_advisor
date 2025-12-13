<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MstCard;
use Illuminate\Http\Request;

class CardController extends Controller
{
    //
public function index()
{
    $cards = MstCard::withCount('users')
        ->latest()
        ->get();

    return view('admin.cards.index', compact('cards'));
}


    // public function index()
    // {
    //     $cards = MstCard::latest()->paginate(10); // or ->get()


    //     return view('admin.cards.index', compact('cards'));
    // }


    public function create()
    {
        return view('admin.cards.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'bank_name' => 'nullable|string|max:255',
            'card_name' => 'nullable|string|max:255',
            'network_type' => 'required|in:Visa,MasterCard,RuPay,Amex',
            'card_category' => 'required|in:Credit,Debit',
            'card_tier' => 'nullable|string|max:255',
            'joining_fee' => 'nullable|numeric|min:0|max:100000',
            'annual_fee' => 'nullable|numeric|min:0|max:100000',
            'pros' => 'nullable|string|max:3000',
            'status' => 'required|in:active,inactive',
        ]);

        MstCard::create($request->only([
            'bank_name',
            'card_name',
            'network_type',
            'card_category',
            'card_tier',
            'joining_fee',
            'annual_fee',
            'pros',
            'status'
        ]));

        return redirect()->route('admin.cards.index')
            ->with('success', 'Card created successfully!');
    }
     public function show(MstCard $card)
    {
        return view('admin.cards.show', compact('card'));
    }

    public function edit(MstCard $card)
    {
        return view('admin.cards.edit', compact('card'));
    }

    public function update(Request $request, MstCard $card)
    {
        $request->validate([
            'bank_name' => 'nullable|string|max:255',
            'card_name' => 'nullable|string|max:255',
            'network_type' => 'required|in:Visa,MasterCard,RuPay,Amex',
            'card_category' => 'required|in:Credit,Debit',
            'card_tier' => 'nullable|string|max:255',
            'joining_fee' => 'nullable|numeric|min:0|max:100000',
            'annual_fee' => 'nullable|numeric|min:0|max:100000',
            'pros' => 'nullable|string|max:3000',
            'status' => 'required|in:active,inactive',
        ]);

        // $card->update($request->all());
        $card->update([
            'bank_name' => $request->bank_name,
            'card_name' => $request->card_name,
            'network_type' => $request->network_type,
            'card_category' => $request->card_category,
            'card_tier' => $request->card_tier,
            'joining_fee' => $request->joining_fee,
            'annual_fee' => $request->annual_fee,
            'pros' => $request->pros,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.cards.index')
            ->with('success', 'Card updated successfully.');
    }

    public function destroy(MstCard $card)
    {
        $card->delete();

        return redirect()->route('admin.cards.index')
            ->with('success', 'Card deleted successfully.');
    }
}
