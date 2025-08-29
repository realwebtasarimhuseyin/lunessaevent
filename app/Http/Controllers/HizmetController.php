<?php

namespace App\Http\Controllers;

use App\Http\Requests\HizmetRequest;
use App\Models\Hizmet;
use App\Models\HizmetKategori;
use App\Models\HizmetKategoriDil;
use App\Services\HizmetKategoriServis;
use App\Services\HizmetServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class HizmetController extends Controller
{

    public function index($locale, $kategori = null)
    {
        $hizmetler = Hizmet::aktif();

        if ($kategori) {
            $hizmetKategoriDil = HizmetKategoriDil::where('slug', $kategori)->first();

            if ($hizmetKategoriDil) {
                $kategori = $hizmetKategoriDil->hizmetKategori;
                $hizmetler = $hizmetler->where('hizmet_kategori_id', $kategori->id);
            } else {
                abort(404);
            }
        }

        $hizmetler = $hizmetler->get();

        return view("web.hizmet.index", compact('hizmetler', 'kategori'));
    }

    public function adminIndex()
    {
        return view("admin.hizmet.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");
        $hizmetler = HizmetServis::veriAlma($arama);
        return $dataTables->eloquent($hizmetler)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function ekle()
    {
        $hizmetKategoriler = HizmetKategori::aktif()->get();
        return view("admin.hizmet.ekle", compact('hizmetKategoriler'));
    }

    public function eklePost(HizmetRequest $request)
    {

        try {
            $veri = [
                "admin_id" => Auth::guard('admin')->id(),
                "hizmet_kategori_id" => $request->input('kategori'),
                "durum" => $request->input("durum")
            ];

            HizmetServis::ekle($veri, $request);

            return response()->json(["mesaj" => "Hizmet Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function goster($slug, $kategori = null)
    {
        // $hizmet = Hizmet::getBySlug($slug)->get();

         $hizmet = Hizmet::getBySlug($slug);

        if (!$hizmet) {
            abort(404);
        }

        // $hizmetKategoriDil = HizmetKategoriDil::where('slug', $kategori)->firstOrFail();

        // if ($hizmetKategoriDil->hizmet_kategori_id !== $hizmet->hizmet_kategori_id) {
        //     abort(404);
        // }

        return view("web.hizmet.detay", compact('hizmet'));
    }


    public function duzenle(Hizmet $hizmet)
    {
        return view("admin.hizmet.duzenle", compact('hizmet'));
    }

    public function duzenlePost(HizmetRequest $request, Hizmet $hizmet)
    {
        try {
            $veri = [
                "hizmet_kategori_id" => $request->input('kategori'),
                "durum" => $request->input("durum")
            ];

            HizmetServis::duzenle($hizmet, $veri, $request);

            return response()->json(["mesaj" => "Hizmet Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }


    public function siralamaDuzenle(Request $request)
    {

        try {

            $hizmetler = $request->input('hizmetler', []);
            if (count($hizmetler) > 0) {
                HizmetServis::siralamaDuzenle($hizmetler);
            }

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function sil(Hizmet $hizmet)
    {
        try {
            HizmetServis::sil($hizmet);
            return response()->json(["mesaj" => "Hizmet Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function search(Request $request)
    {
        $arama = $request->input('query'); // Kullanıcının aradığı kelimeyi al

        $hizmetler = Hizmet::aktif()
            ->when($arama, function ($query) use ($arama) {
                $query->where('adi', 'like', "%{$arama}%")
                    ->orWhere('aciklama', 'like', "%{$arama}%");
            })
            ->get();

        return view("web.hizmet.index", compact('hizmetler', 'arama'));
    }
}
