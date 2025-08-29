<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class SiparisUrunVaryant extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'siparis_urun_varyant';

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
        'siparis_urun_id',
        'urun_varyant_isim',
        'urun_varyant_ozellik_isim'
    ];

    public function urun()
    {
        return $this->belongsTo(Urun::class, 'urun_id', 'id');
    }
}
