<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Il;
use App\Models\Ilce;

class ImportIlIlce extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ililceaktar'; // Komutun adı

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'İl ilçe aktarımı'; // Komut açıklaması

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $response = Http::get('https://turkiyeapi.dev/api/v1/provinces');
        $data = $response->json();
        $toplamIl = 0;
        $toplamIlce = 0;


        if ($data['status'] === 'OK') {
            foreach ($data['data'] as $provinceData) {
                $il = Il::create([
                    'il_isim' => $provinceData['name'],
                ]);
                $toplamIl += 1;
                $toplamIlce += count($provinceData['districts']);
                foreach ($provinceData['districts'] as $districtData) {
                    Ilce::create([
                        'ilce_isim' => $districtData['name'],
                        'il_id' => $il->id,
                    ]);
                }

                $this->info("{$provinceData['name']} ili ve " . count($provinceData['districts']) . " ilçesi başarıyla kaydedildi.");
            }

            $this->info("İçeriye Aktarılan Toplam İl : " .  $toplamIl);
            $this->info("İçeriye Aktarılan Toplam İlçe : " .  $toplamIlce);
        } else {
            $this->error('API\'den veri alınamadı.');
        }
    }
}
