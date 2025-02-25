<?php

use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::get('/all-stocks', [StockController::class, 'getAllStocks']);
Route::get('/stock/{id}', [StockController::class, 'getStockById']);
Route::get('/stock-set', [StockController::class, 'getStockSet']);
Route::get('/price-change-report', [StockController::class, 'priceChangeReport']);
