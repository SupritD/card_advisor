<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\MstCard;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) abort(403);

        $bestCards = [];
        
        $categories = [
            'Lounge Access',
            'Electricity Bill',
            'Online Shopping',
            'Offline Shopping',
            'Traveling',
            'Movie tickets',
            'Dinner',
            'Hotels and Restaurants'
        ];

        // Define keywords for each category to search in 'pros' or 'card_name'
        $categoryKeywords = [
            'Lounge Access' => ['lounge', 'airport', 'priority pass'],
            'Electricity Bill' => ['electricity', 'bill', 'utility', 'utilities'],
            'Online Shopping' => ['online shopping', 'amazon', 'flipkart', 'myntra', 'ecommerce', 'e-commerce'],
            'Offline Shopping' => ['offline', 'retail', 'departmental store', 'grocery', 'pos'],
            'Traveling' => ['travel', 'flight', 'vistara', 'indigo', 'miles', 'air'],
            'Movie tickets' => ['movie', 'cinema', 'ticket', 'bookmyshow'],
            'Dinner' => ['dinner', 'dining', 'restaurant', 'swiggy', 'zomato', 'eats'],
            'Hotels and Restaurants' => ['hotel', 'resort', 'stay', 'restaurant', 'dining']
        ];

        foreach ($categories as $category) {
            $query = \App\Models\MstCard::where('status', 'active');

            if (isset($categoryKeywords[$category])) {
                $query->where(function($q) use ($categoryKeywords, $category) {
                    $q->where('card_category', $category); // Try exact match
                    
                    foreach ($categoryKeywords[$category] as $keyword) {
                        $q->orWhere('pros', 'like', '%' . $keyword . '%')
                          ->orWhere('card_name', 'like', '%' . $keyword . '%');
                    }
                });
            } else {
                $query->where('card_category', $category);
            }

            $bestCards[$category] = $query->orderBy('rating', 'desc')
                ->take(3)
                ->get();
        }

        return view('user.index', compact('bestCards'));
    }
}
