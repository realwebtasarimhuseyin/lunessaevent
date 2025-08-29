<?php

namespace App\Services;

use App\Helper\WebpDonusturHelper;
use App\Models\Sektor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class SektorResimServis
{
    /**
     * Resmi kaydetme işlemi.
     *
     * @param UploadedFile $resim Yüklenen resim dosyası.
     * @param string $sektorBaslik Sektor başlığı (slug oluşturmak için kullanılır).
     * @param string $dizin Kaydedilecek ana dizin (varsayılan: 'sektor_resim').
     * @return string Kaydedilen resmin yolu.
     */
    public function resimKaydet(UploadedFile $resim, string $sektorBaslik, string $dizin = 'sektor_resim'): string
    {
        // sektor başlığından slug oluşturuluyor.
        $sektorBaslik = Sektor::generateSlug($sektorBaslik);

        // Resmin kaydedileceği klasör yolu oluşturuluyor.
        $klasorYolu = $dizin . "/" . $sektorBaslik;

        if (Storage::exists($klasorYolu)) {
            Storage::deleteDirectory($klasorYolu);
        }

        // Resmi kaydet
        $resimAdi = $sektorBaslik . '-' . time() . '.webp';
        $resimYolu = $klasorYolu . '/' . $resimAdi;

        WebpDonusturHelper::webpDonustur($resim, $resimYolu);

        return $resimYolu;
    }
}
