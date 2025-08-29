<?php

namespace App\Console\Commands;

use App\Models\Doviz;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FrankfurterApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:frankfurter-api';

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
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://api.frankfurter.app/latest', [
            'amount' => 1,
            'from' => 'USD',
            'to' => 'TRY'
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $usdKur = $data['rates']['TRY'] ?? 1;

            Doviz::updateOrCreate(["doviz" => "USD"], ["kur" => $usdKur, "base" => "TRY"]);
        }
    }
}
