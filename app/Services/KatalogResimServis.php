<?php

namespace App\Services;

use App\Helper\WebpDonusturHelper;
use App\Models\Katalog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class KatalogResimServis
{
    public function resmiKaydet(UploadedFile $resim, string $katalogSlug, $katalog = null): string
    {
        $klasor = 'katalog_resim/' . $katalogSlug;

        if (!empty($katalog) || !empty($katalog->resim_url)) {
            if (Storage::exists($katalog->resim_url)) {
                Storage::deleteDirectory($katalog->resim_url);
            }
        }

        $hedef = $klasor . '/' . $katalogSlug . '-' . time() . '.webp';
        WebpDonusturHelper::webpDonustur($resim, $hedef, 80);

        $resimYolu = $hedef;

        return $resimYolu;
    }
}
