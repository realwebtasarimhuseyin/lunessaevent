<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class Hizmet extends Model
{
    use HasFactory;


    protected $table = 'hizmet';


    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'admin_id',
        'sira_no',
        'hizmet_kategori_id',
        'resim_url',
        'durum'
    ];

    public function scopeAktif(Builder $query)
    {
        return $query->where('durum', true);
    }


    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }


    public function hizmetKategori()
    {
        return $this->belongsTo(HizmetKategori::class, 'hizmet_kategori_id', 'id');
    }


    public function hizmetDiller()
    {
        return $this->hasMany(HizmetDil::class, 'hizmet_id', 'id');
    }

    public static function getBySlug($slug)
    {
        return self::whereHas('hizmetDiller', function ($query) use ($slug) {
            $query->where('slug', $slug)->where('dil', app()->getLocale());
        })->where('durum', true)->first();
    }

    

    public static function generateSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (HizmetDil::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
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
