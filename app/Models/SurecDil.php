<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class SurecDil extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'surec_dil';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';


    /**
     * Modelin zaman damgaları (timestamps) kullanıp kullanmayacağı.
     *
     * @var bool
     */
    public $timestamps = true;


    
    protected $fillable = [
        'surec_id',
        'baslik',
        'icerik',
        'dil'
    ];

    /**
     * Get the Sss instance associated with this SssDil.
     */
    public function surec()
    {
        return $this->belongsTo(Surec::class, 'surec_id', 'id');
    }
}
