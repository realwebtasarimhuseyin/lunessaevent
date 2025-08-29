<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Kullanici;
use App\Models\KullaniciHareketleri;
use App\Models\Urun;
use App\Models\UrunKategori;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminIndexController extends Controller
{

    public function index()
    {

        $toplamZiyaret = KullaniciHareketleri::count();

        $populerSayfalar = KullaniciHareketleri::select(
            'url',
            DB::raw('count(*) as ziyaret_sayisi'),
            DB::raw('MAX(tarayici_isim) as en_populer_tarayici'),
            DB::raw('MAX(cihaz_tip) as en_populer_cihaiz_tip'),
            DB::raw('MAX(il.il_isim) as en_populer_il')
        )
            ->leftJoin('il', 'kullanici_hareketleri.il_id', '=', 'il.id') // 'il' tablosunu birleştiriyoruz
            ->groupBy('url')
            ->orderByDesc('ziyaret_sayisi')
            ->take(20) // İlk 20 sonucu al
            ->get();


        $populerTarayicilar = KullaniciHareketleri::select('tarayici_isim', DB::raw('count(*) as ziyaret_sayisi'))
            ->groupBy('tarayici_isim')
            ->orderByDesc('ziyaret_sayisi')
            ->get();

        $toplamZiyaretSayisi = $populerTarayicilar->sum('ziyaret_sayisi');

        $populerTarayicilar = $populerTarayicilar->map(function ($tarayici) use ($toplamZiyaretSayisi) {
            $tarayici->ziyaret_yuzdesi = $toplamZiyaretSayisi > 0 ? round(($tarayici->ziyaret_sayisi / $toplamZiyaretSayisi) * 100, 2) : 0;
            return $tarayici;
        });


        $yilBaslangic = Carbon::now()->startOfYear();
        $yilBitis = Carbon::now()->endOfYear();

        $cihazVerileriYillik = KullaniciHareketleri::selectRaw('YEAR(created_at) as yil, MONTH(created_at) as ay, cihaz_tip, COUNT(*) as toplam_giris')
            ->whereBetween('created_at', [$yilBaslangic, $yilBitis])
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'), 'cihaz_tip')
            ->orderBy('yil', 'asc')
            ->orderBy('ay', 'asc')
            ->orderByRaw('FIELD(cihaz_tip, "Bilgisayar", "Telefon", "Diğer")') // Cihaz türlerine göre sıralama
            ->get();

        $cihazVerileri = [
            'bilgisayar' => [],
            'telefon' => [],
            'diger' => []
        ];

        for ($ayNumarasi = 1; $ayNumarasi <= 12; $ayNumarasi++) {
            $bilgisayarVerisi = $cihazVerileriYillik->firstWhere(function ($item) use ($ayNumarasi) {
                return $item->ay == $ayNumarasi && $item->cihaz_tip == 'Bilgisayar';
            });
            $cihazVerileri['bilgisayar'][] = $bilgisayarVerisi ? $bilgisayarVerisi->toplam_giris : 0;

            $telefonVerisi = $cihazVerileriYillik->firstWhere(function ($item) use ($ayNumarasi) {
                return $item->ay == $ayNumarasi && $item->cihaz_tip == 'Telefon';
            });
            $cihazVerileri['telefon'][] = $telefonVerisi ? $telefonVerisi->toplam_giris : 0;

            $digerVerisi = $cihazVerileriYillik->firstWhere(function ($item) use ($ayNumarasi) {
                return $item->ay == $ayNumarasi && $item->cihaz_tip == 'Diğer';
            });
            $cihazVerileri['diger'][] = $digerVerisi ? $digerVerisi->toplam_giris : 0;
        }


        $girisVerileriYillik = KullaniciHareketleri::selectRaw('YEAR(created_at) as yil, MONTH(created_at) as ay, COUNT(*) as toplam_giris, kullanici_id')
            ->whereBetween('created_at', [$yilBaslangic, $yilBitis])
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'), 'kullanici_id')
            ->orderBy('yil', 'asc')
            ->orderBy('ay', 'asc')
            ->get();

        $kullaniciGirisleri = $girisVerileriYillik->whereNotNull('kullanici_id');
        $anonimGirisler = $girisVerileriYillik->whereNull('kullanici_id');

        $kullaniciVerileri = [];
        for ($ayNumarasi = 1; $ayNumarasi <= 12; $ayNumarasi++) {
            $kullaniciVerisi = $kullaniciGirisleri->firstWhere('ay', $ayNumarasi);
            if (!$kullaniciVerisi) {
                $kullaniciVerileri[] = 0; // Veri yoksa sıfır ekle
            } else {
                $kullaniciVerileri[] = $kullaniciVerisi->toplam_giris;
            }
        }

        $anonimVerileri = [];
        for ($ayNumarasi = 1; $ayNumarasi <= 12; $ayNumarasi++) {
            $anonimVerisi = $anonimGirisler->firstWhere('ay', $ayNumarasi);
            if (!$anonimVerisi) {
                $anonimVerileri[] = 0; // Veri yoksa sıfır ekle
            } else {
                $anonimVerileri[] = $anonimVerisi->toplam_giris;
            }
        }

        $yillikZiyaretVerileri = [
            "kullaniciVerileri" =>  $kullaniciVerileri,
            "anonimVerileri" => $anonimVerileri
        ];



        $toplamUrun = Urun::count();
        $toplamKategori = UrunKategori::count();
        $toplamKullanici = Kullanici::count();
        $toplamBlog = Blog::count();


        $toplamVeriler = [
            "toplamUrun" => $toplamUrun,
            "toplamKategori" => $toplamKategori,
            "toplamKullanici" => $toplamKullanici,
            "toplamBlog" => $toplamBlog
        ];


        return view("admin.index", compact(
            'yillikZiyaretVerileri',
            "toplamZiyaret",
            "populerSayfalar",
            "populerTarayicilar",
            "cihazVerileri",
            "toplamVeriler"
        ));
    }
}
