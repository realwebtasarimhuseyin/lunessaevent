<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjeResim extends Model
{
    use HasFactory;


    protected $table = 'proje_resim';


    protected $primaryKey = 'id';

    public $timestamps = true;


    protected $fillable = [
        'proje_id',
        'resim_url',
        'tip'
    ];


    public function proje()
    {
        return $this->belongsTo(Proje::class, 'proje_id', 'id');
    }
}
