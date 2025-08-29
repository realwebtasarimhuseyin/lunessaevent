<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KatalogDil extends Model
{
    use HasFactory;


    protected $table = 'katalog_dil';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'katalog_id',
        'baslik',
        'slug',
        'dil'
    ];

    public function katalog()
    {
        return $this->belongsTo(Katalog::class, 'katalog_id', 'id');
    }
}
