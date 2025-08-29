<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class TcmbDovizFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-tcmb-doviz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'TCMB döviz verilerini çek ve veritabanına kaydet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $key = env('TCMB_API_KEY'); // API anahtarını environment değişkenlerinden alıyoruz.
        $series = 'TP.DK.EUR.S.YTL'; // Sabit seri
        $today = Carbon::now();

        // Eğer saat 10:30'dan önceyse bir önceki günü alıyoruz.
        if ($today->hour < 10 || ($today->hour == 10 && $today->minute < 30)) {
            $today = $today->subDay();
        }

        // Eğer gün hafta sonuna denk geliyorsa bir önceki Cuma'yı alıyoruz.
        if ($today->isWeekend()) {
            $today = $today->previous(Carbon::FRIDAY);
        }

        $formattedDate = $today->format('d-m-Y');

        $url = "https://evds2.tcmb.gov.tr/service/evds/series={$series}&startDate={$formattedDate}&endDate={$formattedDate}&type=json&aggregationTypes=avg&formulas=0&frequency=1";

        try {
            $response = Http::withHeaders([
                'key' => $key,
            ])->get($url);

            if ($response->successful()) {
                $data = $response->json();

                $exchangeRate = $data["items"][0]["TP_DK_EUR_S_YTL"] ?? 0;

                if (!empty($exchangeRate) && $exchangeRate > 0) {
                    // Veritabanına kaydetme işlemi
                    \App\Models\Doviz::updateOrCreate(
                        ["doviz" => "euro"],
                        ["kur" => $exchangeRate]
                    );
                }


                $this->info("Döviz kuru başarıyla güncellendi: $exchangeRate");
            } else {
                $this->error("Hata: İstek başarısız oldu.");
            }
        } catch (\Exception $e) {
            $this->error("Hata: " . $e->getMessage());
        }
    }
}
