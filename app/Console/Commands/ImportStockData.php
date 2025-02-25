<?php

namespace App\Console\Commands;

use App\Actions\CreateStockPriceAction;
use App\Helpers\AlphaVantageClient;
use App\Models\Stock;
use Illuminate\Console\Command;

class ImportStockData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:stock-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $stocks = Stock::all();
        foreach ($stocks as $stock) {
            $result = AlphaVantageClient::getStockPrice($stock->symbol);

            CreateStockPriceAction::execute($result, $stock->id);
        }
    }
}
