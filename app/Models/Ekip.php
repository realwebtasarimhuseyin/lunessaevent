<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Ekip extends Model
{
    use HasFactory;


    protected $table = 'ekip';


    protected $primaryKey = 'id';


    public $timestamps = true;

    protected $fillable = [
        'admin_id',
        'sira_no',
        'resim_url',
        'isim',
        'unvan',
        'durum',
    ];


    public function scopeAktif(Builder $query)
    {
        return $query->where('durum', true);
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
