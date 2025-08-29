<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Urun;
use App\Models\UrunDil;
use App\Services\UrunResimServis;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;


class ShopierVeriCek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:shopier';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shopier API üzerinden veri çekme işlemi ve ürün detaylarının alınması';


    public function handle()
    {
        $this->info("Shopier'den ürünler çekiliyor...");

        $cevap = Http::withHeaders([
            'Accept' => '*/*',
            'Accept-Encoding' => 'gzip, deflate, br, zstd',
            'Accept-Language' => 'tr-TR,tr;q=0.8',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Origin' => 'https://www.shopier.com',
            'Referer' => 'https://www.shopier.com/s/store/GULERCASUAL',
            'Sec-Fetch-Dest' => 'empty',
            'Sec-Fetch-Mode' => 'cors',
            'Sec-Fetch-Site' => 'same-origin',
            'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36',
            'X-Requested-With' => 'XMLHttpRequest',
            'X-Csrf-Token' => '7387ce5c62d20ee179cf286e3e2bb14d6a828b17aac530ec9d7f166eb64674b40ea760748cfa529607291b2efadb70',
            'Cookie' => 'PHPSESSID=dpreeI8q5d42oaa931eamfmbui'
        ])->asForm()->post('https://www.shopier.com/s/api/v1/search_product/GULERCASUAL', [
                    'start' => 90,
                    'offset' => 0,
                    'filter' => 1,
                    'sort' => 0,
                    'filterMinPrice' => '',
                    'filterMaxPrice' => '',
                    'datesort' => -1,
                    'pricesort' => -1,
                    'value' => '',
                ]);

        if (!$cevap->successful()) {
            $this->error("Veri çekme işlemi başarısız.");
            return;
        }

        $veriler = $cevap->json();
        $urunler = $veriler['products'];


        foreach ($urunler as $urun) {
            $urun['full_link'] = 'https://www.shopier.com/s/' . $urun['link'];
            $urunSayfasi = Http::get($urun['full_link']);

            if ($urunSayfasi->successful()) {
                $crawler = new Crawler($urunSayfasi->body());
                $resimServis = new UrunResimServis();

                $urunDetaylari = [
                    'ad' => $crawler->filter('div.product-name')->text(),
                    'resim' => $crawler->filter('img.js-product-image-slide')->attr('src'),
                    'fiyat' => str_replace(',', '.', str_replace('.', '', $crawler->filter('.product-price span.price-value')->text())),
                    'aciklama' => $crawler->filter('.product-info-desc')->text(),
                    'resimler' => $crawler->filter('div.product-gallery-main img')->each(fn($node) => $node->attr('src')),
                ];

                $urunDetaylari['resimler'] = array_slice($urunDetaylari['resimler'], 1);

                DB::transaction(function () use ($resimServis, $urunDetaylari) {

                    $urunDil = UrunDil::where('baslik', $urunDetaylari['ad'])->first();

                    if (!empty($urunDil)) {

                        $this->info($urunDil->baslik);


                        $urunId = $urunDil->urun_id;

                        $resimServis->tumResimleriSil($urunId);

                        $anaResimUrl = $urunDetaylari['resim'];
                        $anaResimDosyasi = file_get_contents($anaResimUrl);
                        $anaResimPath = tempnam(sys_get_temp_dir(), 'urun_') . '.jpg';
                        file_put_contents($anaResimPath, $anaResimDosyasi);

                        $anaResim = new \Illuminate\Http\UploadedFile($anaResimPath, basename($anaResimPath));
                        $resimServis->anaResmiKaydet($anaResim, $urunDil->slug, $urunId);


                        $ekResimler = [];
                        foreach ($urunDetaylari['resimler'] as $resimUrl) {
                            $resimDosyasi = file_get_contents($resimUrl);
                            $resimPath = tempnam(sys_get_temp_dir(), 'urun_') . '.jpg';
                            file_put_contents($resimPath, $resimDosyasi);

                            $ekResimler[] = new \Illuminate\Http\UploadedFile($resimPath, basename($resimPath));
                        }

                        $resimServis->ekResimleriKaydet($ekResimler, $urunDil->slug, $urunId);

                    }




                });
            }

        }

        $this->info("Ürünler başarıyla çekildi ve kaydedildi. adet:" . count($urunler));
    }
}
