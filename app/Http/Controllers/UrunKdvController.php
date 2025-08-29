<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrunKdvRequest;
use App\Models\UrunKdv;
use App\Services\UrunKdvServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class UrunKdvController extends Controller
{

    public function adminIndex()
    {
        return view("admin.urunkdv.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");
        $urunKdvler = UrunKdvServis::veriAlma($arama);

        if (!admin()->isSuperAdmin()) {
            if (!yetkiKontrol('urun-kdv-tumunugor') && yetkiKontrol('urun-kdv-gor')) {
                $urunKdvler->where('admin_id', admin()->id);
            }
        }

        return $dataTables->eloquent($urunKdvler)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function ekle()
    {
        return view("admin.urunkdv.ekle");
    }

    public function eklePost(UrunKdvRequest $request)
    {

        try {
            $veri = [
                'admin_id' => admin()->id,
                "baslik" => $request->input("baslik"),
                "kdv" => $request->input("kdv"),
                "durum" => $request->input("durum")
            ];

            UrunKdvServis::ekle($veri);

            return response()->json(["mesaj" => "Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function duzenle(UrunKdv $urunKdv)
    {
        return view("admin.urunkdv.duzenle", compact('urunKdv'));
    }

    public function duzenlePost(UrunKdvRequest $request, UrunKdv $urunKdv)
    {
        try {
            $veri = [
                "admin_id" => admin()->id,
                "baslik" => $request->input("baslik"),
                "kdv" => $request->input("kdv"),
                "durum" => $request->input("durum")
            ];

            UrunKdvServis::duzenle($urunKdv, $veri);

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function sil(UrunKdv $urunKdv)
    {
        try {
            UrunKdvServis::sil($urunKdv);
            return response()->json(["mesaj" => "Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
