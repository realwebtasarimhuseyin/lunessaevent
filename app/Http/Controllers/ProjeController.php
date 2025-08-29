<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjeRequest;
use App\Models\Il;
use App\Models\Proje;
use App\Models\ProjeKategori;
use App\Models\Ulke;
use App\Services\ProjeServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class ProjeController extends Controller
{
    public function index(Request $request)
    {
        $projeToplamBilgi = [
            'devamEdenProje' => Proje::where('asama', 1)->count(),
            'tamamlananProje' => Proje::where('asama', 2)->count(),

        ];


        $arama = $request->query('q', '');
        $locale = app()->getLocale();

        $projeler = Proje::aktif()->when($arama, function ($query) use ($arama, $locale) {
            return $query->whereHas('projeDiller', function ($query) use ($arama, $locale) {
                $query->where('dil', $locale)
                    ->where('baslik', 'like', '%' . $arama . '%');
            });
        })->get();

        return view("web.proje.index", compact('projeler'));
    }
    public function aramaList(Request $request)
    {
        try {
            if ($request->ajax()) {

                $arama = $request->query("q", "");
                $ilId = $request->query("il", 0);

                $locale = app()->getLocale();

                $projeler = Proje::aktif()
                    ->whereHas('projeDiller', function ($query) use ($arama, $locale) {
                        if ($arama) { // Arama yapılıyorsa
                            $query->where('dil', $locale)
                                ->where('baslik', 'like', '%' . $arama . '%');
                        }
                    })
                    ->when($ilId > 0, function ($query) use ($ilId) {
                        $query->where('il_id', $ilId);
                    })
                    ->with([
                        'projeResimler' => function ($query) {
                            $query->where('tip', 1);
                        }
                    ])
                    ->get()
                    ->map(function ($proje) use ($locale) {
                        $projeDil = $proje->projeDiller->where('dil', $locale)->first();
                        $anaResim = $proje->projeResimler->first() ? Storage::url($proje->projeResimler->first()->resim_url) : null;

                        return [
                            'proje_id' => $proje->id,
                            'proje_baslik' => $projeDil->baslik,
                            'ana_resim' => $anaResim,
                            'slug' => $projeDil->slug
                        ];
                    })->take(10);

                return response()->json($projeler, 200);
            } else {
                throw new \Exception('Maalesef ... ');
            }
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 400);
        }
    }

    public function adminIndex()
    {
        return view("admin.proje.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");
        $projeler = ProjeServis::veriAlma($arama);
        return $dataTables->eloquent($projeler)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }
    public function ekle()
    {
        $iller = Il::all();
        $projeKategoriler = ProjeKategori::aktif()->get();
        return view("admin.proje.ekle", compact('iller', 'projeKategoriler'));
    }

    public function eklePost(ProjeRequest $request)
    {
        try {
            $veri = [
                "admin_id" => Auth::guard('admin')->id(),
                "proje_kategori_id" => $request->input("kategori"),
                "il_id" => $request->input("il"),
                "tur" => $request->input('tur'),
                "alan" => $request->input('alan'),
                "asama" => $request->input('asama'),
                "tarih" => $request->input('tarih'),
                "durum" => $request->input("durum"),
            ];

            ProjeServis::ekle($veri, $request);
            return response()->json(["mesaj" => "Proje Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function goster($slug)
    {
        $aktifDil = app()->getLocale();
        $proje = Proje::getBySlug($slug);

        if (!$proje) {
            abort(404);
        }

        return view("web.proje.detay", compact('proje'));
    }
    public function duzenle(Proje $proje)
    {
        $iller = Il::all();
        $projeKategoriler = ProjeKategori::aktif()->get();

        return view("admin.proje.duzenle", compact('proje', 'iller', 'projeKategoriler'));
    }
    public function duzenlePost(ProjeRequest $request, Proje $proje)
    {
        try {

            $veri = [
                "admin_id" => Auth::guard('admin')->id(),
                "proje_kategori_id" => $request->input("kategori"),
                "il_id" => $request->input("il"),
                "tur" => $request->input('tur'),
                "alan" => $request->input('alan'),
                "asama" => $request->input('asama'),
                "tarih" => $request->input('tarih'),
                "durum" => $request->input("durum"),
            ];

            ProjeServis::duzenle($proje, $veri, $request);
            return response()->json(["mesaj" => "Proje Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function siralamaDuzenle(Request $request)
    {
        try {
            $projeler = $request->input('projeler', []);
            if (count($projeler) > 0) {
                ProjeServis::siralamaDuzenle($projeler);
            }

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }


    public function sil(Proje $proje)
    {
        try {
            ProjeServis::sil($proje);
            return response()->json(["mesaj" => "Proje Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}
