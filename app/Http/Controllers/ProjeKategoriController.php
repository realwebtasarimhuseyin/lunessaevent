<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjeKategoriRequest;
use App\Models\Proje;
use App\Models\ProjeKategori;
use App\Services\ProjeKategoriServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProjeKategoriController extends Controller
{

    public function index()
    {
        return view("admin.projekategori.index");
    }

    public function adminIndex()
    {
        return view("admin.projekategori.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $projeKategori = $request->query("projeKategori", 0);
        $projeAltKategoriler = ProjeKategoriServis::veriAlma($projeKategori)->get();
        return response()->json($projeAltKategoriler, 200);
    }

    public function adminTableList(Request $request, DataTables $dataTables)
    {
        //$arama = $request->query("ara", "");
        $projeKategoriler = ProjeKategoriServis::veriAlma();
        return $dataTables->eloquent($projeKategoriler)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function ekle()
    {
        return view("admin.projekategori.ekle");
    }

    public function eklePost(ProjeKategoriRequest $request)
    {

        try {
            $veri = [
                "admin_id" => Auth::guard('admin')->id(),
                "durum" => $request->input("durum", 0)
            ];

            ProjeKategoriServis::ekle($veri, $request);

            return response()->json(["mesaj" => "Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function goster(ProjeKategori $projeKategori)
    {
        return view("admin.projekategori.goster");
    }

    public function duzenle(ProjeKategori $projeKategori)
    {
        return view("admin.projekategori.duzenle", compact('projeKategori'));
    }

    public function duzenlePost(ProjeKategoriRequest $request, ProjeKategori $projeKategori)
    {
        try {
            $veri = [
                "admin_id" => Auth::guard('admin')->id(),
                "durum" => $request->input("durum", 0)
            ];

            ProjeKategoriServis::duzenle($projeKategori, $veri, $request);

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function transfer(Request $request)
    {
        $validated = $request->validate([
            'eskiKategoriId' => 'required|exists:proje_kategori,id',
            'yeniKategoriId' => 'required|exists:proje_kategori,id|different:eskiKategoriId',
        ]);

        try {
            return DB::transaction(function () use ($validated) {

                $eskiKategoriId = $validated['eskiKategoriId'];
                $yeniKategoriId = $validated['yeniKategoriId'];

                // Eski kategori ve yeni kategorinin varlığını kontrol et
                $eskiKategori = ProjeKategori::find($eskiKategoriId);
                if (!$eskiKategori) {
                    throw new \Exception('Eski kategori bulunamadı!');
                }

                $yeniKategori = ProjeKategori::find($yeniKategoriId);
                if (!$yeniKategori) {
                    throw new \Exception('Yeni kategori bulunamadı!');
                }

                // Eski kategorideki ürünleri yeni kategoriye toplu olarak aktaralım
                $projelerGuncelleniyor = Proje::where('proje_kategori_id', $eskiKategoriId)
                    ->update(['proje_kategori_id' => $yeniKategoriId]);

                if ($projelerGuncelleniyor === 0) {
                    throw new \Exception('Aktarılacak ürün bulunamadı!');
                }

                return response()->json(['mesaj' => 'Ürünler başarıyla transfer edildi!']);
            });
        } catch (\Throwable $th) {
            // Hata mesajını döndürüyoruz
            return response()->json(['mesaj' => $th->getMessage()], 400);
        }
    }

    public function siralamaDuzenle(Request $request)
    {

        try {

            $kategoriler = $request->input('kategoriler', []);
            if (count($kategoriler) > 0) {
                ProjeKategoriServis::siralamaDuzenle($kategoriler);
            }

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
    public function sil(ProjeKategori $projeKategori)
    {
        try {
            ProjeKategoriServis::sil($projeKategori);
            return response()->json(["mesaj" => "Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
