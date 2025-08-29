<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrunKategoriRequest;
use App\Models\Urun;
use App\Models\UrunKategori;
use App\Services\UrunKategoriServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class UrunKategoriController extends Controller
{

    public function index()
    {
        return view("admin.urunkategori.index");
    }

    public function adminIndex()
    {
        return view("admin.urunkategori.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $urunKategori = $request->query("urunKategori", 0);
        $urunAltKategoriler = UrunKategoriServis::veriAlma($urunKategori)->get();
        return response()->json($urunAltKategoriler, 200);
    }

    public function adminTableList(Request $request, DataTables $dataTables)
    {

        $urunKategoriler = UrunKategoriServis::veriAlma();
        if (!admin()->isSuperAdmin()) {
            if (!yetkiKontrol('urun-kategori-tumunugor') && yetkiKontrol('urun-kategori-gor')) {
                $urunKategoriler->where('admin_id', admin()->id);
            }
        }

        return $dataTables->eloquent($urunKategoriler)
            ->editColumn('created_at', function ($nesne) {
                return formatZaman($nesne->created_at, 'plus');
            })->toJson();
    }

    public function ekle()
    {
        return view("admin.urunkategori.ekle");
    }

    public function eklePost(UrunKategoriRequest $request)
    {

        try {
            $veri = [
                "admin_id" => admin()->id,
                "menu_durum" => $request->input("menuDurum", 0),
                "anasayfa_durum" => $request->input("anaSayfaDurum", 0),
                "indirim_durum" => $request->input("indirimDurum", 0),
                "durum" => $request->input("durum", 0)
            ];

            UrunKategoriServis::ekle($veri, $request);

            return response()->json(["mesaj" => "Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function goster(UrunKategori $urunKategori)
    {
        return view("admin.urunkategori.goster");
    }

    public function duzenle(UrunKategori $urunKategori)
    {
        return view("admin.urunkategori.duzenle", compact('urunKategori'));
    }

    public function duzenlePost(UrunKategoriRequest $request, UrunKategori $urunKategori)
    {
        try {
            $veri = [
                "admin_id" => admin()->id,
                "menu_durum" => $request->input("menuDurum", 0),
                "anasayfa_durum" => $request->input("anaSayfaDurum", 0),
                "indirim_durum" => $request->input("indirimDurum", 0),
                "durum" => $request->input("durum", 0)
            ];

            UrunKategoriServis::duzenle($urunKategori, $veri, $request);

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function transfer(Request $request)
    {
        $validated = $request->validate([
            'eskiKategoriId' => 'required|exists:urun_kategori,id',
            'yeniKategoriId' => 'required|exists:urun_kategori,id|different:eskiKategoriId',
        ]);

        try {
            return DB::transaction(function () use ($validated) {

                $eskiKategoriId = $validated['eskiKategoriId'];
                $yeniKategoriId = $validated['yeniKategoriId'];

                $eskiKategori = UrunKategori::find($eskiKategoriId);
                if (!$eskiKategori) {
                    throw new \Exception('Eski kategori bulunamadı!');
                }

                $yeniKategori = UrunKategori::find($yeniKategoriId);
                if (!$yeniKategori) {
                    throw new \Exception('Yeni kategori bulunamadı!');
                }

                $urunlerGuncelleniyor = Urun::where('urun_kategori_id', $eskiKategoriId)
                    ->update(['urun_kategori_id' => $yeniKategoriId]);

                if ($urunlerGuncelleniyor === 0) {
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
                UrunKategoriServis::siralamaDuzenle($kategoriler);
            }

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
    public function sil(UrunKategori $urunKategori)
    {
        try {
            UrunKategoriServis::sil($urunKategori);
            return response()->json(["mesaj" => "Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
