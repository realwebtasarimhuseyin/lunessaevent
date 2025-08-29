<?php

namespace App\Http\Controllers;

use App\Http\Requests\KatalogKategoriRequest;
use App\Models\Katalog;
use App\Models\KatalogKategori;
use App\Services\KatalogKategoriServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class KatalogKategoriController extends Controller
{

    public function index()
    {
        return view("admin.katalogkategori.index");
    }

    public function adminIndex()
    {
        return view("admin.katalogkategori.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $katalogKategori = $request->query("katalogKategori", 0);
        $katalogAltKategoriler = KatalogKategoriServis::veriAlma($katalogKategori)->get();
        return response()->json($katalogAltKategoriler, 200);
    }

    public function adminTableList(Request $request, DataTables $dataTables)
    {

        $katalogKategoriler = KatalogKategoriServis::veriAlma();
        if (!admin()->isSuperAdmin()) {
            if (!yetkiKontrol('katalog-kategori-tumunugor') && yetkiKontrol('katalog-kategori-gor')) {
                $katalogKategoriler->where('admin_id', admin()->id);
            }
        }

        return $dataTables->eloquent($katalogKategoriler)
            ->editColumn('created_at', function ($nesne) {
                return formatZaman($nesne->created_at, 'plus');
            })->toJson();
    }

    public function ekle()
    {
        return view("admin.katalogkategori.ekle");
    }

    public function eklePost(KatalogKategoriRequest $request)
    {

        try {
            $veri = [
                "admin_id" => admin()->id,
                "durum" => $request->input("durum", 0)
            ];

            KatalogKategoriServis::ekle($veri, $request);

            return response()->json(["mesaj" => "Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function goster(KatalogKategori $katalogKategori)
    {
        return view("admin.katalogkategori.goster");
    }

    public function duzenle(KatalogKategori $katalogKategori)
    {
        return view("admin.katalogkategori.duzenle", compact('katalogKategori'));
    }

    public function duzenlePost(KatalogKategoriRequest $request, KatalogKategori $katalogKategori)
    {
        try {
            $veri = [
                "admin_id" => admin()->id,
                "durum" => $request->input("durum", 0)
            ];

            KatalogKategoriServis::duzenle($katalogKategori, $veri, $request);

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function transfer(Request $request)
    {
        $validated = $request->validate([
            'eskiKategoriId' => 'required|exists:katalog_kategori,id',
            'yeniKategoriId' => 'required|exists:katalog_kategori,id|different:eskiKategoriId',
        ]);

        try {
            return DB::transaction(function () use ($validated) {

                $eskiKategoriId = $validated['eskiKategoriId'];
                $yeniKategoriId = $validated['yeniKategoriId'];

                $eskiKategori = KatalogKategori::find($eskiKategoriId);
                if (!$eskiKategori) {
                    throw new \Exception('Eski kategori bulunamadı!');
                }

                $yeniKategori = KatalogKategori::find($yeniKategoriId);
                if (!$yeniKategori) {
                    throw new \Exception('Yeni kategori bulunamadı!');
                }

                $kataloglarGuncelleniyor = Katalog::where('katalog_kategori_id', $eskiKategoriId)
                    ->update(['katalog_kategori_id' => $yeniKategoriId]);

                if ($kataloglarGuncelleniyor === 0) {
                    throw new \Exception('Aktarılacak ürün bulunamadı!');
                }

                return response()->json(['mesaj' => 'Ürünler başarıyla transfer edildi!']);
            });
        } catch (\Throwable $th) {
            return response()->json(['mesaj' => $th->getMessage()], 400);
        }
    }

    public function siralamaDuzenle(Request $request)
    {
        try {

            $kategoriler = $request->input('kategoriler', []);
            if (count($kategoriler) > 0) {
                KatalogKategoriServis::siralamaDuzenle($kategoriler);
            }

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
    public function sil(KatalogKategori $katalogKategori)
    {
        try {
            KatalogKategoriServis::sil($katalogKategori);
            return response()->json(["mesaj" => "Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
