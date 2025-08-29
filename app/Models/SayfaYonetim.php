<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SayfaYonetim extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sayfa_yonetim';

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


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'admin_id',
        'sira_no',
        'resim_url',
        'resim_izin',
        'slug',
        'durum',
    ];


    /**
     * Get the SayfaYonetim instance by its slug.
     *
     * @param string $slug
     * @return \App\Models\SayfaYonetim|null
     */
    public static function slugBul($slug)
    {
        return self::where('slug', $slug)->first();
    }

    public function sayfaYonetimDiller()
    {
        return $this->hasMany(SayfaYonetimDil::class, 'sayfa_yonetim_id', 'id');
    }
}
