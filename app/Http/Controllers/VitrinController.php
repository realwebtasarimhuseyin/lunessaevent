<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrunRequest;
use App\Models\Favori;
use App\Models\Urun;
use App\Models\UrunAltKategoriDil;
use App\Models\UrunKategoriDil;
use App\Models\UrunKdv;
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

class VitrinController extends Controller
{

    public function index(Request $request, $tip, $kategori = null, $altKategori = null)
    {
        $arama = $request->query('q', '');

        $sayfaBasinaAdet = (int) $request->query('sayfa-adet', 20);


        if ($kategori && UrunKategoriDil::where('slug', $kategori)->first()) {
            $kategori = UrunKategoriDil::where('slug', $kategori)->first()->urun_kategori_id;
        } else {
            $kategori = null;
        }
        if ($altKategori && UrunAltKategoriDil::where('slug', $altKategori)->first()) {
            $altKategori =  UrunAltKategoriDil::where('slug', $altKategori)->first()->urun_alt_kategori_id;
        } else {
            $altKategori = null;
        }

        if ($tip == "one-cikanlar") {
            $vitrinBaslik = "Öne Çıkanlar";
        } else if ($tip == "yeni-gelenler") {
            $vitrinBaslik = "Yeni Gelenler";
        } else if ($tip == "indirim") {
            $vitrinBaslik = "İndirimler";
        }


        $minFiyat = $request->minFiyat > 0 ? (float) str_replace('TL', '', $request->input('minFiyat', 0)) : null;
        $maxFiyat = $request->maxFiyat > 0 ? (float) str_replace('TL', '', $request->input('maxFiyat', 0)) : null;
        $varyantlarDizi = $request->input('varyantlar') ? explode(',', $request->input('varyantlar')) : [];
        $markalarDizi = $request->input('markalar') ? explode(',', $request->input('markalar')) : [];


        $filtre = $request->input('filtre', null);

        $aktifDil = app()->getLocale();

        $urunler = Urun::where('durum', "1")
            ->when($arama, function ($query) use ($arama, $aktifDil) {
                return $query->whereHas('urunDiller', function ($query) use ($arama, $aktifDil) {
                    $query->where('dil', $aktifDil)
                        ->whereAny(["baslik", "kod"], "LIKE", "%{$arama}%");
                });
            })
            ->when($kategori, fn($query) => $query->where('urun_kategori_id', $kategori))
            ->when($altKategori, fn($query) => $query->where('urun_alt_kategori_id', $altKategori))
            ->when($tip !== null, function ($query) use ($tip) {
                if ($tip == "indirim") {
                    return $query->where(function ($query) {
                        $query->whereNotNull('indirim_tutar')->where('indirim_tutar', '>', 0)
                            ->orWhereNotNull('indirim_yuzde')->where('indirim_yuzde', '>', 0);
                    })->orderByRaw('(indirim_tutar + (birim_fiyat * indirim_yuzde / 100)) DESC');
                } else if ($tip == "one-cikanlar") {
                    $query->where('ozel_alan_1', true);
                } else if ($tip == "yeni-gelenler") {
                    $query->where('ozel_alan_2', true);
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
                return $query->whereRaw('(birim_fiyat - (birim_fiyat * indirim_yuzde / 100) - indirim_tutar) BETWEEN ? AND ?', [$minFiyat > 0 ? $minFiyat : 0, $maxFiyat > 0 ? $maxFiyat : PHP_INT_MAX]);
            })
            ->with([
                'urunDiller' => function ($query) use ($aktifDil) {
                    $query->where('dil', $aktifDil);
                }
            ])
            ->when($varyantlarDizi, fn($query) => $query->whereHas('secilenVaryatlar', fn($query) => $query->whereIn('urun_varyant_id', $varyantlarDizi)))
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

        return view("web.urun.vitrin", compact('urunler', 'enBuyukBirimFiyat', 'sayfalamaBilgileri', 'kategori', 'sayfaBasinaAdet', 'varyantlarDizi', 'filtre', 'minFiyat', 'maxFiyat', 'vitrinBaslik'));
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
                    ])
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
}
