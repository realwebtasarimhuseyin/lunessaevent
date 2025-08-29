<?php

namespace App\Services;

use App\Models\Blog;
use App\Bases\BlogBase;
use App\Models\BlogDil;
use App\Models\BlogResim;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BlogServis
{
    public static function veriAlma($arama = 0, $yazar = 0)
    {
        $builder = BlogBase::veriIsleme();

        if ($arama !== "") {
            $builder->whereAny(['bd.baslik', 'bd.icerik'], 'like', "%$arama%");
        }
        if ($yazar > 0) {
            $builder->where("admin_id", $yazar);
        }

        return $builder;
    }

    public static function ekle($veri, $request)
    {
        try {
            return DB::transaction(function () use ($veri, $request) {
                $resimServis = new BlogResimServis();
                $varsayilanDil = Config::get('app.locale');

                if ($request->hasFile('resim')) {
                    $image = $request->file('resim');
                    if ($image instanceof \Illuminate\Http\UploadedFile) {
                        $veri['resim_url'] = $resimServis->resmiKaydet($image,  Blog::slugUret($request->input("baslik_$varsayilanDil")));
                    }
                }

                $blog = BlogBase::ekle($veri);
                self::blogDilleriKaydet($blog->id, $request);

                return $blog;
            });
        } catch (\Throwable $th) {
            throw new \Exception('Blog kayıt edilemedi: ' . $th->getMessage());
        }
    }

    public static function duzenle(Blog $blog, $veri, $request)
    {
        try {
            return DB::transaction(function () use ($blog, $veri, $request) {
                BlogDil::where('blog_id', $blog->id)->delete();

                $resimServis = new BlogResimServis();
                $varsayilanDil = Config::get('app.locale');

                if ($request->hasFile('resim')) {
                    $image = $request->file('resim');
                    if ($image instanceof \Illuminate\Http\UploadedFile) {
                        $veri['resim_url'] = $resimServis->resmiKaydet($image, Blog::slugUret($request->input("baslik_$varsayilanDil")), $blog);
                    }
                } else {
                    if (!empty($blog) && !empty($blog->resim_url)) {
                        if (Storage::exists($blog->resim_url)) {
                            Storage::delete($blog->resim_url);
                            $veri["resim_url"] = null;
                        }
                    }
                }

                self::blogDilleriKaydet($blog->id, $request);
                return BlogBase::duzenle($blog, $veri);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Blog düzenlenemedi: ' . $th->getFile());
        }
    }

    private static function blogDilleriKaydet($blogId, $request)
    {
        $desteklenenDil = Config::get('app.supported_locales');

        foreach ($desteklenenDil as $dil) {
            BlogDil::create([
                'blog_id' => $blogId,
                'baslik' => $request->input("baslik_$dil"),
                'icerik' => $request->input("icerik_$dil"),
                'meta_baslik' => $request->input("metaBaslik_$dil"),
                'meta_icerik' => $request->input("metaIcerik_$dil"),
                'meta_anahtar' => $request->input("metaAnahtar_$dil"),
                'slug' => Blog::slugUret($request->input("baslik_$dil")),
                'dil' => $dil,
            ]);
        }
    }

    public static function siralamaDuzenle($bloglar)
    {
        try {
            return DB::transaction(function () use ($bloglar) {

                foreach ($bloglar as $blog) {
                    $blogDetay = Blog::firstWhere('id', $blog["id"]);

                    $blogDetay->sira_no = $blog["sira"];
                    $blogDetay->save();
                }
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
    public static function sil(Blog $blog)
    {
        try {
            return DB::transaction(function () use ($blog) {
                if (!empty($blog) && !empty($blog->resim_url)) {
                    if (Storage::exists($blog->resim_url)) {
                        Storage::delete($blog->resim_url);
                    }
                }

                BlogBase::sil($blog);
            });
        } catch (\Throwable $th) {
            throw new \Exception('Blog silinemedi : ' . $th->getMessage());
        }
    }
}
