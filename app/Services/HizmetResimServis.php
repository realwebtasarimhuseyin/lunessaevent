<?php

namespace App\Services;

use App\Helper\WebpDonusturHelper;
use App\Models\Hizmet;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class HizmetResimServis
{
    /**
     * Resmi kaydetme işlemi.
     *
     * @param UploadedFile $resim Yüklenen resim dosyası.
     * @param string $hizmetBaslik Hizmet başlığı (slug oluşturmak için kullanılır).
     * @param string $dizin Kaydedilecek ana dizin (varsayılan: 'hizmet_resim').
     * @return string Kaydedilen resmin yolu.
     */
    public function resimKaydet(UploadedFile $resim, string $hizmetBaslik, string $dizin = 'hizmet_resim'): string
    {
        // Hizmet başlığından slug oluşturuluyor.
        $hizmetBaslik = Hizmet::generateSlug($hizmetBaslik);

        // Resmin kaydedileceği klasör yolu oluşturuluyor.
        $klasorYolu = $dizin . "/" . $hizmetBaslik;

        // Eski ana resmi sil
        if (Storage::exists($klasorYolu)) {
            Storage::deleteDirectory($klasorYolu);
        }

        // Resmi kaydet
        $resimAdi = $hizmetBaslik . '-' . time() . '.webp';
        $resimYolu = $klasorYolu . '/' . $resimAdi;

        WebpDonusturHelper::webpDonustur($resim, $resimYolu);

        return $resimYolu;
    }


}
