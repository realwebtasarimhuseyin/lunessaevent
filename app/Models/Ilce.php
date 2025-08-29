<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ilce extends Model
{
    use HasFactory;

    protected $table = 'ilce';
    
    protected $primaryKey = 'id';

    public $timestamps = true;


    protected $fillable = [
        'ilce_isim',
        'il_id'
    ];

    public function il()
    {
        return $this->belongsTo(Il::class, 'il_id');
    }
}
