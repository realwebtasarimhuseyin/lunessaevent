<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class Marka extends Model
{
    use HasFactory;

    protected $table = 'marka';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'admin_id',
        'sira_no',
        'resim_url',
        'isim',
        'slug',
        'durum',
    ];

    /**
     * Durumu aktif olan bloglar için bir sorgu kapsamı (scope).
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeAktif(Builder $query)
    {
        return $query->where('durum', true);
    }



    public function urunler()
    {
        return $this->hasMany(Urun::class, 'marka_id', 'id');
    }

    /**
     * Başlıktan benzersiz bir slug oluşturur.
     *
     * @param string $isim
     * @return string
     */
    public static function slugUret(string $isim)
    {
        $slug = Str::slug($isim);
        $orijinalSlug = $slug;
        $sayac = 1;

        while (
            self::where('slug', $slug)->exists()
        ) {
            $slug = $orijinalSlug . '-' . $sayac;
            $sayac++;
        }

        return $slug;
    }

    public static function slugBul(string $slug)
    {
        return self::where('slug', $slug);
    }


    protected static function booted()
    {
        static::deleting(function ($nesne) {
            // Silinen ürünün sıra numarasını al
            $deletedSiraNo = $nesne->sira_no;

            // Sıra numaralarını yeniden düzenle
            static::where('sira_no', '>', $deletedSiraNo)
                ->decrement('sira_no');
        });
    }
}
