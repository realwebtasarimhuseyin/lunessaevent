<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SssDil extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sss_dil';

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
        'sss_id',
        'baslik',
        'icerik',
        'dil'
    ];

    /**
     * Get the Sss instance associated with this SssDil.
     */
    public function sss()
    {
        return $this->belongsTo(Sss::class, 'sss_id', 'id');
    }
}
