<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Laravel\Facades\Image;

class KatalogKategoriResimServis
{
    public function resmiKaydet(UploadedFile $resim, string $katalogKategoriSlug): string
    {
        $klasor = 'katalog_kategori_resim/' . $katalogKategoriSlug;

        $resimAdi = $katalogKategoriSlug . '-' . time() . '.webp';
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
