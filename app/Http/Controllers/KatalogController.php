<?php

namespace App\Http\Controllers;

use App\Http\Requests\KatalogRequest;
use App\Models\Il;
use App\Models\Katalog;
use App\Models\KatalogKategori;
use App\Models\Ulke;
use App\Services\KatalogServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class KatalogController extends Controller
{


    
    public function index(Request $request)
    {
        
        $arama = $request->query('q', '');
        $locale = app()->getLocale();
        $kategoriSlug = $request->query('kategori'); // URL'den kategori slug'ını al
    
        // Tüm kategorileri getir
        $katalogKategoriler = KatalogKategori::with('katalogKategoriDiller')->get();
    
        // Seçili kategoriyi bul
        $seciliKategori = null;
        if ($kategoriSlug) {
            $seciliKategori = KatalogKategori::whereHas('katalogKategoriDiller', function ($query) use ($kategoriSlug) {
                $query->where('slug', $kategoriSlug);
            })->first();
        }
    
        // Seçili kategori varsa, ona ait katalogları getir
        $kataloglar = Katalog::aktif()
            ->when($seciliKategori, function ($query) use ($seciliKategori) {
                $query->where('katalog_kategori_id', $seciliKategori->id);
            })
            ->get();
    
        return view("web.katalog.index", compact('kataloglar', 'katalogKategoriler', 'seciliKategori', 'locale'));
    }
    
    public function oem()
    {
        $kataloglar = Katalog::where('katalog_kategori_id', 2)->get();
        return view('web.katalog.oem', compact('kataloglar'));
    }
    
    public function aramaList(Request $request)
    {
        try {
            if ($request->ajax()) {

                $arama = $request->query("q", "");
                $ilId = $request->query("il", 0);

                $locale = app()->getLocale();

                $kataloglar = Katalog::aktif()
                    ->whereHas('katalogDiller', function ($query) use ($arama, $locale) {
                        if ($arama) { // Arama yapılıyorsa
                            $query->where('dil', $locale)
                                ->where('baslik', 'like', '%' . $arama . '%');
                        }
                    })
                    ->when($ilId > 0, function ($query) use ($ilId) {
                        $query->where('il_id', $ilId);
                    })
                    ->with(['katalogResimler' => function ($query) {
                        $query->where('tip', 1);
                    }])
                    ->get()
                    ->map(function ($katalog) use ($locale) {
                        $katalogDil = $katalog->katalogDiller->where('dil', $locale)->first();
                        $anaResim = $katalog->katalogResimler->first() ? Storage::url($katalog->katalogResimler->first()->resim_url) : null;

                        return [
                            'katalog_id' => $katalog->id,
                            'katalog_baslik' => $katalogDil->baslik,
                            'ana_resim' => $anaResim,
                            'slug' => $katalogDil->slug
                        ];
                    })->take(10);

                return response()->json($kataloglar, 200);
            } else {
                throw new \Exception('Maalesef ... ');
            }
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 400);
        }
    }

    public function adminIndex()
    {
        return view("admin.katalog.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $arama = $request->query("ara", "");
        $kataloglar = KatalogServis::veriAlma($arama);
        return $dataTables->eloquent($kataloglar)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }
    public function ekle()
    {
        $katalogKategoriler = KatalogKategori::aktif()->get();
        return view("admin.katalog.ekle", compact( 'katalogKategoriler'));
    }

    public function eklePost(KatalogRequest $request)
    {
        try {
            $veri = [
                "admin_id" => Auth::guard('admin')->id(),
                "katalog_kategori_id" => $request->input("kategori", 0),
                "durum" => $request->input("durum"),
            ];

            KatalogServis::ekle($veri, $request);
            return response()->json(["mesaj" => "Katalog Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function goster($locale, $slug)
    {
        $aktifDil = app()->getLocale();
        $katalog = Katalog::getBySlug($slug);

        if (!$katalog) {
            abort(404);
        }

        return view("web.katalog.detay", compact('katalog'));
    }
    public function duzenle(Katalog $katalog)
    {
        
        $katalogKategoriler = KatalogKategori::aktif()->get();
        return view("admin.katalog.duzenle", compact('katalog', 'katalogKategoriler'));
    }
    public function duzenlePost(KatalogRequest $request, Katalog $katalog)
    {
        try {

            $veri = [
                "admin_id" => Auth::guard('admin')->id(),
                "katalog_kategori_id" => $request->input("kategori", 0),
                "durum" => $request->input("durum"),
            ];

            KatalogServis::duzenle($katalog, $veri, $request);
            return response()->json(["mesaj" => "Katalog Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function siralamaDuzenle(Request $request)
    {
        try {
            $kataloglar = $request->input('kataloglar', []);
            if (count($kataloglar) > 0) {
                KatalogServis::siralamaDuzenle($kataloglar);
            }

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }


    public function sil(Katalog $katalog)
    {
        try {
            KatalogServis::sil($katalog);
            return response()->json(["mesaj" => "Katalog Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
}