<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Laravel\Facades\Image;

class UrunKategoriResimServis
{
    public function resmiKaydet(UploadedFile $resim, string $urunKategoriSlug): string
    {
        $klasor = 'urun_kategori_resim/' . $urunKategoriSlug;

        $resimAdi = $urunKategoriSlug . '-' . time() . '.webp';
        $resimYolu = $klasor . "/" . $resimAdi;

        if (Storage::exists($klasor)) {
            Storage::deleteDirectory($klasor);
        }

        $resim = Image::read($resim)
            ->toWebp(70);

        Storage::disk('public')->put($resimYolu, $resim);

        return $resimYolu;
    }
}
