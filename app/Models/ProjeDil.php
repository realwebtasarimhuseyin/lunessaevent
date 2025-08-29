<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ProjeDil extends Model
{
    use HasFactory;

    
    protected $table = 'proje_dil';

    protected $primaryKey = 'id';

    public $timestamps = true;
    
    protected $fillable = [
        'proje_id',
        'baslik',
        'icerik',
        'meta_baslik',
        'meta_icerik',
        'meta_anahtar',
        'slug',
        'dil'
    ];
  
    public function proje()
    {
        return $this->belongsTo(Proje::class, 'proje_id', 'id');
    }
}