<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiparisUrun extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'siparis_urun';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Bu modelde `created_at` ve `updated_at` timestamp alanlarının kullanılıp kullanılmayacağını belirtir.
     *
     * @var bool
     */
    public $timestamps = true;



    protected $fillable = [
        'siparis_id',
        'urun_id',
        'urun_baslik',
        'kdv_oran',
        'kdv_durum',
        'adet',
        'birim_fiyat',
        'iscilik_fiyat'
    ];


    public function urun()
    {
        return $this->belongsTo(Urun::class, 'urun_id', 'id');
    }

    public function siparisUrunVaryant()
    {
        return $this->hasMany(SiparisUrunVaryant::class, 'siparis_urun_id', 'id');
    }

    public function getTutarlarAttribute()
    {

        $kdvOrani = $this->kdv_oran;
        $BirimFiyat = $this->birim_fiyat;
        $kdvDahilMi = $this->kdv_durum;

        if ($kdvDahilMi) {
            $toplamTutar = $BirimFiyat;
            $BirimFiyat = $BirimFiyat / (1 + ($kdvOrani / 100));
            $KdvTutar = $BirimFiyat * ($kdvOrani / 100);
        } else {
            $KdvTutar = $BirimFiyat * ($kdvOrani / 100);
            $toplamTutar = $BirimFiyat + $KdvTutar;
        }

        return [
            "BirimFiyat" => $BirimFiyat,
            "KdvTutar" => $KdvTutar,
            "ToplamTutar" => $toplamTutar
        ];
    }
}
