<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrunVaryantOzellikRequest;
use App\Models\UrunVaryantOzellik;
use App\Services\UrunVaryantOzellikServis;
use App\Services\UrunVaryantServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
class UrunVaryantOzellikController extends Controller
{


    public function adminIndex()
    {
        return view("admin.urunvaryantozellik.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");
        $urunVaryantOzellikler = UrunVaryantOzellikServis::veriAlma($arama);
        
        if (!admin()->isSuperAdmin()) {
            if (!yetkiKontrol('urun-varyant-ozellik-tumunugor') && yetkiKontrol('urun-varyant-ozellik-gor')) {
                $urunVaryantOzellikler->where('admin_id', admin()->id);
            }
        }

        return $dataTables->eloquent($urunVaryantOzellikler)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function ekle()
    {
        $varyantlar = UrunVaryantServis::veriAlma()->get();
        return view("admin.urunvaryantozellik.ekle", compact('varyantlar'));
    }

    public function eklePost(UrunVaryantOzellikRequest $request)
    {

        try {
            $veri = [
                "admin_id" => admin()->id,
                "urun_varyant_id" => $request->input("varyant_id"),
                "durum" => $request->input("durum")
            ];

            UrunVaryantOzellikServis::ekle($veri, $request);

            return response()->json(["mesaj" => "Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function duzenle(UrunVaryantOzellik $urunVaryantOzellik)
    {
        $varyantlar = UrunVaryantServis::veriAlma()->get();

        return view("admin.urunvaryantozellik.duzenle", compact('varyantlar', 'urunVaryantOzellik'));
    }

    public function duzenlePost(UrunVaryantOzellikRequest $request, UrunVaryantOzellik $urunVaryantOzellik)
    {
        try {
            $veri = [
                "admin_id" => admin()->id,
                "urun_varyant_id" => $request->input("varyant_id"),
                "durum" => $request->input("durum")
            ];

            UrunVaryantOzellikServis::duzenle($urunVaryantOzellik, $veri, $request);

            return response()->json(["mesaj" => "Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function siralamaDuzenle(Request $request)
    {

        try {
            $varyantOzellikler = $request->input('varyantOzellikler', []);
            if (count($varyantOzellikler) > 0) {
                UrunVaryantOzellikServis::siralamaDuzenle($varyantOzellikler);
            }

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }


    public function sil(UrunVaryantOzellik $urunVaryantOzellik)
    {
        try {
            UrunVaryantOzellikServis::sil($urunVaryantOzellik);
            return response()->json(["mesaj" => "Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
