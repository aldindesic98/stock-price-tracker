<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriceChangeReportRequest;
use App\Http\Requests\StockSetRequest;
use App\Http\Resources\StockResource;
use App\Models\Stock;
use App\Repository\StockRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StockController extends Controller
{
   public function getAllStocks(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
   {
       return StockResource::collection(StockRepository::getAll());
   }

    public function getStockById($id): StockResource
    {
        return StockResource::make(StockRepository::getById($id));
    }

    public function getStockSet(StockSetRequest $request)
    {
        return StockResource::collection(StockRepository::getByIds($request->stock_ids));
    }

    public function priceChangeReport(PriceChangeReportRequest $request)
    {
        $price = StockRepository::getPriceChange($request);

        return new JsonResponse(['price_change'=> $price]);
    }
}
