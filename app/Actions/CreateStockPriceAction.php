<?php

namespace App\Actions;

use App\Models\Stock;
use App\Models\StockPrice;

class CreateStockPriceAction
{
    public static function execute(array $data, int $stockId)
    {
        $stockPrice = new StockPrice();

        $stockPrice->price = $data['price'];
        $stockPrice->recorded_at = $data['recorded_at'];
        $stockPrice->stock_id = $stockId;
        $stockPrice->save();
    }
}
