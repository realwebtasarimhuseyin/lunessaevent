<?php

namespace App\Http\Controllers;

use App\Http\Requests\HizmetKategoriRequest;
use App\Models\Hizmet;
use App\Models\HizmetKategori;
use App\Services\HizmetKategoriServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class HizmetKategoriController extends Controller
{

    public function index()
    {
        return view("admin.hizmetkategori.index");
    }

    public function adminIndex()
    {
        return view("admin.hizmetkategori.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $hizmetKategori = $request->query("hizmetKategori", 0);
        $hizmetAltKategoriler = HizmetKategoriServis::veriAlma($hizmetKategori)->get();
        return response()->json($hizmetAltKategoriler, 200);
    }

    public function adminTableList(Request $request, DataTables $dataTables)
    {
        //$arama = $request->query("ara", "");
        $hizmetKategoriler = HizmetKategoriServis::veriAlma();
        return $dataTables->eloquent($hizmetKategoriler)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function ekle()
    {
        return view("admin.hizmetkategori.ekle");
    }

    public function eklePost(HizmetKategoriRequest $request)
    {

        try {
            $veri = [
                "admin_id" => Auth::guard('admin')->id(),
                "durum" => $request->input("durum", 0)
            ];

            HizmetKategoriServis::ekle($veri, $request);

            return response()->json(["mesaj" => "Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function goster(HizmetKategori $hizmetKategori)
    {
        return view("admin.hizmetkategori.goster");
    }

    public function duzenle(HizmetKategori $hizmetKategori)
    {
        return view("admin.hizmetkategori.duzenle", compact('hizmetKategori'));
    }

    public function duzenlePost(HizmetKategoriRequest $request, HizmetKategori $hizmetKategori)
    {
        try {
            $veri = [
             
                "durum" => $request->input("durum", 0)
            ];

            HizmetKategoriServis::duzenle($hizmetKategori, $veri, $request);

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function transfer(Request $request)
    {
        // Gelen veriyi validasyonla kontrol edelim
        $validated = $request->validate([
            'eskiKategoriId' => 'required|exists:hizmet_kategori,id',
            'yeniKategoriId' => 'required|exists:hizmet_kategori,id|different:eskiKategoriId',
        ]);

        try {
            // Transaction içinde işlem yapalım
            return DB::transaction(function () use ($validated) {

                $eskiKategoriId = $validated['eskiKategoriId'];
                $yeniKategoriId = $validated['yeniKategoriId'];

                // Eski kategori ve yeni kategorinin varlığını kontrol et
                $eskiKategori = HizmetKategori::find($eskiKategoriId);
                if (!$eskiKategori) {
                    throw new \Exception('Eski kategori bulunamadı!');
                }

                $yeniKategori = HizmetKategori::find($yeniKategoriId);
                if (!$yeniKategori) {
                    throw new \Exception('Yeni kategori bulunamadı!');
                }

                // Eski kategorideki ürünleri yeni kategoriye toplu olarak aktaralım
                $hizmetlerGuncelleniyor = Hizmet::where('hizmet_kategori_id', $eskiKategoriId)
                    ->update(['hizmet_kategori_id' => $yeniKategoriId]);

                if ($hizmetlerGuncelleniyor === 0) {
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
                HizmetKategoriServis::siralamaDuzenle($kategoriler);
            }

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }

    }
    public function sil(HizmetKategori $hizmetKategori)
    {
        try {
            HizmetKategoriServis::sil($hizmetKategori);
            return response()->json(["mesaj" => "Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
