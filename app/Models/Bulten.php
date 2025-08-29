<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bulten extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bulten_mail';

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
        'eposta'
    ];
}
