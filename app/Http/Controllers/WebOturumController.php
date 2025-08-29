<?php

namespace App\Http\Controllers;

use App\Models\Kullanici;
use App\Models\Sepet;
use App\Models\Siparis;
use App\Services\KullaniciServis;
use App\Services\SepetServis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class WebOturumController extends Controller
{public function profil()
   {
       // Sadece web guard'ı ile oturum açan kullanıcılar için
       $kullaniciId = Auth::guard('web')->id();
       $siparisler = Siparis::where('kullanici_id', $kullaniciId)->get();
   
       $siparisBilgiler = [
           'toplamSiparis' => Siparis::where('kullanici_id', $kullaniciId)->count(),
           'toplamHarcama' => Siparis::where('kullanici_id', $kullaniciId)->where('durum', 5)->sum('toplam_tutar'),
           'toplamIndirim' =>  Siparis::where('kullanici_id', $kullaniciId)->where('durum', 5)->sum('indirim_tutar')
       ];

       return view("web.kullanici.profil", compact('siparisler', 'siparisBilgiler'));
   }
   
   public function siparis()
   {
      // Sadece web guard'ı ile oturum açan kullanıcılar için
      $kullaniciId = Auth::guard('web')->id();
      $siparisler = Siparis::where('kullanici_id', $kullaniciId)->get();

      return view("web.kullanici.siparis", compact('siparisler'));
   }

   public function profilDuzenle(Request $request)
   {
      // Sadece web guard'ı ile oturum açmış kullanıcılar için
      if (Auth::guard('web')->check()) {
         if ($request->ajax()) {
            $eposta = $request->input("eposta");
            $epostaVarmi = Kullanici::where('eposta', $eposta)->exists();
            if ($request->input("eposta") == Auth::guard("web")->user()->eposta || !$epostaVarmi) {
               $request->validate([
                  'eposta' => 'required|email',
                  'isimSoyisim' => 'required|string|max:255',
                  'telefon' => 'required|string',
               ]);

               try {
                  $veri = [
                     "isim_soyisim" => $request->input('isimSoyisim'),
                     "eposta" => $request->input('eposta'),
                     "telefon" => $request->input('telefon'),
                     "sifre" => Hash::make($request->input('sifre')),
                  ];
                  if ($request->filled('sifre')) {
                     $veri['sifre'] = Hash::make($request->input('sifre'));
                  }

                  $kullanici = Kullanici::where('id', Auth::guard('web')->id())->first();
                  KullaniciServis::duzenle($kullanici, $veri);

                  return response()->json([
                     "mesaj" => "Bilgiler Güncellendi"
                  ], 200);
               } catch (\Exception $e) {
                  return response()->json([
                     "mesaj" => "Bilgiler Güncellenemedi",
                     "hata" => $e->getMessage(),
                  ], 500);
               }
            } else {
               return response()->json([
                  "mesaj" => __('global.epostaMevcut')
               ], 400);
            }
         } else {
            return response()->json(["mesaj" => "Hatalı istek!"], 403);
         }
      } else {
         return response()->json(["mesaj" => "Yetkisiz erişim!"], 403);
      }
   }

   public function giris()
   {
      return view("web.kullanici.giris");
   }

   public function girisPost(Request $request)
   {
      if ($request->ajax()) {

         $request->validate([
            'eposta' => 'required|email',
            'sifre' => 'required|string',
         ]);

         $credentials = [
            'eposta' => $request->input('eposta'),
            'password' => $request->input('sifre')
         ];

         $remember = $request->boolean("remember");

         $kullanici = Kullanici::where('eposta', $credentials['eposta'])
            ->where('durum', 1)
            ->first();

         if ($kullanici && Auth::guard('web')->attempt($credentials, $remember)) {

            $request->session()->regenerate();

            $kullaniciId = Auth::guard('web')->id();


            return response()->json([
               "mesaj" => __('global.girisBasarili')
            ], 200);
         }

         return response()->json(["mesaj" => __('global.girisBasarisiz')], 403);
      }

      return response()->json(["mesaj" => "Hatalı istek!"], 403);
   }


   public function kayit()
   {
      return view("web.kullanici.kayit");
   }

   public function kayitPost(Request $request)
   {

      if ($request->ajax()) {
         $eposta = $request->input("eposta");
         $epostaVarmi = Kullanici::where('eposta', $eposta)->exists();
         if (!$epostaVarmi) {
            try {
               $request->validate([
                  'isimSoyisim' => 'required|string|max:255',
                  'eposta' => 'required|email',
                  'telefon' => 'required|string',
                  'sifre' => 'required|string',
               ]);

               $veri = [
                  "isim_soyisim" => $request->input('isimSoyisim'),
                  "eposta" => $request->input('eposta'),
                  "telefon" => $request->input('telefon'),
                  "sifre" => Hash::make($request->input('sifre')),
               ];

               KullaniciServis::ekle($veri);

               return response()->json([
                  "mesaj" => __('global.kayitBasarili')
               ], 200);
            } catch (\Exception $e) {
               return response()->json([
                  "mesaj" => __('global.kayitBasarisiz'),
                  "hata" => $e->getMessage(),
               ], 500);
            }
         } else {
            return response()->json([
               "mesaj" => __('global.epostaMevcut')
            ], 400);
         }
      } else {
         return response()->json(["mesaj" => "Hatalı istek!"], 403);
      }
   }

   public function cikis(Request $request)
   {
      Auth::guard('web')->logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();

      return redirect()->route('index');
   }

   private function sepetVerisiHazirla($kullaniciId)
   {
      return ["urunler" => Sepet::where('kullanici_id', admin()->id)
         ->get()
         ->map(function ($item) {
            $urun = $item->urun;
            $urunDilVerisi = $urun->urunDiller->where('dil', app()->getLocale())->first();
            $anaResim = $urun->urunResimler->where('ana_resim', true)->first();

            return [
               "ana_resim" => $anaResim ? depolamaUrl($anaResim) : null,
               'id' => $item->urun_id,
               'urun_baslik' => $urunDilVerisi->baslik,
               'adet' => $item->adet,
               'slug' => route('urun-detay', ['slug' => $urunDilVerisi->slug]),
               'birim_fiyat' => indirimliFiyatHesapla($urun),
               'varyantlar' => $item->sepetUrunVaryant->map(function ($varyant) {

                  return $varyant->varyantOzellik->id;
               })->toArray()
            ];
         })->toArray()];
   }
}
