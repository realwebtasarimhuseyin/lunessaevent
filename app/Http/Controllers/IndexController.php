<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Ekip;
use App\Models\Hizmet;
use App\Models\HizmetKategoriDil;
use App\Models\Marka;
use App\Models\Popup;
use App\Models\SayfaYonetim;
use App\Models\Slider;
use App\Models\Sss;
use App\Models\Urun;
use App\Models\Galeri;
use App\Models\Yorum;


class IndexController extends Controller
{

    public function index($locale, $kategori = null)
    {
        $sliderlar = Slider::aktif()->orderBy('sira_no', 'asc')->get();
        $popuplar = Popup::aktif()->where('baslangic_tarih', '<=', now())
            ->where('bitis_tarih', '>=', now())->get();
        $oneCikanUrunler = Urun::aktif()->where('ozel_alan_1', true)->where('stok_adet', '>', 0)->orderBy('sira_no', 'asc')->limit(4)->get();
        $yeniGelenUrunler = Urun::aktif()->where('ozel_alan_2', true)->where('stok_adet', '>', 0)->orderBy('sira_no', 'asc')->limit(4)->get();
        $indirimliUrunler = Urun::aktif()->whereNotNull('indirim_tutar')->where('stok_adet', '>', 0)->where('indirim_tutar', '>', 0)
            ->orWhereNotNull('indirim_yuzde')->where('indirim_yuzde', '>', 0)->orderBy('sira_no', 'asc')->limit(4)->get();

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


        $bloglar = Blog::aktif()->paginate(9, ['*'], 'sayfa');

        $sayfalamaBilgileri = (object) [
            'baslangic' => $bloglar->firstItem(),
            'bitis' => $bloglar->lastItem(),
            'toplam' => $bloglar->total(),
            'sayfa' => $bloglar->currentPage(),
            'toplamSayfa' => $bloglar->lastPage()
        ];

        $sayfa_yonetim = SayfaYonetim::with('sayfaYonetimDiller')->get();
        $sayfaYonetim = SayfaYonetim::with('sayfaYonetimDiller')
            ->whereIn('id', [1, 2, 3, 7, 8, 9, 10, 11, 12])
            ->get(); // first() yerine get() kullan çünkü birden fazla kayıt alıyoruz.

        $surecler = Sss::where('durum', "1")->get();

        
        $markalar = Marka::where('durum', "1")->get();

        $nasilcalisiriz = Ekip::where('durum', "1")->get();

        $galeriler = Galeri::where('durum', "1")->limit(6)->get();

        $yorumlar = Yorum::where('durum', "1")->get();

        return view("web.index", compact('markalar','yorumlar', 'galeriler', 'nasilcalisiriz', 'surecler', 'bloglar', 'sayfaYonetim', 'sayfa_yonetim', 'sliderlar', 'popuplar', 'oneCikanUrunler', 'yeniGelenUrunler', 'indirimliUrunler', 'hizmetler'));
    }
}
