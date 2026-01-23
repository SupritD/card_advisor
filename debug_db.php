<?php

use App\Models\MstCard;

echo "Unique Statuses:\n";
print_r(MstCard::distinct()->pluck('status')->toArray());

echo "\nUnique Categories (Active Cards):\n";
print_r(MstCard::where('status', 'active')->distinct()->pluck('card_category')->toArray());

echo "\nTotal Active Cards: " . MstCard::where('status', 'active')->count() . "\n";
