<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class Sektor extends Model
{
    use HasFactory;


    protected $table = 'sektor';


    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'admin_id',
        'sira_no',
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


    public function sektorDiller()
    {
        return $this->hasMany(SektorDil::class, 'sektor_id', 'id');
    }

    public static function getBySlug($slug)
    {
        return self::whereHas('sektorDiller', function ($query) use ($slug) {
            $query->where('slug', $slug)->where('dil', app()->getLocale());
        })->where('durum', true)->first();
    }


    public static function generateSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (SektorDil::where('slug', $slug)->exists()) {
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
