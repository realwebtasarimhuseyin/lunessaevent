<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class MarkaResimServis
{
        /**
     * Resmi kaydetme işlemi.
     *
     * @param UploadedFile $resim Yüklenen resim dosyası.
     * @param string $markaBaslik Marka başlığı (slug oluşturmak için kullanılır).
     * @param string $dizin Kaydedilecek ana dizin (varsayılan: 'marka_resim').
     * @return string Kaydedilen resmin yolu.
     */
    public function resimKaydet(UploadedFile $resim, string $markaBaslik, string $dizin = 'marka_resim'): string
    {
        $markaBaslik = Str::slug($markaBaslik);

        $klasor = $dizin . "/" . $markaBaslik;

        if (Storage::exists($klasor)) {
            Storage::deleteDirectory($klasor);
        }
    
        $resimAdi = $markaBaslik . '-' . time() . '.' . $resim->extension();

        $resimYolu = $resim->storeAs($klasor, $resimAdi, 'public');

        return $resimYolu;
    }



}
