<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\MstCard;
use Illuminate\Support\Str;

class CardImportSeeder extends Seeder
{
    public function run()
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MstCard::truncate(); // Clear old data first
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Excel::import(new class implements ToModel, WithStartRow {
            public function startRow(): int
            {
                return 2; // Skip header
            }

            public function model(array $row)
            {
                // New Schema:
                // 0: Bank Name
                // 1: Card Name
                // 2: Network Type
                // 3: Card Category
                // 4: Joining Fee
                // 5: Annual Fee
                // 6: Pros

                if (empty($row[1]))
                    return null; // Check Card Name presence

                $bankName = trim($row[0]);
                $cardName = trim($row[1]);
                $networkType = trim($row[2]);
                if (stripos($networkType, 'master') !== false) {
                    $networkType = 'MasterCard';
                }
                $category = trim($row[3]);

                // Parse Fees (handle strings like "499+GST" or numbers)
                // If numeric, take it. If string, extract number.
                $joiningFee = $this->parseFee($row[4]);
                $annualFee = $this->parseFee($row[5]);

                $pros = $row[6] ?? '';

                return MstCard::updateOrCreate(
                    ['card_name' => $cardName],
                    [
                        'bank_name' => $bankName,
                        'network_type' => $networkType ?: 'Visa',
                        'card_category' => $category,
                        'joining_fee' => $joiningFee,
                        'annual_fee' => $annualFee,
                        'pros' => $pros,
                        'status' => 'active'
                    ]
                );
            }

            private function parseFee($value)
            {
                if (empty($value))
                    return 0;
                $valStr = (string) $value;
                if (preg_match('/(\d+)/', str_replace(',', '', $valStr), $matches)) {
                    return (float) $matches[1];
                }
                return 0;
            }
        }, base_path('card details.xlsx'));
    }
}
