<?php

namespace App\Bases;

use App\Models\Blog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class BlogBase
{
    public static function veriIsleme()
    {
        $varsayilanDil = Config::get('app.locale');
        return Blog::join('blog_dil as bd', 'blog.id', '=', 'bd.blog_id')
            ->leftJoin('admin as a', 'blog.admin_id', '=', 'a.id')
            ->select('blog.*', 'bd.baslik', 'bd.icerik', 'bd.slug', DB::raw("CONCAT(a.isim, ' ', a.soyisim) as yazar"))
            ->where('bd.dil', $varsayilanDil)
            ;
    }

    public static function ekle($veri)
    {
        $blog = Blog::create($veri);
        return $blog;
    }


    public static function duzenle(Blog $blog, $veri)
    {
        $guncelBlog = $blog->update($veri);
        return $guncelBlog;
    }

    public static function sil(Blog $blog)
    {
        return $blog->delete();
    }
}
