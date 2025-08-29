<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrunOzellikRequest;
use App\Models\UrunOzellik;
use App\Services\UrunOzellikServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class UrunOzellikController extends Controller
{

    public function index()
    {
        return view("admin.urunozellik.index");
    }

    public function adminIndex()
    {
        return view("admin.urunozellik.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");
        $urunOzellikler = UrunOzellikServis::veriAlma($arama);
        return $dataTables->eloquent($urunOzellikler)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function ekle()
    {
        return view("admin.urunozellik.ekle");
    }

    public function eklePost(UrunOzellikRequest $request)
    {

        try {
            $veri = [
                "admin_id" => admin()->id,
                "durum" => $request->input("durum")
            ];

            UrunOzellikServis::ekle($veri, $request);

            return response()->json(["mesaj" => "Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function goster(UrunOzellik $urunOzellik)
    {
        return view("admin.urunozellik.goster");
    }

    public function duzenle(UrunOzellik $urunOzellik)
    {
        return view("admin.urunozellik.duzenle", compact('urunOzellik'));
    }

    public function duzenlePost(UrunOzellikRequest $request, UrunOzellik $urunOzellik)
    {
        try {
            $veri = [
                "admin_id" => admin()->id,
                "durum" => $request->input("durum")
            ];

            UrunOzellikServis::duzenle($urunOzellik, $veri, $request);

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function siralamaDuzenle(Request $request)
    {

        try {
            $ozellikler = $request->input('ozellikler', []);
            if (count($ozellikler) > 0) {
                UrunOzellikServis::siralamaDuzenle($ozellikler);
            }

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }



    public function sil(UrunOzellik $urunOzellik)
    {
        try {
            UrunOzellikServis::sil($urunOzellik);
            return response()->json(["mesaj" => "Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
