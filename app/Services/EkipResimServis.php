<?php

namespace App\Services;

use App\Helper\WebpDonusturHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class EkipResimServis
{
    public function resimKaydet(UploadedFile $resim, string $ekipIsim, $ekip = null): string
    {
        $klasor = 'ekip_resim';
        if ($ekip && Storage::exists($ekip->resim_url)) {
            Storage::delete($ekip->resim_url);
        }

        $resimAdi =  Str::slug($ekipIsim) .  "-" . time()  . '.webp';
        $resimYolu = $klasor . '/' . $resimAdi;

        WebpDonusturHelper::webpDonustur($resim, $resimYolu);

        return $resimYolu;
    }
}
