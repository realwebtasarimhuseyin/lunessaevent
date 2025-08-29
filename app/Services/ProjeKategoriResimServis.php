<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Laravel\Facades\Image;


class ProjeKategoriResimServis
{
    public function resmiKaydet(UploadedFile $resim, string $projeKategoriSlug): string
    {
        $klasor = 'proje_kategori_resim/' . $projeKategoriSlug;

        $resimAdi = $projeKategoriSlug . '-' . time() . '.webp';
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
 