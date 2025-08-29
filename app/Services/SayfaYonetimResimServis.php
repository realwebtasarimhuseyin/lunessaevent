<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class SayfaYonetimResimServis
{
    /**
     * Resmi kaydetme işlemi.
     *
     * @param UploadedFile $resim Yüklenen resim dosyası.
     * @param string $sayfaYonetimBaslik Marka başlığı (slug oluşturmak için kullanılır).
     * @param string $dizin Kaydedilecek ana dizin (varsayılan: 'sayfaYonetim_resim').
     * @return string Kaydedilen resmin yolu.
     */
    public function resimKaydet(UploadedFile $resim, string $sayfaYonetimBaslik, string $dizin = 'sayfa_resim'): string
    {
        $sayfaYonetimBaslik = Str::slug($sayfaYonetimBaslik);

        $klasor = $dizin . "/" . $sayfaYonetimBaslik;

        if (Storage::exists($klasor)) {
            Storage::deleteDirectory($klasor);
        }

        $resimAdi = $sayfaYonetimBaslik . '-' . time() . '.' . $resim->extension();

        $resimYolu = $resim->storeAs($klasor, $resimAdi, 'public');

        return $resimYolu;
    }
}
