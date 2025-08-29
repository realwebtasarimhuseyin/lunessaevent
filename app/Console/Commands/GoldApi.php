<?php

namespace App\Console\Commands;

use App\Models\Doviz;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GoldApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:gold-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get('https://api.gold-api.com/price/XAG');

        if ($response->successful()) {
            $data = $response->json();
            $fiyat = $data['price'];

            Doviz::updateOrCreate(["doviz" => "XAG"], ["kur" => $fiyat, "base" => "USD"]);
            Doviz::updateOrCreate(["doviz" => "GUMUS-GRAM"], ["kur" => ($fiyat / 31.1035), "base" => "USD"]);
        }
    }
}
