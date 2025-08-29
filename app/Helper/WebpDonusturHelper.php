<?php

namespace App\Helper;

use Exception;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class WebpDonusturHelper
{
    /**
     * Bir dosyayı WebP formatına dönüştürür.
     *
     * @param string $dosya Dosya yolu (kaynak dosya).
     * @param string|null $hedef Dosya yolu (WebP formatındaki dosya). Varsayılan olarak aynı dizinde ".webp" uzantılı bir dosya oluşturur.
     * @param int $kalite WebP kalite seviyesi (0-100 arası). Varsayılan: 80.
     * @return string|false Dönüştürülen WebP dosyasının yolu veya hata durumunda false.
     */
    public static function webpDonustur($dosya, $hedef = null,  $kalite = 80, $filigran = "", $esitle = null)
    {
        if (!file_exists($dosya)) {
            return false;
        }

        try {
            $image = Image::read($dosya);

            if ($esitle) {
                $width = $image->width();
                $height = $image->height();
                
                if ($width > $height) {
                    $image->coverDown($width, $width);
                } else {
                    $image->coverDown($height, $height);
                }
            }

            if ($filigran !== "") {

                $filigran = Image::read($filigran)->rotate(25, '00000000');

                $imageWidth = $image->width();

                $filigranWidth = $imageWidth * 0.5;
                $filigranHeight = $filigran->height() * ($filigranWidth / $filigran->width()); 
               
                $filigran->resize($filigranWidth, $filigranHeight);

                $image->place($filigran, 'center', 0, 0, 45);
            }

            $image = $image->toWebp($kalite);

            return  Storage::disk('public')->put($hedef, $image);
        } catch (Exception $e) {

            dd($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine());
            die();
        }
    }
}
