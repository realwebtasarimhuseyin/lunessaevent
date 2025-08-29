<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Laravel\Facades\Image;


class HizmetKategoriResimServis
{
    public function resmiKaydet(UploadedFile $resim, string $hizmetKategoriSlug): string
    {
        $klasor = 'hizmet_kategori_resim/' . $hizmetKategoriSlug;

        $resimAdi = $hizmetKategoriSlug . '-' . time() . '.webp';
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
