<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class Katalog extends Model
{
    use HasFactory;


    protected $table = 'katalog';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'admin_id',
        'sira_no',
        'katalog_kategori_id',
        'resim_url',
        'dosya_url',
        'durum',
    ];

    public function scopeAktif(Builder $query)
    {
        return $query->where('durum', true);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    /**
     * Kategoriyle ilişkili dil bilgilerini getirir.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function katalogDiller()
    {
        return $this->hasMany(KatalogDil::class, 'katalog_id', 'id');
    }


    public static function getBySlug($slug)
    {
        return self::whereHas('katalogDiller', function ($sorgu) use ($slug) {
            $sorgu->where('slug', $slug)
                ->where('dil', app()->getLocale());
        })->where('durum', true)->first();
    }


    public static function slugUret($baslik)
    {
        $slug = Str::slug($baslik);
        $orijinalSlug = $slug;
        $sayi = 1;

        while (KatalogDil::where('slug', $slug)->exists()) {
            $slug = $orijinalSlug . '-' . $sayi;
            $sayi++;
        }

        return $slug;
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
