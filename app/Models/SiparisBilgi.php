<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiparisBilgi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'siparis_bilgi';

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
        'isim',
        'sirket_isim',
        'tc_vergi_no',
        'vergi_dairesi',
        'eposta',
        'telefon',
        'adres',
        "fatura_adres"
    ];
}
