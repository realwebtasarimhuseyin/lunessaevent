<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogDil extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blog_dil';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';


    /**
     * Tabloda otomatik olarak `created_at` ve `updated_at` sütunlarını kullanıp kullanmadığını belirtir.
     *
     * @var bool
     */
    public $timestamps = true;



    protected $fillable = [
        'blog_id',
        'baslik',
        'icerik',
        'meta_baslik',
        'meta_icerik',
        'meta_anahtar',
        'slug',
        'dil'
    ];


    /**
     * Get the Blog instance associated with this BlogDil.
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id', 'id');
    }
}
