<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\FavoriController;
use App\Http\Controllers\FtpController;
use App\Http\Controllers\IletisimFormController;
use App\Http\Controllers\BultenController;
use App\Http\Controllers\HizmetController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\KuponController;
use App\Http\Controllers\OdemeController;
use App\Http\Controllers\ParamPosController;
use App\Http\Controllers\SayfaYonetimController;
use App\Http\Controllers\SepetController;
use App\Http\Controllers\SifreSifirlaController;
use App\Http\Controllers\SiparisController;
use App\Http\Controllers\SssController;
use App\Http\Controllers\UrunController;
use App\Http\Controllers\WebOturumController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KargoController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\MarkaController;
use App\Http\Controllers\ProjeController;
use App\Http\Controllers\ProjelerimizController;
use App\Http\Controllers\SertifikilarimizController;
use App\Http\Controllers\VitrinController;
use App\Http\Controllers\ShopierController;
use App\Http\Controllers\GaleriController;


Route::get('/ftp', [FtpController::class, 'index'])->name('ftp.index');
Route::post('/ftp/upload', [FtpController::class, 'upload'])->name('ftp.upload');
Route::get('/ftp-klasor-agaci', [FtpController::class, 'klasorAgaci'])->name('ftp.klasor.agaci');
Route::get('/ftp-klasor-agaci-detayli', [FtpController::class, 'klasorAgaciDetayli'])->name('ftp.klasor.agaci.detayli');

require __DIR__ . '/auth.php';

require __DIR__ . '/admin.php';

/* Route::get('/shopier/products', [ShopierController::class, 'fetchProducts']);
 */
Route::get("/urunler/ajax", [UrunController::class, "aramaList"]);

Route::post('/hesabim/duzenle', [WebOturumController::class, "profilDuzenle"])->middleware('auth');
Route::post('/iletisim/ekle', [IletisimFormController::class, "eklePost"]);
Route::post('/ebulten/ekle', [BultenController::class, "eklePost"]);

Route::prefix('siparis')->name('siparis.')->group(function () {
    Route::post('/ekle', [SiparisController::class, "eklePost"])->name('ekle');
    Route::get('/detay', [SiparisController::class, "siparisDetay"])->name('detay');
});

Route::prefix('favori')->group(function () {
    Route::post('/ekle', [FavoriController::class, "ekle"]);
    Route::post('/sil', [FavoriController::class, "sil"]);
})->middleware('auth:web');

Route::prefix('sepet')->group(function () {
    Route::get('/liste', [SepetController::class, "liste"]);
    Route::post('/duzenle', [SepetController::class, "duzenle"]);
    Route::post('/sil', [SepetController::class, "sil"]);
});

Route::prefix('kupon')->group(function () {
    Route::get('/kontrol', [KuponController::class, "kontrol"]);
    Route::get('/iptal', [KuponController::class, "iptal"]);
});

Route::middleware('kupon.kontrol')->group(function () {

    Route::middleware('auth')->prefix('/hesabim')->name('hesabim.')->group(function () {
        Route::get('/', [WebOturumController::class, "profil"])->name("index");
        Route::post('/duzenle', [WebOturumController::class, "profilDuzenle"]);
        Route::get('/siparisler/{kod}', [SiparisController::class, "index"])->name('musteri-siparis-detay');
    });

    Route::get('/', [IndexController::class, "index"])->name("index");

    Route::get('/giris', [WebOturumController::class, "giris"])->name('giris')->middleware('guest:web');
    Route::post('/giris', [WebOturumController::class, "girisPost"])->middleware('guest:web');
    Route::get('/kayit', [WebOturumController::class, "kayit"])->name('kayit')->middleware('guest:web');
    Route::post('/kayit', [WebOturumController::class, "kayitPost"])->middleware('guest:web');
    Route::get('/cikis', [WebOturumController::class, "cikis"])->name('cikis')->middleware('auth');

    Route::get('/sifre-sifirla', [SifreSifirlaController::class, "sifreSifirlaTalepForm"])->name("sifre-sifirla")->middleware('guest:web');
    Route::post('/sifre-sifirla-link', [SifreSifirlaController::class, "sifreSifirlamaLinkiGonder"])->name("sifre-sifirla-link-gonder")->middleware('guest:web');
    Route::get('/sifre-sifirla/{token}', [SifreSifirlaController::class, "sifreSifirlaForm"])->name("sifre-sifirla-form")->middleware('guest:web');
    Route::post('/sifre-sifirla-onay', [SifreSifirlaController::class, "sifreSifirlaOnay"])->name("sifre-sifirla-onay")->middleware('guest:web');

    Route::get('/urunlerimiz/{kategori?}/{altKategori?}', [UrunController::class, "index"])->name("urunler");
    Route::get('/urunler/{slug}', [UrunController::class, "goster"])->name("urun-detay");
      Route::get('/arama/urunler', [UrunController::class, "AramaUrunler"])->name("arama-urunler");

    Route::get('/vitrin/{tip}', [VitrinController::class, "index"])->name("vitrin");

    Route::get('/galeri', [GaleriController::class, "index"])->name("galeri");


    Route::get('/markalar', [MarkaController::class, "index"])->name("markalar");
    Route::get('/marka/{slug}', [MarkaController::class, "goster"])->name("marka-detay");

    Route::get('/kilavuz', [BlogController::class, "index"])->name("bloglar");
    Route::get('/kilavuz/{slug}', [BlogController::class, "goster"])->name("blog-detay");

    Route::get('/hizmetler', [HizmetController::class, "index"])->name("hizmetler");
    Route::get('/hizmetler/{slug}', [HizmetController::class, "goster"])->name("hizmet-detay");

    Route::get('/hakkimizda', [SayfaYonetimController::class, "hakkimizda"])->name("hakkimizda");
    Route::get('/gizlilik-politikasi', [SayfaYonetimController::class, "gizlilikPolitikasi"])->name("gizlilik-politikasi");
    Route::get('/cerez-politikasi', [SayfaYonetimController::class, "cerezPolitikasi"])->name("cerez-politikasi");
    Route::get('/iade-politikasi', [SayfaYonetimController::class, "iadePolitikasi"])->name("iade-politikasi");
    Route::get('/iletisim', [SayfaYonetimController::class, "iletisim"])->name("iletisim");
    Route::get('/mesafeli-satis', [SayfaYonetimController::class, "mesafeliSatis"])->name("mesafeli-satis");
    Route::get('/teslimat-kosullari', [SayfaYonetimController::class, "teslimatKosullari"])->name("teslimat-kosullari");
    Route::get('/kvkk', [SayfaYonetimController::class, "kvkk"])->name("kvkk");

    Route::get('/projelerimiz', [ProjeController::class, "index"])->name("projelerimiz");
    Route::get('/projelerimiz/{slug}', [ProjeController::class, "goster"])->name("projelerimiz-detay");

    Route::get('/sertifikalar', [KatalogController::class, "index"])->name("sertifikalarimiz");
    Route::get('/sertifikalar/{slug}', [KatalogController::class, "goster"])->name("sertifikalarimiz-detay");

    Route::get('/sikca-sorulan-sorular', [SssController::class, "index"])->name("sss");

    Route::get('/favorilerim', [FavoriController::class, "index"])->name("favori")->middleware('auth');
    Route::get('/sepet', [SepetController::class, "index"])->name("sepet");

    Route::prefix('odeme')->name('odeme.')->group(function () {

        Route::get('/', [OdemeController::class, "index"])->name("index");

        Route::post('/durum', [OdemeController::class, 'durum'])->name('durum');

        Route::match(['get', 'post'], '/basarili', [OdemeController::class, "basarili"])->name("basarili");
        Route::match(['get', 'post'], '/basarisiz', [OdemeController::class, "basarisiz"])->name("basarisiz");
    });

    Route::get('/kargo-takip', [KargoController::class, 'trackCargo']);
    Route::get('/kargo-takip/{cargoKey}', [KargoController::class, 'trackCargo']);
});
