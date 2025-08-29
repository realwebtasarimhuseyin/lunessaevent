<?php

namespace App\Http\Controllers;

use App\Models\Urun;
use App\Models\UrunDil;
use App\Services\UrunResimServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class ShopierController extends Controller
{
    public function fetchProducts()
    {
        // Shopier API'ye isteği gönderiyoruz
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
            'start' => 72,
            'offset' => 0,
            'filter' => 1,
            'sort' => 0,
            'filterMinPrice' => '',
            'filterMaxPrice' => '',
            'datesort' => -1,
            'pricesort' => -1,
            'value' => '',
            'activeCheckBoxes[]' => 'cat_2079303'
        ]);

        // Hata durumunda dönüş
        if (!$cevap->successful()) {
            return response()->json(['error' => 'Veri çekme işlemi başarısız.'], $cevap->status());
        }

        // Çekilen veriyi alıyoruz
        $veriler = $cevap->json();
        $urunler = $veriler['products'];


       

        // Bütün ürünleri JSON formatında döndürüyoruz
        return response()->json($urunler);
    }
}


/* 
   
     * Varyasyonların kombinasyonlarını oluşturur.
     *
     * @param array $ilkVaryasyonSecenekleri
     * @param array $ikinciVaryasyonSecenekleri
     * @return array
     
    private function getVaryasyonKombinasyonlari($ilkVaryasyonSecenekleri, $ikinciVaryasyonSecenekleri)
    {
        $kombinasyonlar = [];

        foreach ($ilkVaryasyonSecenekleri as $ilkSecenek) {
            foreach ($ikinciVaryasyonSecenekleri as $ikinciSecenek) {
                $kombinasyonlar[] = [
                    'ilkVaryasyon' => $ilkSecenek['text'],
                    'ikinciVaryasyon' => $ikinciSecenek['text']
                ];
            }
        }

        return $kombinasyonlar;
    }

                $ilkVaryasyonSecenekleri = $crawler->filter('#first_variation_group option')->each(function ($node) {
                    return [
                        'text' => trim($node->text()), // Kullanıcıya görünen değer
                        'value' => $node->attr('value') // Option value değeri
                    ];
                });

                $ikinciVaryasyonSecenekleri = $crawler->filter('#second_variation_group option')->each(function ($node) {
                    return [
                        'text' => trim($node->text()),
                        'value' => $node->attr('value')
                    ];
                });

                $ilkVaryasyonSecenekleri = array_filter($ilkVaryasyonSecenekleri, function ($secenek) {
                    return $secenek['value'] !== '-1' && strtolower($secenek['text']) !== 'seçiniz';
                });

                $ikinciVaryasyonSecenekleri = array_filter($ikinciVaryasyonSecenekleri, function ($secenek) {
                    return $secenek['value'] !== '-1' && strtolower($secenek['text']) !== 'seçiniz';
                });

                $urunDetaylari["varyasyonlar"] = [
                    'İlk Varyasyon' => array_values($ilkVaryasyonSecenekleri),
                    'İkinci Varyasyon' => array_values($ikinciVaryasyonSecenekleri),
                ];

                $kombinasyonlar = $this->getVaryasyonKombinasyonlari($ilkVaryasyonSecenekleri, $ikinciVaryasyonSecenekleri);
                $urunDetaylari['kombinasyonlar'] = $kombinasyonlar;


                */