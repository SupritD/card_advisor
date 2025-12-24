<?php

namespace Database\Seeders;

use App\Models\MstCard;
use Illuminate\Database\Seeder;

class MstCardSeeder extends Seeder
{
    public function run(): void
    {
        MstCard::insert([
            [
                'bank_name' => 'ICICI Bank',
                'card_name' => 'Amazon Pay Credit Card',
                'network_type' => 'Visa',
                'card_category' => 'Credit',
                'card_tier' => 'Platinum',
                'joining_fee' => 0,
                'annual_fee' => 0,
                'pros' => "• 5% cashback on Amazon\n• 2% on partner merchants\n• No annual fee",
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bank_name' => 'HDFC Bank',
                'card_name' => 'Millennia Credit Card',
                'network_type' => 'MasterCard',
                'card_category' => 'Credit',
                'card_tier' => 'Signature',
                'joining_fee' => 1000,
                'annual_fee' => 1000,
                'pros' => "• 5% cashback on online spends\n• Airport lounge access\n• Fuel surcharge waiver",
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bank_name' => 'SBI',
                'card_name' => 'SimplyCLICK Credit Card',
                'network_type' => 'Visa',
                'card_category' => 'Credit',
                'card_tier' => 'Gold',
                'joining_fee' => 499,
                'annual_fee' => 499,
                'pros' => "• 10X rewards on online spends\n• Amazon & BookMyShow offers\n• Welcome e-voucher",
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bank_name' => 'Axis Bank',
                'card_name' => 'Neo Credit Card',
                'network_type' => 'RuPay',
                'card_category' => 'Credit',
                'card_tier' => 'Classic',
                'joining_fee' => 0,
                'annual_fee' => 0,
                'pros' => "• Zomato & Myntra discounts\n• Utility bill cashback\n• Zero annual fee",
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bank_name' => 'Kotak Mahindra Bank',
                'card_name' => '811 Debit Card',
                'network_type' => 'Visa',
                'card_category' => 'Debit',
                'card_tier' => 'Standard',
                'joining_fee' => 0,
                'annual_fee' => 299,
                'pros' => "• Online & offline usage\n• Contactless payments\n• International acceptance",
                'status' => 'inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
