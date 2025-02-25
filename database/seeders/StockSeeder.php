<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stocks = [
            ['name' => 'Apple Inc.', 'symbol' => 'AAPL'],
            ['name' => 'Microsoft Corporation', 'symbol' => 'MSFT'],
            ['name' => 'Meta Platforms', 'symbol' => 'META'],
            ['name' => 'Alphabet Inc. (Google)', 'symbol' => 'GOOGL'],
            ['name' => 'Amazon.com, Inc.', 'symbol' => 'AMZN'],
        ];

        foreach ($stocks as $stock) {
            Stock::create($stock);
        }
    }
}
