<?php

namespace App\Services;

use App\Helper\WebpDonusturHelper;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class BlogResimServis
{
    public function resmiKaydet(UploadedFile $resim, string $blogSlug, $blog = null): string
    {
        $klasor = 'blog_resim/' . $blogSlug;

        if (!empty($blog) || !empty($blog->resim_url)) {
            if (Storage::exists($blog->resim_url)) {
                Storage::deleteDirectory($blog->resim_url);
            }
        }

        $hedef = $klasor . '/' . $blogSlug . '-' . time() . '.webp';
        WebpDonusturHelper::webpDonustur($resim, $hedef, 80);

        $resimYolu = $hedef ;

        return $resimYolu;
    }
}
