<?php

namespace App\Http\Controllers;

use App\Http\Requests\DuyuruRequest;
use App\Models\Duyuru;
use App\Models\DuyuruKategori;
use App\Services\DuyuruKategoriServis;
use App\Services\DuyuruServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class DuyuruController extends Controller
{

    public function adminIndex()
    {
        return view("admin.duyuru.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");
        $duyurular = DuyuruServis::veriAlma($arama);
        return $dataTables->eloquent($duyurular)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function ekle()
    {
        return view("admin.duyuru.ekle");
    }

    public function eklePost(DuyuruRequest $request)
    {

        try {
            $veri = [
                "admin_id" => admin()->id,
                "durum" => $request->input("durum")
            ];

            DuyuruServis::ekle($veri, $request);

            return response()->json(["mesaj" => "Duyuru Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
    
    public function duzenle(Duyuru $duyuru)
    {
        return view("admin.duyuru.duzenle", compact(['duyuru']));
    }

    public function duzenlePost(DuyuruRequest $request, Duyuru $duyuru)
    {
        try {
            $veri = [
                "admin_id" => admin()->id,
                "durum" => $request->input("durum")
            ];

            DuyuruServis::duzenle($duyuru, $veri, $request);

            return response()->json(["mesaj" => "Duyuru Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function siralamaDuzenle(Request $request)
    {
        try {

            $duyurular = $request->input('duyurular', []);
            if (count($duyurular) > 0) {
                DuyuruServis::siralamaDuzenle($duyurular);
            }

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function sil(Duyuru $duyuru)
    {
        try {
            DuyuruServis::sil($duyuru);
            return response()->json(["mesaj" => "Duyuru Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
