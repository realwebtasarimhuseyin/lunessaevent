<?php

namespace App\Http\Controllers;

use App\Http\Requests\SayfaYonetimRequest;
use App\Models\Ekip;
use App\Models\Hizmet;
use App\Models\HizmetKategoriDil;
use App\Models\SayfaYonetim;
use App\Services\SayfaYonetimServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class SayfaYonetimController extends Controller
{

    public function adminIndex()
    {
        return view("admin.sayfayonetim.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");
        $sayfaYonetimler = SayfaYonetimServis::veriAlma($arama);

        return $dataTables->eloquent($sayfaYonetimler)
            ->addColumn('baslik', function ($veri) {
                return getSayfaBasligi($veri->slug);
            })->editColumn('updated_at', function ($nesne) {
                return formatZaman($nesne->updated_at);
            })
            ->toJson();
    }

    public function duzenle(SayfaYonetim $sayfaYonetim)
    {
        return view("admin.sayfayonetim.duzenle", compact('sayfaYonetim'));
    }

    public function duzenlePost(SayfaYonetimRequest $request, SayfaYonetim $sayfaYonetim)
    {
        try {
            $veriler = [
                "durum" => $request->input("durum")
            ];

            SayfaYonetimServis::duzenle($sayfaYonetim, $veriler, $request);

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function siralamaDuzenle(Request $request)
    {
        try {
            $sayfayonetimler = $request->input('sayfayonetimler', []);
            if (count($sayfayonetimler) > 0) {
                SayfaYonetimServis::siralamaDuzenle($sayfayonetimler);
            }

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function iletisim()
    {
        $sayfaBaslik = __('global.iletisim');

        return view('web.sayfa.iletisim', compact('sayfaBaslik'));
    }

    public function cerezPolitikasi()
    {
        $sayfaYonetim = SayfaYonetim::where('slug', 'cerez-politikasi')->where('durum', true)->first();

        if (!$sayfaYonetim) {
            abort(404);
        }

        $sayfaBaslik = __('global.cerezPolitikasi');
        return view('web.sayfa.cerez-politikasi', compact('sayfaBaslik', 'sayfaYonetim'));
    }

    public function gizlilikPolitikasi()
    {
        $sayfaYonetim = SayfaYonetim::where('slug', 'gizlilik-politikasi')->where('durum', true)->first();

        if (!$sayfaYonetim) {
            abort(404);
        }
        $sayfaBaslik = __('global.gizlilikPolitikasi');

        return view('web.sayfa.gizlilik-politikasi', compact('sayfaBaslik', 'sayfaYonetim'));
    }

    public function hakkimizda($locale, $kategori = null)
    {
        $sayfaYonetim = SayfaYonetim::where('slug', 'hakkimizda')->where('durum', true)->first();

        if (!$sayfaYonetim) {
            abort(404);
        }

        $sayfaBaslik = __('global.hakkimizda');

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

        $sayfa_yonetim = SayfaYonetim::with('sayfaYonetimDiller')->get();

        $nasilcalisiriz = Ekip::where('durum', "1")->get();

        return view('web.sayfa.hakkimizda', compact('hizmetler', 'sayfaBaslik', 'sayfaYonetim', 'sayfa_yonetim', 'nasilcalisiriz'));
    }

    public function iadePolitikasi()
    {
        $sayfaYonetim = SayfaYonetim::where('slug', 'iade-politikasi')->where('durum', true)->first();

        if (!$sayfaYonetim) {
            abort(404);
        }
        $sayfaBaslik = __('global.iadePolitikasi');

        return view('web.sayfa.iade-politikasi', compact('sayfaBaslik', 'sayfaYonetim'));
    }

    public function mesafeliSatis()
    {
        $sayfaYonetim = SayfaYonetim::where('slug', 'mesafeli-satis')->where('durum', true)->first();

        if (!$sayfaYonetim) {
            abort(404);
        }
        $sayfaBaslik = __('global.mesafeliSatisSozlesmesi');

        return view('web.sayfa.mesafeli-satis', compact('sayfaBaslik', 'sayfaYonetim'));
    }

    public function teslimatKosullari()
    {
        $sayfaYonetim = SayfaYonetim::where('slug', 'teslimat-kosullari')->where('durum', true)->first();

        if (!$sayfaYonetim) {
            abort(404);
        }
        $sayfaBaslik = __('global.teslimatKosullari');

        return view('web.sayfa.teslimat-kosullari', compact('sayfaBaslik', 'sayfaYonetim'));
    }

    public function kvkk()
    {
        $sayfaYonetim = SayfaYonetim::where('slug', 'kvkk')->where('durum', true)->first();

        if (!$sayfaYonetim) {
            abort(404);
        }
        $sayfaBaslik = "KVKK";

        return view('web.sayfa.kvkk', compact('sayfaBaslik', 'sayfaYonetim'));
    }
}
