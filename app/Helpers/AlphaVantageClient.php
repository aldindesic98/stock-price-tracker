<?php

namespace App\Helpers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AlphaVantageClient
{
    public static function getStockPrice(string $symbol): ?array
    {
        $url = config('app.alpha_vantage.url');
        $apiKey = config('app.alpha_vantage.api_key');

        try {
            $response = Http::retry(5, fn($attempt) => 1000 * $attempt, function ($exception, $request) {
                return $exception instanceof ConnectionException || $exception->getCode() === 429;
            })->get($url, [
                'function' => 'TIME_SERIES_INTRADAY',
                'symbol' => $symbol,
                'interval' => '1min',
                'apikey' => $apiKey
            ]);

            if ($response->failed()) {
                if ($response->status() === 429) {
                    Log::warning("Rate limit exceeded for Alpha Vantage API.");
                } else {
                    Log::error("Alpha Vantage API error: " . $response->body());
                }
                return null;
            }

            $data = $response->json();

            if (!isset($data['Time Series (1min)']) || empty($data['Time Series (1min)'])) {
                Log::warning("Alpha Vantage: No data found for symbol {$symbol}");
                return null;
            }

            $latestTimestamp = array_key_first($data['Time Series (1min)']);
            $latestData = $data['Time Series (1min)'][$latestTimestamp] ?? null;

            if (!$latestData || !isset($latestData['1. open'])) {
                Log::warning("Alpha Vantage: Incomplete data received for symbol {$symbol}");
                return null;
            }

            return [
                'symbol' => $symbol,
                'price' => (float)$latestData['1. open'],
                'recorded_at' => $latestTimestamp,
            ];
        } catch (\Exception $e) {
            Log::error("Error fetching stock price for {$symbol}: " . $e->getMessage());
            return null;
        }
    }
}
