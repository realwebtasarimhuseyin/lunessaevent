<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Services\BlogServis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BlogController extends Controller
{
    public function index()
    {
        $bloglar = Blog::aktif()->paginate(9, ['*'], 'sayfa');

        $sayfalamaBilgileri = (object) [
            'baslangic' => $bloglar->firstItem(),
            'bitis' => $bloglar->lastItem(),
            'toplam' => $bloglar->total(),
            'sayfa' => $bloglar->currentPage(),
            'toplamSayfa' => $bloglar->lastPage()
        ];

        return view("web.blog.index", compact('bloglar', 'sayfalamaBilgileri'));
    }

    public function adminIndex()
    {
        return view("admin.blog.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");
        $bloglar = BlogServis::veriAlma($arama);
        if (!admin()->isSuperAdmin()) {
            if (!yetkiKontrol('blog-tumunugor') && yetkiKontrol('blog-gor')) {
                $bloglar->where('admin_id', admin()->id);
            }
        }

        return $dataTables->eloquent($bloglar)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function ekle()
    {
        return view("admin.blog.ekle");
    }

    public function eklePost(BlogRequest $request)
    {

        try {
            $veri = [
                "admin_id" => admin()->id,
                "durum" => $request->input("durum")
            ];

            BlogServis::ekle($veri, $request);

            return response()->json(["mesaj" => "Blog Başarıyla Oluşturuldu !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function goster($slug)
    {
        $blog = Blog::slugBul($slug);

        if (!$blog) {
            abort(404);
        }

        // Diğer blogları rastgele getir (6 adet)
        $digerBloglar = Blog::aktif()
            ->whereNot('id', $blog->id)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        // Önceki ve sonraki blogları sıra numarasına göre getir
        $oncekiBlog = Blog::aktif()
            ->where('sira_no', '<', $blog->sira_no)
            ->orderBy('sira_no', 'desc')
            ->first();

        $sonrakiBlog = Blog::aktif()
            ->where('sira_no', '>', $blog->sira_no)
            ->orderBy('sira_no', 'asc')
            ->first();

        kullaniciHareketleri();

        return view("web.blog.detay", compact('blog', 'digerBloglar', 'oncekiBlog', 'sonrakiBlog'));
    }


    public function duzenle(Blog $blog)
    {
        return view("admin.blog.duzenle", compact('blog'));
    }

    public function duzenlePost(BlogRequest $request, Blog $blog)
    {
        try {

            $veri = [
                "admin_id" => admin()->id,
                "durum" => $request->input("durum")
            ];

            BlogServis::duzenle($blog, $veri, $request);

            return response()->json(["mesaj" => "Blog Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function siralamaDuzenle(Request $request)
    {
        try {

            $bloglar = $request->input('bloglar', []);
            if (count($bloglar) > 0) {
                BlogServis::siralamaDuzenle($bloglar);
            }

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function sil(Blog $blog)
    {
        try {
            BlogServis::sil($blog);
            return response()->json(["mesaj" => "Blog Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
