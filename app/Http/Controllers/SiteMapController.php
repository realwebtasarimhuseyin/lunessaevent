<?php

namespace App\Http\Controllers;

use Spatie\Sitemap\SitemapGenerator;

class SiteMapController extends Controller
{
    /**
     * Site haritasını günceller.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function guncelle()
    {
        try {
            SitemapGenerator::create(env('APP_URL').'/')
                ->getSitemap()
                ->writeToFile(public_path('sitemap.xml'));

            return response()->json('Site Map Güncellendi!', 200);
        } catch (\Throwable $th) {
            return response()->json('Site Map Güncellenemedi!', 404);
        }
    }

    /**
     * Site haritasını indirir.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function indir()
    {
        $filePath = public_path('sitemap.xml'); // Site haritasının yolu

        // Dosyanın mevcut olup olmadığını kontrol et
        if (file_exists($filePath)) {
            return response()->download($filePath, 'sitemap.xml');
        }
        // Dosya yoksa hata mesajı döndür
        return response()->json('Site Map Dosyası Bulunamadı!', 404);
    }
}
