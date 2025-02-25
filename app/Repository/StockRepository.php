<?php

namespace App\Repository;

use App\Models\Stock;
use App\Models\StockPrice;
use Illuminate\Support\Facades\Cache;

class StockRepository
{
    public static function getAll()
    {
        return Cache::remember('all_stocks_cache', config('app.cache_validity_period'), function () {
            return Stock::with('latestStockPrice')->get();
        });
    }

    public static function getById($id)
    {
        return Cache::remember("stock_{$id}_cache", config('app.cache_validity_period'), function () use ($id) {
            return Stock::with('latestStockPrice')->find($id);
        });
    }

    public static function getByIds(array $ids)
    {
        return collect($ids)->map(function ($id) {
            return Cache::remember("stock_{$id}_cache", config('app.cache_validity_period'), function () use ($id) {
                return Stock::with('latestStockPrice')->find($id);
            });
        })->filter();
    }

    public static function getPriceChange($request)
    {
        $stockIds = $request->stock_ids;
        $startDateTime = $request->startDateTime;
        $endDateTime = $request->endDateTime;

        $result = [];

        foreach ($stockIds as $stockId) {
            $stock = Stock::find($stockId);
            if (!$stock) {
                continue;
            }

            $startPrice = StockPrice::where('stock_id', $stockId)
                ->where('recorded_at', '<=', $startDateTime)
                ->orderBy('recorded_at', 'desc')
                ->value('price');

            $endPrice = StockPrice::where('stock_id', $stockId)
                ->where('recorded_at', '<=', $endDateTime)
                ->orderBy('recorded_at', 'desc')
                ->value('price');

            if ($startPrice && $endPrice) {
                $result[$stock->name] = ($endPrice - $startPrice) / $startPrice;
            } else {
                $result[$stock->name] = null;
            }
        }

        return $result;
    }

}
