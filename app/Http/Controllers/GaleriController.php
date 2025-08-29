<?php

namespace App\Http\Controllers;

use App\Http\Requests\GaleriRequest;
use App\Models\Galeri;
use App\Services\GaleriServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class GaleriController extends Controller
{

    public function index()
    {
        $galeriler = Galeri::where('durum', true)->get();
        return view("web.galeri.index", compact('galeriler'));
    }

    public function adminIndex()
    {
        return view("admin.galeri.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");
        $galeriler = GaleriServis::veriAlma($arama);
        return $dataTables->eloquent($galeriler)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function ekle()
    {
        return view("admin.galeri.ekle");
    }

    public function eklePost(GaleriRequest $request)
    {

        try {
            $veri = [
                "admin_id" => Auth::guard('admin')->id(),
                "durum" => $request->input("durum")
            ];

            GaleriServis::ekle($veri, $request);

            return response()->json(["mesaj" => "Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function goster(Galeri $galeri)
    {
        return view("admin.galeri.goster");
    }

    public function duzenle(Galeri $galeri)
    {
        return view("admin.galeri.duzenle", compact('galeri'));
    }

    public function duzenlePost(GaleriRequest $request, Galeri $galeri)
    {
        try {
            $veri = [
                "durum" => $request->input("durum")
            ];

            GaleriServis::duzenle($galeri, $veri, $request);

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }


    public function siralamaDuzenle(Request $request)
    {

        try {

            $galeriler = $request->input('galeriler', []);
            if (count($galeriler) > 0) {
                GaleriServis::siralamaDuzenle($galeriler);
            }

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function sil(Galeri $galeri)
    {
        try {

            GaleriServis::sil($galeri);
            return response()->json(["mesaj" => "Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
