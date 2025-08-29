<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrunAltKategoriRequest;
use App\Models\UrunAltKategori;
use App\Services\UrunAltKategoriServis;
use App\Services\UrunKategoriServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class UrunAltKategoriController extends Controller
{

    public function index()
    {
        return view("admin.urunaltkategori.index");
    }

    public function adminIndex()
    {
        return view("admin.urunaltkategori.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $urunKategori = $request->query("urunKategori", "");
        $urunAltKategoriler = UrunAltKategoriServis::veriAlma(0, $urunKategori)->get();
        return response()->json($urunAltKategoriler, 200);
    }

    public function adminTableList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");
        $urunKategori = $request->query("urunKategori", "");
        $urunAltKategoriler = UrunAltKategoriServis::veriAlma($arama, $urunKategori);

        if (!admin()->isSuperAdmin()) {
            if (!yetkiKontrol('urun-alt-kategori-tumunugor') && yetkiKontrol('urun-alt-kategori-gor')) {
                $urunAltKategoriler->where('admin_id', admin()->id);
            }
        }

        return $dataTables->eloquent($urunAltKategoriler)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function ekle()
    {
        $kategoriler = UrunKategoriServis::veriAlma()->get();
        return view("admin.urunaltkategori.ekle", compact('kategoriler'));
    }

    public function eklePost(UrunAltKategoriRequest $request)
    {

        try {
            $veri = [
                "admin_id" => admin()->id,
                "urun_kategori_id" => $request->input("kategori_id"),
                "durum" => $request->input("durum")
            ];

            UrunAltKategoriServis::ekle($veri, $request);

            return response()->json(["mesaj" => "Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
    
    public function duzenle(UrunAltKategori $urunAltKategori)
    {
        $kategoriler = UrunKategoriServis::veriAlma()->get();
        return view("admin.urunaltkategori.duzenle", compact(['kategoriler', 'urunAltKategori']));
    }

    public function duzenlePost(UrunAltKategoriRequest $request, UrunAltKategori $urunAltKategori)
    {
        try {
            $veri = [
                "admin_id" => admin()->id,
                "urun_kategori_id" => $request->input("kategori_id"),
                "durum" => $request->input("durum")
            ];

            UrunAltKategoriServis::duzenle($urunAltKategori, $veri, $request);

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }


    public function siralamaDuzenle(Request $request)
    {

        try {
            $altKategoriler = $request->input('altKategoriler', []);
            if (count($altKategoriler) > 0) {
                UrunAltKategoriServis::siralamaDuzenle($altKategoriler);
            }

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function sil(UrunAltKategori $urunAltKategori)
    {
        try {
            UrunAltKategoriServis::sil($urunAltKategori);
            return response()->json(["mesaj" => "Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
