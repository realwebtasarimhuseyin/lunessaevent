<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siparis extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'siparis';

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
        'kullanici_id',
        'kod',
        'kupon_kod',
        'indirim_tutar',
        'kargo_tutar',
        'kapida_odeme_tutar',
        'toplam_tutar',
        'odeme_tip',
        'durum'
    ];

    public function scopeKod(Builder $builder, $kod)
    {
        return $builder->where('kod', $kod);
    }

    public function kullanici()
    {
        return $this->belongsTo(Kullanici::class, 'kullanici_id', 'id');
    }

    public function siparisBilgi()
    {
        return $this->belongsTo(SiparisBilgi::class, 'id', 'siparis_id');
    }

    public function siparisUrun()
    {
        return $this->hasMany(SiparisUrun::class, 'siparis_id', 'id');
    }

    public function durumText()
    {
        return match ($this->durum) {
            0 => 'Ödeme Başarısız',
            1 => 'Ödeme Bekliyor',
            2 => 'Ödeme Alındı',
            3 => 'Sipariş Hazırlanıyor',
            4 => 'Kargoya Verildi',
            5 => 'Teslim Edildi',
            6 => 'İptal Edildi',
            default => 'Bilinmiyor'
        };
    }

    public function getButunTutarlarAttribute()
    {
        $araToplam = 0;
        $toplamBirimFiyat = 0;
        $toplamKdvTutar = 0;
        $toplamIscilikTutar = 0;

        $this->load('siparisUrun.urun');

        foreach ($this->siparisUrun as $siparisUrun) {
            $kdvOrani = $siparisUrun->kdv_oran;
            $BirimFiyat = $siparisUrun->birim_fiyat;
            $kdvDahilMi = $siparisUrun->kdv_durum;

            if ($kdvDahilMi) {
                $toplamTutar = $BirimFiyat;
                $BirimFiyat = $BirimFiyat / (1 + ($kdvOrani / 100));
                $araToplam += $BirimFiyat;
                $KdvTutar = $BirimFiyat * ($kdvOrani / 100);
            } else {
                $araToplam += $BirimFiyat;
                $KdvTutar = $BirimFiyat * ($kdvOrani / 100);
                $toplamTutar = $BirimFiyat + $KdvTutar;
            }

            $toplamKdvTutar += $KdvTutar;
            $toplamBirimFiyat += $toplamTutar;
            $toplamIscilikTutar += $siparisUrun->iscilik_fiyat;
        }

        $genelTutar = $toplamBirimFiyat - ($this->indirim_tutar ?? 0) + ($this->kargo_tutar ?? 0) + ($this->kapida_odeme_tutar ?? 0);

        return [
            "ara_toplam" => $araToplam,
            "kdv_toplam" => $toplamKdvTutar,
            "iscilik_toplam" => $toplamIscilikTutar,
            "genel_toplam" => $genelTutar,
        ];
    }
}
