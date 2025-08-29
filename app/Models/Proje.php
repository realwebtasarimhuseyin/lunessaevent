<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class Proje extends Model
{
    use HasFactory;


    protected $table = 'proje';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'admin_id',
        'sira_no',
        'proje_kategori_id',
        'il_id',
        'tarih',
        'tur',
        'alan',
        'asama',
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

    public function il()
    {
        return $this->belongsTo(Il::class, 'il_id', 'id');
    }

    public function projeDiller()
    {
        return $this->hasMany(ProjeDil::class, 'proje_id', 'id');
    }

    public function projeResimler()
    {
        return $this->hasMany(ProjeResim::class, 'proje_id', 'id');
    }


    public static function getBySlug($slug)
    {
        return self::whereHas('projeDiller', function ($sorgu) use ($slug) {
            $sorgu->where('slug', $slug)
                ->where('dil', app()->getLocale());
        })->where('durum', true)->first();
    }


    public static function slugUret($baslik)
    {
        $slug = Str::slug($baslik);
        $orijinalSlug = $slug;
        $sayi = 1;

        while (ProjeDil::where('slug', $slug)->exists()) {
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
