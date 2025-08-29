<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrunVaryantRequest;
use App\Models\UrunVaryant;
use App\Services\UrunVaryantServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
class UrunVaryantController extends Controller
{

    public function index()
    {
        return view("admin.urunvaryant.index");
    }

    public function adminIndex()
    {
        return view("admin.urunvaryant.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");
        $urunVaryantlar = UrunVaryantServis::veriAlma($arama);

        if (!admin()->isSuperAdmin()) {
            if (!yetkiKontrol('urun-varyant-tumunugor') && yetkiKontrol('urun-varyant-gor')) {
                $urunVaryantlar->where('admin_id', admin()->id);
            }
        }

        return $dataTables->eloquent($urunVaryantlar)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function ekle()
    {
        return view("admin.urunvaryant.ekle");
    }

    public function eklePost(UrunVaryantRequest $request)
    {

        try {
            $veri = [
                "admin_id" => admin()->id,
                "durum" => $request->input("durum")
            ];

            UrunVaryantServis::ekle($veri, $request);

            return response()->json(["mesaj" => "Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function goster(UrunVaryant $urunVaryant)
    {
        return view("admin.urunvaryant.goster");
    }

    public function duzenle(UrunVaryant $urunVaryant)
    {
        return view("admin.urunvaryant.duzenle", compact('urunVaryant'));
    }

    public function duzenlePost(UrunVaryantRequest $request, UrunVaryant $urunVaryant)
    {
        try {
            $veri = [
                "admin_id" => admin()->id,
                "durum" => $request->input("durum")
            ];

            UrunVaryantServis::duzenle($urunVaryant, $veri, $request);

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }


   /*  public function ozellikDuzenle(UrunVaryant $urunVaryant)
    {

        return view("admin.urunvaryantozellik.ozellik", compact('urunVaryant'));
    }

    public function ozellikDuzenlePost(UrunVaryantRequest $request, UrunVaryant $urunVaryant)
    {
        try {
            $veri = [
                "admin_id" => Auth::guard('admin')->id(),
                "durum" => $request->input("durum")
            ];

            UrunVaryantServis::ekle($veri, $request);

            return response()->json(["mesaj" => "Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    } */

    public function siralamaDuzenle(Request $request)
    {

        try {
            $varyantlar = $request->input('varyantlar', []);
            if (count($varyantlar) > 0) {
                UrunVaryantServis::siralamaDuzenle($varyantlar);
            }

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }


    public function sil(UrunVaryant $urunVaryant)
    {
        try {
            UrunVaryantServis::sil($urunVaryant);
            return response()->json(["mesaj" => "Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
