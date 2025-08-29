<?php

namespace App\Services;

use App\Helper\WebpDonusturHelper;
use App\Models\Proje;
use App\Models\ProjeResim;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ProjeResimServis
{
    /**
     * Ana resmi kaydeder ve veritabanına yazar.
     * 
     * @param UploadedFile $resim Yüklenecek ana resim dosyası
     * @param int|null $projeId Ürün ID'si (isteğe bağlı)
     * @return string Kaydedilen resmin yolu
     */
    public function anaResmiKaydet(UploadedFile $resim, string $projeSlug, $projeId = null): string
    {
        $klasor = 'proje_resim/' . $projeSlug . '/ana_resim';

        // Eski ana resmi sil
        if (Storage::exists($klasor)) {
            Storage::deleteDirectory($klasor);
        }

        // Resmi kaydet
        $resimAdi = $projeSlug . '-' . time()  . '.webp';;
        $resimYolu = $klasor . '/' . $resimAdi;

        WebpDonusturHelper::webpDonustur($resim, $resimYolu);

        // Veritabanında kaydı güncelle veya oluştur
        ProjeResim::updateOrCreate(
            ['proje_id' => $projeId, 'tip' => 1],
            ['resim_url' => $resimYolu]
        );

        return $resimYolu;
    }

    /**
     * Ek resimleri kaydeder ve veritabanına yazar.
     * 
     * @param array $resimler Yüklenecek ek resim dosyaları
     * @param int|null $projeId Ürün ID'si (isteğe bağlı)
     * @return array Kaydedilen resimlerin yolları
     */
    public function ekResimleriKaydet(array $resimler, string $projeSlug, $projeId = null): array
    {

        $klasor = 'proje_resim/' . $projeSlug . '/normal_resim';
        $resimYollari = [];

        // Eski ek resimleri sil
        ProjeResim::where('proje_id', $projeId)
            ->where('tip', 2)
            ->each(function ($resim) {
                if (Storage::exists($resim->resim_url)) {
                    Storage::delete($resim->resim_url);
                }
                $resim->delete();
            });

        // Yeni resimleri kaydet
        foreach ($resimler as $key => $resim) {
            $resimAdi = $projeSlug . time() . $key . '.webp';

            $resimYolu = $klasor . '/' . $resimAdi;
            WebpDonusturHelper::webpDonustur($resim, $resimYolu);

            $resimYollari[] = $resimYolu;

            // Veritabanında kaydı oluştur
            ProjeResim::create([
                'proje_id' => $projeId,
                'resim_url' => $resimYolu,
                'tip' => 2,
            ]);
        }

        return $resimYollari;
    }
}
