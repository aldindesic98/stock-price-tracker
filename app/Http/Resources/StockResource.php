<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'symbol' => $this->symbol,
            'latest_price' => self::getStockPriceObject($this),
            'created_at' => $this->created_at
        ];
    }

    private static function getStockPriceObject($stock): ?array
    {
        if ($stock->latestStockPrice) {
            return [
                'id' => $stock->latestStockPrice->id,
                "price" => $stock->latestStockPrice->price,
                "recorded_at" => $stock->latestStockPrice->recorded_at,
            ];
        }

        return null;
    }
}
