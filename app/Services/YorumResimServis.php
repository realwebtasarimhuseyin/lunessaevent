<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class YorumResimServis
{
    public function saveImage(UploadedFile $image, string $yorumTitle, $yorum = null): string
    {
        $directory = 'yorum_resim';
        if ($yorum && Storage::exists($yorum->resim_url)) {
            Storage::delete($yorum->resim_url);
        }

        $imageName = $this->generateImageName($yorumTitle, "png");
        $imagePath = $image->storeAs($directory, $imageName, 'public');
        return $imagePath;
    }

    protected function generateImageName(string $yorumTitle, string $extension): string
    {
        $slug = Str::slug($yorumTitle);
        return $slug . '-' . time() . '.' . $extension;
    }
}