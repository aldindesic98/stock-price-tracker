<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    public function stockPrices(): HasMany
    {
        return $this->hasMany(StockPrice::class, 'stock_id', 'id');
    }

    public function latestStockPrice(): HasOne
    {
        return $this->hasOne(StockPrice::class, 'stock_id', 'id')->latestOfMany();
    }
}
