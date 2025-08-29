<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class Galeri extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'galeri';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';


    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;


    protected $fillable = [
        'admin_id',
        'sira_no',
        'resim_url',
        'video_url',
        'durum'
    ];


    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }


    public function galeriDiller()
    {
        return $this->hasMany(GaleriDil::class, 'galeri_id', 'id');
    }

    public static function klasorOlusturArtanNumaraIle($uzanti)
    {
        $sayac = 1;
        $yol = $uzanti;

        while (File::exists($yol)) {
            $yol = $uzanti . '_' . $sayac;
            $sayac++;
        }

        return $yol;
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
