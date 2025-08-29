<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class KatalogDosyaServis
{
    public function dosyaKaydet(UploadedFile $dosya, string $katalogSlug, $katalog = null): string
    {
        $klasor = 'katalog_dosya/' . $katalogSlug;

        if (!empty($katalog) || !empty($katalog->dosya_url)) {
            if (Storage::exists($katalog->dosya_url)) {
                Storage::deleteDirectory($katalog->dosya_url);
            }
        }

        $uzanti = $dosya->extension();
        $dosyaAdi = $katalogSlug . '-dosya_' . uniqid() . '.' . $uzanti;

        $dosyaYolu = $dosya->storeAs($klasor, $dosyaAdi, 'public');

        return $dosyaYolu;
    }
}
