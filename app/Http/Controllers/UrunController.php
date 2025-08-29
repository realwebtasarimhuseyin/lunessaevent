<?php

namespace App\Http\Controllers;

use App\Helper\FacebookConversionHelper;
use App\Http\Requests\UrunRequest;
use App\Models\Favori;
use App\Models\Urun;
use App\Models\UrunAltKategoriDil;
use App\Models\UrunKategoriDil;
use App\Models\UrunKdv;
use App\Models\UrunVaryant;
use App\Models\UrunVaryantOzellik;
use App\Models\UrunVaryantSecim;
use App\Services\UrunKategoriServis;
use App\Services\UrunKdvServis;
use App\Services\UrunServis;
use App\Services\UrunVaryantServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Pagination\LengthAwarePaginator;

class UrunController extends Controller
{

    public function index(Request $request, $kategori = null, $altKategori = null)
    {
        $arama = $request->query('q', '');

        $sayfaBasinaAdet = (int) $request->query('sayfa-adet', 20);

        if ($kategori && UrunKategoriDil::where('slug', $kategori)->first()) {
            $kategori = UrunKategoriDil::where('slug', $kategori)->first()->urun_kategori_id;
        } else {
            $kategori = null;
        }
        if ($altKategori && UrunAltKategoriDil::where('slug', $altKategori)->first()) {
            $altKategori = UrunAltKategoriDil::where('slug', $altKategori)->first()->urun_alt_kategori_id;
        } else {
            $altKategori = null;
        }


        $minFiyat = (int) $request->input('minFiyat', 0);
        $maxFiyat = (int) $request->input('maxFiyat', 0);
        $varyantlarDizi = $request->input('varyantlar') ? explode(',', $request->input('varyantlar')) : [];
        $markalarDizi = $request->input('markalar') ? explode(',', $request->input('markalar')) : [];


        $filtre = $request->input('filtre', null);

        $aktifDil = app()->getLocale();

        $urunler = Urun::aktif()
            ->when($arama, function ($query) use ($arama, $aktifDil) {
                return $query->whereHas('urunDiller', function ($query) use ($arama, $aktifDil) {
                    $query->where('dil', $aktifDil)
                        ->whereAny(["baslik", "stok_kod"], "LIKE", "%{$arama}%");
                });
            })
            ->when($kategori, fn($query) => $query->where('urun_kategori_id', $kategori))
            ->when($altKategori, fn($query) => $query->where('urun_alt_kategori_id', $altKategori))
            ->when($filtre !== null, function ($query) use ($filtre) {
                if ($filtre == "1") {
                    return $query->withCount('siparisUrunler')
                        ->orderByDesc('siparis_urunler_count');
                } elseif ($filtre == "2") {
                    return $query->where(function ($query) {
                        $query->whereNotNull('indirim_tutar')->where('indirim_tutar', '>', 0)
                            ->orWhereNotNull('indirim_yuzde')->where('indirim_yuzde', '>', 0);
                    })->orderByRaw('(indirim_tutar + (birim_fiyat * indirim_yuzde / 100)) DESC');
                }
            })
            ->when($filtre === "0-1" || $filtre === "1-0", function ($query) use ($filtre) {
                return $query->orderByRaw('(birim_fiyat - (birim_fiyat * indirim_yuzde / 100) - indirim_tutar) ' . ($filtre === "1-0" ? 'DESC' : 'ASC'));
            })
            ->when($filtre === "a-z" || $filtre === "z-a", function ($query) use ($filtre, $aktifDil) {
                return $query->whereHas('urunDiller', function ($query) use ($aktifDil) {
                    $query->where('dil', $aktifDil);
                })->orderByRaw(
                        "(SELECT baslik FROM urun_dil WHERE urun_dil.urun_id = urun.id AND urun_dil.dil = ? LIMIT 1) " . ($filtre === "z-a" ? 'DESC' : 'ASC'),
                        [$aktifDil]
                    );
            })
            ->when($minFiyat > 0 || $maxFiyat > 0, function ($query) use ($minFiyat, $maxFiyat) {
                return $query->whereRaw(
                    '(birim_fiyat - (birim_fiyat * indirim_yuzde / 100) - indirim_tutar) >= ? AND (birim_fiyat - (birim_fiyat * indirim_yuzde / 100) - indirim_tutar) <= ?',
                    [$minFiyat ?? 0, $maxFiyat ?? PHP_INT_MAX]
                );
            })

            ->with([
                'urunDiller' => function ($query) use ($aktifDil) {
                    $query->where('dil', $aktifDil);
                }
            ])
            ->when($varyantlarDizi, fn($query) => $query->whereHas('secilenVaryatlar', fn($query) => $query->whereJsonContains('urun_varyantlar', $varyantlarDizi)))
            ->paginate($sayfaBasinaAdet, ['*'], 'sayfa')
            ->withQueryString();

        $sayfalamaBilgileri = (object) [
            'baslangic' => $urunler->firstItem(),
            'bitis' => $urunler->lastItem(),
            'toplam' => $urunler->total(),
            'sayfa' => $urunler->currentPage(),
            'toplamSayfa' => $urunler->lastPage()
        ];


        $enBuyukBirimFiyat = Urun::max('birim_fiyat');

        kullaniciHareketleri();

        return view("web.urun.index", compact('urunler', 'enBuyukBirimFiyat', 'sayfalamaBilgileri', 'kategori', 'sayfaBasinaAdet', 'varyantlarDizi', 'markalarDizi', 'filtre', 'minFiyat', 'maxFiyat'));
    }

    public function aramaList(Request $request)
    {
        try {
            if ($request->ajax()) {

                $arama = $request->query("q");
                $kategoriId = $request->query("kategori_id");

                $urunler = Urun::where('durum', true)
                    ->whereHas('urunDiller', function ($query) use ($arama) {
                        $query->where('dil', app()->getLocale())
                            ->where('baslik', 'like', '%' . $arama . '%');
                    })
                    ->when($kategoriId, function ($query) use ($kategoriId) {
                        return $query->where('urun_kategori_id', $kategoriId);
                    })
                    ->with([
                        'urunResimler' => function ($query) {
                            $query->where('tip', 1);
                        }
                    ])->limit(12)
                    ->get()
                    ->map(function ($urun) {
                        $anaResim = $urun->urunResimler->first() ? Storage::url($urun->urunResimler->first()->resim_url) : null;
                        $urunBaslik = $urun->urunDiller->where('dil', app()->getLocale())->first()->baslik;
                        $urunSlug = $urun->urunDiller->where('dil', app()->getLocale())->first()->slug;

                        return [
                            'urun_id' => $urun->id,
                            'urun_baslik' => $urunBaslik,
                            'ana_resim' => $anaResim,
                            'fiyat' => indirimliFiyatHesapla($urun),
                            'slug' => $urunSlug
                        ];
                    });
                return response()->json(["data" => $urunler], 200);
            } else {
                throw new \Exception('Maalesef ... ');
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function adminIndex()
    {
        return view("admin.urun.index");
    }

    public function adminList(Request $request, DataTables $dataTables)
    {
        $ara = $request->query("ara", "");
        $durum = $request->query("durum", null);
        $kategori = $request->query("kategori", 0);


        $urunler = UrunServis::veriAlma($ara, $durum, $kategori);

        if (!admin()->isSuperAdmin()) {
            if (!yetkiKontrol('urun-tumunugor') && yetkiKontrol('urun-gor')) {
                $urunler->where('admin_id', admin()->id);
            }
        }

        return $dataTables->eloquent($urunler)->editColumn('created_at', function ($nesne) {
            return formatZaman($nesne->created_at, 'plus');
        })->toJson();
    }

    public function ekle()
    {

        /* $urunVaryantlar = UrunVaryant::with('urunVaryantOzellik')->get();

        // Her varyantın özelliklerini gruplayalım
        $ozellikGruplari = [];
        foreach ($urunVaryantlar as $varyant) {
            $ozellikGruplari[] = $varyant->urunVaryantOzellik;
        }

        $kombinasyonlar = $this->nVaryantKombinasyonHesapla($ozellikGruplari); */

        $kategoriler = UrunKategoriServis::veriAlma()->get();
        $kdvler = UrunKdvServis::veriAlma()->get();

        $aktifDil = 'tr';
        $varyantlar = UrunVaryant::aktif()
            ->with('urunVaryantDiller', 'urunVaryantOzellik', 'urunVaryantOzellik.urunVaryantOzellikDiller')
            ->get()
            ->mapWithKeys(function ($varyant) use ($aktifDil) {
                $varyantDil = $varyant->urunVaryantDiller->where('dil', $aktifDil)->first();

                if (!$varyantDil) {
                    return [];
                }

                return [
                    $varyantDil->isim => [
                        'id' => $varyant->id,
                        'ozellikler' => $varyant->urunVaryantOzellik->map(function ($ozellik) use ($aktifDil) {
                            $ozellikDil = $ozellik->urunVaryantOzellikDiller->where('dil', $aktifDil)->first();

                            return [
                                'id' => $ozellik->id,
                                'isim' => $ozellikDil ? $ozellikDil->isim : null,
                            ];
                        })
                    ]
                ];
            });


        return view("admin.urun.ekle", compact('kategoriler', 'varyantlar', 'kdvler'));
    }


    private function urunVaryantKombinasyonSayisi()
    {
        // Tüm varyantları özellik sayılarıyla alalım
        $urunVaryantlar = UrunVaryant::with('urunVaryantOzellik')->get();

        // Özellik sayılarının çarpımı
        $kombinasyonSayisi = $urunVaryantlar->map(function ($varyant) {
            return $varyant->urunVaryantOzellik->count();
        })->reduce(fn($carry, $item) => $carry * $item, 1);

        return "Toplam kombinasyon sayısı: " . $kombinasyonSayisi;
    }

    private function nVaryantKombinasyonHesapla($ozellikGruplari)
    {
        $kombinasyonlar = [[]];

        foreach ($ozellikGruplari as $grup) {
            $gecici = [];
            foreach ($kombinasyonlar as $kombinasyon) {
                foreach ($grup as $ozellik) {
                    $gecici[] = array_merge($kombinasyon, [$ozellik]);
                }
            }
            $kombinasyonlar = $gecici;
        }

        return $kombinasyonlar;
    }




    public function eklePost(UrunRequest $request)
    {
        try {
            $veri = [
                "admin_id" => admin()->id,
                "urun_kategori_id" => $request->input("urunKategoriId"),
                "urun_alt_kategori_id" => (int) $request->input("urunAltKategoriId", Null),
                "stok_kod" => $request->input("stokKod"),
                "stok_adet" => $request->input("stokAdet"),
                "kdv_durum" => $request->input("kdvDurum"),
                "birim_fiyat" => $request->input("birimFiyat"),
                "kdv_id" => $request->input("kdvOran"),
                "marka_id" => (int) $request->input("marka", Null),
                "indirim_yuzde" => $request->input("indirimYuzde"),
                "indirim_tutar" => $request->input("indirimTutar"),
                "durum" => $request->input("durum"),
                "ozel_alan_1" => $request->input("ozelAlan1"),
                "ozel_alan_2" => $request->input("ozelAlan2"),
            ];

            UrunServis::ekle($veri, $request);

            return response()->json(["mesaj" => "Başarıyla Eklendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function goster($slug)
    {
        $aktifDil = app()->getLocale();
        $urun = Urun::slugBul($slug);

        /* 
        $urunVaryant = urunVaryantSec($urun->id, ['1' , '4', '6']);
        $indirimliFiyat = indirimliFiyatHesapla($urun, $urunVaryant);
        echo 'İndirimli Fiyat: ' . $indirimliFiyat;
        die(); 
        */


        if (!$urun) {
            abort(404);
        }

        $seciliVaryantlar = UrunVaryantSecim::where('urun_id', $urun->id)
            ->get()->groupBy('urun_varyant_id');

        $ilgiliUrunler = Urun::where("urun_kategori_id", $urun->urun_kategori_id)
            ->where('id', '!=', $urun->id)
            ->get();

        $favoriKontrol = false;
        if (Auth::guard('web')->check()) {
            $kullaniciId = Auth::guard('web')->id();
            $favoriKontrol = Favori::where('urun_id', $urun->id)->where('kullanici_id', $kullaniciId)->exists();
        }

        kullaniciHareketleri();

        $kullaniciIndirimKontrol = null;
        if (Auth::guard('web')->check()) {
            $kullaniciIndirimKontrol = Auth::guard('web')->user()->indirimler->where('urun_kategori_id', $urun->urun_kategori_id)->first();
        }


        $seciliVaryantIdler = UrunVaryantSecim::where('urun_id', $urun->id)
            ->get()
            ->flatMap(
                fn($secim) => collect($secim->urun_varyantlar)
                    ->map(fn($ozellikId) => UrunVaryantOzellik::find($ozellikId)?->urunVaryant?->id)
                    ->filter()
            )
            ->unique()
            ->values()
            ->toArray();

        $kombinasyonlar = UrunVaryantSecim::where('urun_id', $urun->id)->get();

        FacebookConversionHelper::send('ViewContent', [
            'content_name' => $urun->urunDiller->where('dil', $aktifDil)->first()->baslik,
            'content_ids' => [$urun->id],
            'content_type' => 'product',
            'value' => max((float) $urun->birim_fiyat, 0.01),
            'currency' => 'TRY',
        ]);

        $digerurunler = Urun::where('id', '!=', $urun->id)->limit(3)->get();


        return view("web.urun.detay", compact('urun', 'digerurunler', 'seciliVaryantlar', 'ilgiliUrunler', 'favoriKontrol', 'seciliVaryantIdler', 'kombinasyonlar', 'kullaniciIndirimKontrol'));
    }

    public function duzenle(Urun $urun)
    {
        $aktifDil = 'tr';


        $kategoriler = UrunKategoriServis::veriAlma()->get();
        $kdvler = UrunKdvServis::veriAlma()->get();

        $varyantlar = UrunVaryant::aktif()
            ->with('urunVaryantDiller', 'urunVaryantOzellik', 'urunVaryantOzellik.urunVaryantOzellikDiller')
            ->get()
            ->mapWithKeys(function ($varyant) use ($aktifDil) {
                $varyantDil = $varyant->urunVaryantDiller->firstWhere('dil', $aktifDil);
                if (!$varyantDil)
                    return [];

                return [
                    $varyantDil->isim => [
                        'id' => $varyant->id,
                        'ozellikler' => $varyant->urunVaryantOzellik->map(fn($ozellik) => [
                            'id' => $ozellik->id,
                            'isim' => $ozellik->urunVaryantOzellikDiller->firstWhere('dil', $aktifDil)->isim ?? null,
                        ])
                    ]
                ];
            });


        $seciliVaryantIdler = UrunVaryantSecim::where('urun_id', $urun->id)
            ->get()
            ->flatMap(
                fn($secim) => collect($secim->urun_varyantlar)
                    ->map(fn($ozellikId) => UrunVaryantOzellik::find($ozellikId)?->urunVaryant?->id)
                    ->filter()
            )
            ->unique()
            ->values()
            ->toArray();



        $kombinasyonlar = UrunVaryantSecim::where('urun_id', $urun->id)->get();

        return view("admin.urun.duzenle", compact('urun', 'kategoriler', 'varyantlar', 'kdvler', 'seciliVaryantIdler', 'kombinasyonlar'));
    }


    public function duzenlePost(UrunRequest $request, Urun $urun)
    {
        try {

            $veri = [
                "admin_id" => admin()->id,
                "urun_kategori_id" => $request->input("urunKategoriId"),
                "urun_alt_kategori_id" => (int) $request->input("urunAltKategoriId", Null),
                "stok_kod" => $request->input("stokKod"),
                "stok_adet" => $request->input("stokAdet"),
                "kdv_durum" => $request->input("kdvDurum"),
                "birim_fiyat" => $request->input("birimFiyat"),
                "kdv_id" => $request->input("kdvOran"),
                "marka_id" => (int) $request->input("marka", Null),
                "indirim_yuzde" => $request->input("indirimYuzde"),
                "indirim_tutar" => $request->input("indirimTutar"),
                "durum" => $request->input("durum"),
                "ozel_alan_1" => $request->input("ozelAlan1"),
                "ozel_alan_2" => $request->input("ozelAlan2"),
            ];

            UrunServis::duzenle($urun, $veri, $request);

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
    public function siralamaDuzenle(Request $request)
    {

        try {

            $urunler = $request->input('urunler', []);
            if (count($urunler) > 0) {
                UrunServis::siralamaDuzenle($urunler);
            }

            return response()->json(["mesaj" => "Başarıyla Güncellendi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }
    public function sil(Urun $urun)
    {
        try {
            UrunServis::sil($urun);
            return response()->json(["mesaj" => "Başarıyla Silindi !"], 200);
        } catch (\Throwable $th) {
            return response()->json(["mesaj" => $th->getMessage()], 400);
        }
    }

    public function AramaUrunler(Request $request, $locale, $kategori = null, $altKategori = null)
    {

        $arama = $request->query('q', '');

        $sayfaBasinaAdet = (int) $request->query('sayfa-adet', 20);

        if ($kategori && UrunKategoriDil::where('slug', $kategori)->first()) {
            $kategori = UrunKategoriDil::where('slug', $kategori)->first()->urun_kategori_id;
        } else {
            $kategori = null;
        }
        if ($altKategori && UrunAltKategoriDil::where('slug', $altKategori)->first()) {
            $altKategori = UrunAltKategoriDil::where('slug', $altKategori)->first()->urun_alt_kategori_id;
        } else {
            $altKategori = null;
        }


        $minFiyat = (int) $request->input('minFiyat', 0);
        $maxFiyat = (int) $request->input('maxFiyat', 0);
        $varyantlarDizi = $request->input('varyantlar') ? explode(',', $request->input('varyantlar')) : [];
        $markalarDizi = $request->input('markalar') ? explode(',', $request->input('markalar')) : [];


        $filtre = $request->input('filtre', null);


        $aktifDil = app()->getLocale();


        $urunler = Urun::aktif()
            ->when($arama, function ($query) use ($arama, $aktifDil) {
                return $query->whereHas('urunDiller', function ($query) use ($arama, $aktifDil) {
                    $query->where('dil', $aktifDil)
                        ->whereAny(["baslik", "stok_kod"], "LIKE", "%{$arama}%");
                });
            })
            ->when($kategori, fn($query) => $query->where('urun_kategori_id', $kategori))
            ->when($altKategori, fn($query) => $query->where('urun_alt_kategori_id', $altKategori))
            ->orderBy('sira_no', 'ASC') // ***BURADA SIRALAMA EKLENDİ!***
            ->when($filtre !== null, function ($query) use ($filtre) {
                if ($filtre == "1") {
                    return $query->withCount('siparisUrunler')
                        ->orderByDesc('siparis_urunler_count');
                } elseif ($filtre == "2") {
                    return $query->where(function ($query) {
                        $query->whereNotNull('indirim_tutar')->where('indirim_tutar', '>', 0)
                            ->orWhereNotNull('indirim_yuzde')->where('indirim_yuzde', '>', 0);
                    })->orderByRaw('(indirim_tutar + (birim_fiyat * indirim_yuzde / 100)) DESC');
                }
            })
            ->when($filtre === "0-1" || $filtre === "1-0", function ($query) use ($filtre) {
                return $query->orderByRaw('(birim_fiyat - (birim_fiyat * indirim_yuzde / 100) - indirim_tutar) ' . ($filtre === "1-0" ? 'DESC' : 'ASC'));
            })
            ->when($filtre === "a-z" || $filtre === "z-a", function ($query) use ($filtre, $aktifDil) {
                return $query->whereHas('urunDiller', function ($query) use ($aktifDil) {
                    $query->where('dil', $aktifDil);
                })->orderByRaw(
                        "(SELECT baslik FROM urun_dil WHERE urun_dil.urun_id = urun.id AND urun_dil.dil = ? LIMIT 1) " . ($filtre === "z-a" ? 'DESC' : 'ASC'),
                        [$aktifDil]
                    );
            })
            ->when($minFiyat > 0 || $maxFiyat > 0, function ($query) use ($minFiyat, $maxFiyat) {
                return $query->whereRaw(
                    '(birim_fiyat - (birim_fiyat * indirim_yuzde / 100) - indirim_tutar) >= ? AND (birim_fiyat - (birim_fiyat * indirim_yuzde / 100) - indirim_tutar) <= ?',
                    [$minFiyat ?? 0, $maxFiyat ?? PHP_INT_MAX]
                );
            })

            ->with([
                'urunDiller' => function ($query) use ($aktifDil) {
                    $query->where('dil', $aktifDil);
                }
            ])
            ->when($varyantlarDizi, fn($query) => $query->whereHas('secilenVaryatlar', fn($query) => $query->whereJsonContains('urun_varyantlar', $varyantlarDizi)))
            ->paginate($sayfaBasinaAdet, ['*'], 'sayfa')
            ->withQueryString();


        $sayfalamaBilgileri = (object) [
            'baslangic' => $urunler->firstItem(),
            'bitis' => $urunler->lastItem(),
            'toplam' => $urunler->total(),
            'sayfa' => $urunler->currentPage(),
            'toplamSayfa' => $urunler->lastPage()
        ];


        $enBuyukBirimFiyat = Urun::max('birim_fiyat');

        kullaniciHareketleri();

        return view("web.urun.arama-urun", compact('urunler', 'enBuyukBirimFiyat', 'sayfalamaBilgileri', 'kategori', 'altKategori', 'sayfaBasinaAdet', 'varyantlarDizi', 'markalarDizi', 'filtre', 'minFiyat', 'maxFiyat'));
    }
}
