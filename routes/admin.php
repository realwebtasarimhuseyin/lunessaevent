<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminOturumController;
use App\Http\Controllers\AdminIndexController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BultenController;
use App\Http\Controllers\UrunController;
use App\Http\Controllers\UrunKategoriController;
use App\Http\Controllers\UrunAltKategoriController;
use App\Http\Controllers\UrunVaryantController;
use App\Http\Controllers\UrunVaryantOzellikController;
use App\Http\Controllers\SssController;
use App\Http\Controllers\SayfaYonetimController;
use App\Http\Controllers\IletisimFormController;
use App\Http\Controllers\KuponController;
use App\Http\Controllers\PopupController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SiparisController;
use App\Http\Controllers\KullaniciController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AyarController;
use App\Http\Controllers\DovizYonetimController;
use App\Http\Controllers\DuyuruController;
use App\Http\Controllers\EkipController;
use App\Http\Controllers\SiteMapController;
use App\Http\Controllers\UrunKdvController;
use App\Http\Controllers\YetkiController;
use App\Http\Controllers\YorumController;


use App\Http\Controllers\KargoController;
use App\Http\Controllers\FaturaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\HizmetController;
use App\Http\Controllers\HizmetKategoriController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\KatalogKategoriController;
use App\Http\Controllers\MarkaController;
use App\Http\Controllers\ProjeController;
use App\Http\Controllers\ProjeKategoriController;
use App\Http\Controllers\SektorController;
use App\Http\Controllers\UrunOzellikController;

Route::prefix("realpanel")->name('realpanel.')->group(function () {
    Route::get("/giris", [AdminOturumController::class, "giris"])->name("giris")->middleware("guest:admin");
    Route::post("/giris", [AdminOturumController::class, "girisPost"])->name("oturumAcma");


    Route::middleware('auth.admin')->group(function () {
        Route::get('/', [AdminIndexController::class, 'index'])->name('index');

        Route::get('/cikis', [AdminOturumController::class, 'cikis'])->name('cikis');

        Route::prefix('slider')->name("slider.")->group(function () {
            Route::get("/", [SliderController::class, "adminIndex"])->middleware('yetki:slider-gor,slider-tumunugor')->name("index");
            Route::get("/liste", [SliderController::class, "adminList"])->middleware('yetki:slider-gor,slider-tumunugor')->name("liste");
            Route::get("/ekle", [SliderController::class, "ekle"])->middleware('yetki:slider-ekle')->name("ekle");
            Route::post("/ekle", [SliderController::class, "eklePost"]);
            Route::get("/duzenle/{slider}", [SliderController::class, "duzenle"])->middleware('yetki:slider-duzenle')->name("duzenle");
            Route::post("/duzenle/{slider}", [SliderController::class, "duzenlePost"]);
            Route::post("/siralamaduzenle", [SliderController::class, "siralamaDuzenle"]);
            Route::post("/sil/{slider}", [SliderController::class, "sil"])->middleware('yetki:slider-sil');
        });

        Route::prefix('galeri')->name("galeri.")->group(function () {
            Route::get("/", [GaleriController::class, "adminIndex"])->name("index");
            Route::get("/liste", [GaleriController::class, "adminList"])->name("liste");
            Route::get("/ekle", [GaleriController::class, "ekle"])->name("ekle");
            Route::post("/ekle", [GaleriController::class, "eklePost"]);
            Route::get("/duzenle/{galeri}", [GaleriController::class, "duzenle"])->name("duzenle");
            Route::post("/duzenle/{galeri}", [GaleriController::class, "duzenlePost"]);
            Route::post("/siralamaduzenle", [GaleriController::class, "siralamaDuzenle"]);
            Route::post("/sil/{galeri}", [GaleriController::class, "sil"]);
        });

        Route::prefix('duyuru')->name("duyuru.")->group(function () {
            Route::get("/", [DuyuruController::class, "adminIndex"])->middleware('yetki:duyuru-gor,duyuru-tumunugor')->name("index");
            Route::get("/liste", [DuyuruController::class, "adminList"])->middleware('yetki:duyuru-gor,duyuru-tumunugor')->name("liste");
            Route::get("/ekle", [DuyuruController::class, "ekle"])->middleware('yetki:duyuru-ekle')->name("ekle");
            Route::post("/ekle", [DuyuruController::class, "eklePost"]);
            Route::get("/duzenle/{duyuru}", [DuyuruController::class, "duzenle"])->middleware('yetki:duyuru-duzenle')->name("duzenle");
            Route::post("/duzenle/{duyuru}", [DuyuruController::class, "duzenlePost"]);
            Route::post("/siralamaduzenle", [DuyuruController::class, "siralamaDuzenle"]);
            Route::post("/sil/{duyuru}", [DuyuruController::class, "sil"])->middleware('yetki:duyuru-sil');
        });

        Route::prefix('marka')->name("marka.")->group(function () {
            Route::get("/", [MarkaController::class, "adminIndex"])->name("index");
            Route::get("/liste", [MarkaController::class, "adminList"])->name("liste");
            Route::get("/ekle", [MarkaController::class, "ekle"])->name("ekle");
            Route::post("/ekle", [MarkaController::class, "eklePost"]);
            Route::get("/duzenle/{marka}", [MarkaController::class, "duzenle"])->name("duzenle");
            Route::post("/duzenle/{marka}", [MarkaController::class, "duzenlePost"]);
            Route::post("/siralamaduzenle", [MarkaController::class, "siralamaDuzenle"]);
            Route::post("/sil/{marka}", [MarkaController::class, "sil"]);
        });

        Route::prefix('blog')->name("blog.")->group(function () {
            Route::get("/", [BlogController::class, "adminIndex"])->middleware('yetki:blog-gor,blog-tumunugor')->name("index");
            Route::get("/liste", [BlogController::class, "adminList"])->middleware('yetki:blog-gor,blog-tumunugor')->name("liste");
            Route::get("/ekle", [BlogController::class, "ekle"])->middleware('yetki:blog-ekle')->name("ekle");
            Route::post("/ekle", [BlogController::class, "eklePost"]);
            Route::get("/duzenle/{blog}", [BlogController::class, "duzenle"])->middleware('yetki:blog-duzenle')->name("duzenle");
            Route::post("/duzenle/{blog}", [BlogController::class, "duzenlePost"]);
            Route::post("/siralamaduzenle", [BlogController::class, "siralamaDuzenle"]);
            Route::post("/sil/{blog}", [BlogController::class, "sil"])->middleware('yetki:blog-sil');
        });


        Route::prefix('katalogkategori')->name("katalogkategori.")->group(function () {
            Route::get("/", [KatalogKategoriController::class, "adminIndex"])->name("index");
            Route::get("/liste", [KatalogKategoriController::class, "adminList"])->name("liste");
            Route::get("/tableliste", [KatalogKategoriController::class, "adminTableList"]);
            Route::get("/ekle", [KatalogKategoriController::class, "ekle"])->name("ekle");
            Route::post("/ekle", [KatalogKategoriController::class, "eklePost"]);
            Route::get("/duzenle/{katalogKategori}", [KatalogKategoriController::class, "duzenle"])->name("duzenle");
            Route::post("/duzenle/{katalogKategori}", [KatalogKategoriController::class, "duzenlePost"]);
            Route::post("/siralamaduzenle", [KatalogKategoriController::class, "siralamaDuzenle"]);
            Route::post("/transfer", [KatalogKategoriController::class, "transfer"]);
            Route::post("/sil/{katalogKategori}", [KatalogKategoriController::class, "sil"]);
        });


        Route::prefix('katalog')->name("katalog.")->group(function () {
            Route::get("/", [KatalogController::class, "adminIndex"])->name('index');
            Route::get("/liste", [KatalogController::class, "adminList"]);
            Route::get("/ekle", [KatalogController::class, "ekle"])->name('ekle');
            Route::post("/ekle", [KatalogController::class, "eklePost"]);
            Route::get("/duzenle/{katalog}", [KatalogController::class, "duzenle"])->name('duzenle');
            Route::post("/duzenle/{katalog}", [KatalogController::class, "duzenlePost"]);
            Route::post("/siralamaduzenle", [KatalogController::class, "siralamaDuzenle"]);
            Route::post("/sil/{katalog}", [KatalogController::class, "sil"]);
        });

        Route::prefix('urunkategori')->name("urunkategori.")->group(function () {
            Route::get("/", [UrunKategoriController::class, "adminIndex"])->middleware('yetki:urun-kategori-gor,urun-kategori-tumunugor')->name("index");
            Route::get("/liste", [UrunKategoriController::class, "adminList"])->name("liste");
            Route::get("/tableliste", [UrunKategoriController::class, "adminTableList"])->middleware('yetki:urun-kategori-gor,urun-kategori-tumunugor');
            Route::get("/ekle", [UrunKategoriController::class, "ekle"])->middleware('yetki:urun-kategori-ekle')->name("ekle");
            Route::post("/ekle", [UrunKategoriController::class, "eklePost"]);
            Route::get("/duzenle/{urunKategori}", [UrunKategoriController::class, "duzenle"])->middleware('yetki:urun-kategori-duzenle')->name("duzenle");
            Route::post("/duzenle/{urunKategori}", [UrunKategoriController::class, "duzenlePost"]);
            Route::post("/siralamaduzenle", [UrunKategoriController::class, "siralamaDuzenle"]);
            Route::post("/transfer", [UrunKategoriController::class, "transfer"]);
            Route::post("/sil/{urunKategori}", [UrunKategoriController::class, "sil"])->middleware('yetki:urun-kategori-sil');
        });

        Route::prefix('urunaltkategori')->name("urunaltkategori.")->group(function () {
            Route::get("/", [UrunAltKategoriController::class, "adminIndex"])->middleware('yetki:urun-alt-kategori-gor, urun-alt-kategori-tumunugor')->name("index");
            Route::get("/liste", [UrunAltKategoriController::class, "adminList"])->name("liste");
            Route::get("/tableliste", [UrunAltKategoriController::class, "adminTableList"])->middleware('yetki:urun-alt-kategori-gor,urun-alt-kategori-tumunugor');
            Route::get("/ekle", [UrunAltKategoriController::class, "ekle"])->middleware('yetki:urun-alt-kategori-ekle')->name("ekle");
            Route::post("/ekle", [UrunAltKategoriController::class, "eklePost"]);
            Route::get("/duzenle/{urunAltKategori}", [UrunAltKategoriController::class, "duzenle"])->middleware('yetki:urun-alt-kategori-duzenle')->name("duzenle");
            Route::post("/duzenle/{urunAltKategori}", [UrunAltKategoriController::class, "duzenlePost"]);
            Route::post("/siralamaduzenle", [UrunAltKategoriController::class, "siralamaDuzenle"]);
            Route::post("/sil/{urunAltKategori}", [UrunAltKategoriController::class, "sil"])->middleware('yetki:urun-alt-kategori-sil');
        });

        Route::prefix('urunvaryant')->name("urunvaryant.")->group(function () {
            Route::get("/", [UrunVaryantController::class, "adminIndex"])->middleware('yetki:urun-varyant-gor, urun-varyant-tumunugor')->name("index");
            Route::get("/liste", [UrunVaryantController::class, "adminList"])->middleware('yetki:urun-varyant-gor, urun-varyant-tumunugor')->name("liste");
            Route::get("/ekle", [UrunVaryantController::class, "ekle"])->middleware('yetki:urun-varyant-ekle')->name("ekle");
            Route::post("/ekle", [UrunVaryantController::class, "eklePost"]);
            Route::get("/duzenle/{urunVaryant}", [UrunVaryantController::class, "duzenle"])->middleware('yetki:urun-varyant-duzenle')->name("duzenle");
            Route::post("/duzenle/{urunVaryant}", [UrunVaryantController::class, "duzenlePost"]);
            Route::post("/siralamaduzenle", [UrunVaryantController::class, "siralamaDuzenle"]);
            Route::post("/sil/{urunVaryant}", [UrunVaryantController::class, "sil"])->middleware('yetki:urun-varyant-sil');
        });

        Route::prefix('urunvaryantozellik')->name("urunvaryantozellik.")->group(function () {
            Route::get("/", [UrunVaryantOzellikController::class, "adminIndex"])->middleware('yetki:urun-varyant-ozellik-gor, urun-varyant-ozellik-tumunugor')->name("index");
            Route::get("/liste", [UrunVaryantOzellikController::class, "adminList"])->middleware('yetki:urun-varyant-ozellik-gor, urun-varyant-ozellik-tumunugor')->name("liste");
            Route::get("/ekle", [UrunVaryantOzellikController::class, "ekle"])->middleware('yetki:urun-varyant-ozellik-ekle')->name("ekle");
            Route::post("/ekle", [UrunVaryantOzellikController::class, "eklePost"]);
            Route::get("/duzenle/{urunVaryantOzellik}", [UrunVaryantOzellikController::class, "duzenle"])->middleware('yetki:urun-varyant-ozellik-duzenle')->name("duzenle");
            Route::post("/duzenle/{urunVaryantOzellik}", [UrunVaryantOzellikController::class, "duzenlePost"]);
            Route::post("/siralamaduzenle", [UrunVaryantOzellikController::class, "siralamaDuzenle"]);
            Route::post("/sil/{urunVaryantOzellik}", [UrunVaryantOzellikController::class, "sil"])->middleware('yetki:urun-varyant-ozellik-sil');
        });

        Route::prefix('urunozellik')->name("urunozellik.")->group(function () {
            Route::get("/", [UrunOzellikController::class, "adminIndex"])->name("index");
            Route::get("/liste", [UrunOzellikController::class, "adminList"])->name("liste");
            Route::get("/ekle", [UrunOzellikController::class, "ekle"])->name("ekle");
            Route::post("/ekle", [UrunOzellikController::class, "eklePost"]);
            Route::get("/duzenle/{urunOzellik}", [UrunOzellikController::class, "duzenle"])->name("duzenle");
            Route::post("/duzenle/{urunOzellik}", [UrunOzellikController::class, "duzenlePost"]);
            Route::post("/siralamaduzenle", [UrunOzellikController::class, "siralamaDuzenle"]);
            Route::post("/sil/{urunOzellik}", [UrunOzellikController::class, "sil"]);
        });

        Route::prefix('urunkdv')->name("urunkdv.")->group(function () {
            Route::get("/", [UrunKdvController::class, "adminIndex"])->middleware('yetki:urun-kdv-gor,urun-kdv-tumunugor')->name("index");
            Route::get("/liste", [UrunKdvController::class, "adminList"])->middleware('yetki:urun-kdv-gor,urun-kdv-tumunugor')->name("liste");
            Route::get("/ekle", [UrunKdvController::class, "ekle"])->middleware('yetki:urun-kdv-ekle')->name("ekle");
            Route::post("/ekle", [UrunKdvController::class, "eklePost"]);
            Route::get("/duzenle/{urunKdv}", [UrunKdvController::class, "duzenle"])->middleware('yetki:urun-kdv-duzenle')->name("duzenle");
            Route::post("/duzenle/{urunKdv}", [UrunKdvController::class, "duzenlePost"]);
            Route::post("/siralamaduzenle", [UrunAltKategoriController::class, "siralamaDuzenle"]);
            Route::post("/sil/{urunKdv}", [UrunKdvController::class, "sil"])->middleware('yetki:urun-kdv-sil');
        });

        Route::prefix('urun')->name("urun.")->group(function () {
            Route::get("/", [UrunController::class, "adminIndex"])->middleware('yetki:urun-gor,urun-tumunugor')->name("index");
            Route::get("/liste", [UrunController::class, "adminList"])->middleware('yetki:urun-gor,urun-tumunugor')->name("liste");
            Route::get("/ekle", [UrunController::class, "ekle"])->middleware('yetki:urun-ekle')->name("ekle");
            Route::post("/ekle", [UrunController::class, "eklePost"]);
            Route::get("/duzenle/{urun}", [UrunController::class, "duzenle"])->middleware('yetki:urun-duzenle')->name("duzenle");
            Route::post("/duzenle/{urun}", [UrunController::class, "duzenlePost"]);
            Route::post("/siralamaduzenle", [UrunController::class, "siralamaDuzenle"]);
            Route::post("/sil/{urun}", [UrunController::class, "sil"])->middleware('yetki:urun-sil');
        });

        Route::prefix('proje')->name("proje.")->group(function () {
            Route::get("/", [ProjeController::class, "adminIndex"])->name("index");
            Route::get("/liste", [ProjeController::class, "adminList"])->name("liste");
            Route::get("/ekle", [ProjeController::class, "ekle"])->name("ekle");
            Route::post("/ekle", [ProjeController::class, "eklePost"]);
            Route::get("/duzenle/{proje}", [ProjeController::class, "duzenle"])->name("duzenle");
            Route::post("/duzenle/{proje}", [ProjeController::class, "duzenlePost"]);
            Route::post("/siralamaduzenle", [ProjeController::class, "siralamaDuzenle"]);
            Route::post("/sil/{proje}", [ProjeController::class, "sil"]);
        });

        Route::prefix('projekategori')->name("projekategori.")->group(function () {
            Route::get("/", [ProjeKategoriController::class, "adminIndex"])->name("index");
            Route::get("/liste", [ProjeKategoriController::class, "adminList"])->name("liste");
            Route::get("/tableliste", [ProjeKategoriController::class, "adminTableList"]);
            Route::get("/ekle", [ProjeKategoriController::class, "ekle"])->name("ekle");
            Route::post("/ekle", [ProjeKategoriController::class, "eklePost"]);
            Route::post("/siralamaduzenle", [ProjeKategoriController::class, "siralamaDuzenle"]);
            Route::get("/duzenle/{projeKategori}", [ProjeKategoriController::class, "duzenle"])->name("duzenle");
            Route::post("/duzenle/{projeKategori}", [ProjeKategoriController::class, "duzenlePost"]);
            Route::post("/transfer", [ProjeKategoriController::class, "transfer"]);
            Route::post("/sil/{projeKategori}", [ProjeKategoriController::class, "sil"]);
        });

        Route::prefix('hizmet')->name("hizmet.")->group(function () {
            Route::get("/", [HizmetController::class, "adminIndex"])->name("index");
            Route::get("/liste", [HizmetController::class, "adminList"])->name("liste");
            Route::get("/ekle", [HizmetController::class, "ekle"])->name("ekle");
            Route::post("/ekle", [HizmetController::class, "eklePost"]);
            Route::post("/siralamaduzenle", [HizmetController::class, "siralamaDuzenle"]);
            Route::get("/duzenle/{hizmet}", [HizmetController::class, "duzenle"])->name("duzenle");
            Route::post("/duzenle/{hizmet}", [HizmetController::class, "duzenlePost"]);
            Route::post("/sil/{hizmet}", [HizmetController::class, "sil"]);
        });

        Route::prefix('hizmetkategori')->name("hizmetkategori.")->group(function () {
            Route::get("/", [HizmetKategoriController::class, "adminIndex"])->name("index");
            Route::get("/liste", [HizmetKategoriController::class, "adminList"])->name("liste");
            Route::get("/tableliste", [HizmetKategoriController::class, "adminTableList"]);
            Route::get("/ekle", [HizmetKategoriController::class, "ekle"])->name("ekle");
            Route::post("/ekle", [HizmetKategoriController::class, "eklePost"]);
            Route::post("/siralamaduzenle", [HizmetKategoriController::class, "siralamaDuzenle"]);
            Route::get("/duzenle/{hizmetKategori}", [HizmetKategoriController::class, "duzenle"])->name("duzenle");
            Route::post("/duzenle/{hizmetKategori}", [HizmetKategoriController::class, "duzenlePost"]);
            Route::post("/transfer", [HizmetKategoriController::class, "transfer"]);
            Route::post("/sil/{hizmetKategori}", [HizmetKategoriController::class, "sil"]);
        });

        Route::prefix('ekip')->name("ekip.")->group(function () {
            Route::get("/", [EkipController::class, "adminIndex"])->name("index");
            Route::get("/liste", [EkipController::class, "adminList"])->name("liste");
            Route::get("/ekle", [EkipController::class, "ekle"])->name("ekle");
            Route::post("/ekle", [EkipController::class, "eklePost"]);
            Route::get("/duzenle/{ekip}", [EkipController::class, "duzenle"])->name("duzenle");
            Route::post("/duzenle/{ekip}", [EkipController::class, "duzenlePost"]);
            Route::post("/sil/{ekip}", [EkipController::class, "sil"]);
        });

        Route::prefix('sektor')->name("sektor.")->group(function () {
            Route::get("/", [SektorController::class, "adminIndex"])->name("index");
            Route::get("/liste", [SektorController::class, "adminList"])->name("liste");
            Route::get("/ekle", [SektorController::class, "ekle"])->name("ekle");
            Route::post("/ekle", [SektorController::class, "eklePost"]);
            Route::post("/siralamaduzenle", [SektorController::class, "siralamaDuzenle"]);
            Route::get("/duzenle/{sektor}", [SektorController::class, "duzenle"])->name("duzenle");
            Route::post("/duzenle/{sektor}", [SektorController::class, "duzenlePost"]);
            Route::post("/sil/{sektor}", [SektorController::class, "sil"]);
        });

        Route::prefix('sss')->name("sss.")->group(function () {
            Route::get("/", [SssController::class, "adminIndex"])->middleware('yetki:sss-gor,sss-tumunugor')->name("index");
            Route::get("/liste", [SssController::class, "adminList"])->middleware('yetki:sss-gor,sss-tumunugor')->name("liste");
            Route::get("/ekle", [SssController::class, "ekle"])->middleware('yetki:sss-ekle')->name("ekle");
            Route::post("/ekle", [SssController::class, "eklePost"]);
            Route::get("/duzenle/{sss}", [SssController::class, "duzenle"])->middleware('yetki:sss-duzenle')->name("duzenle");
            Route::post("/duzenle/{sss}", [SssController::class, "duzenlePost"]);
            Route::post("/siralamaduzenle", [SssController::class, "siralamaDuzenle"]);
            Route::post("/sil/{sss}", [SssController::class, "sil"])->middleware('yetki:sss-sil');
        });

        Route::prefix('sayfayonetim')->name("sayfayonetim.")->group(function () {
            Route::get("/", [SayfaYonetimController::class, "adminIndex"])->name("index");
            Route::get("/liste", [SayfaYonetimController::class, "adminList"])->name("liste");
            Route::get("/duzenle/{sayfaYonetim:slug}", [SayfaYonetimController::class, "duzenle"])->name("duzenle");
            Route::post("/duzenle/{sayfaYonetim:slug}", [SayfaYonetimController::class, "duzenlePost"]);
            Route::post("/siralamaduzenle", [SayfaYonetimController::class, "siralamaDuzenle"]);
        });

        Route::prefix('dovizyonetim')->name("dovizyonetim.")->group(function () {
            Route::get("/", [DovizYonetimController::class, "adminIndex"])->name("index");
            Route::get("/liste", [DovizYonetimController::class, "adminList"])->name("liste");
            Route::get("/duzenle/{dovizYonetim:doviz_slug}", [DovizYonetimController::class, "duzenle"])->name("duzenle");
            Route::post("/duzenle/{dovizYonetim:doviz_slug}", [DovizYonetimController::class, "duzenlePost"]);
        });

        Route::prefix('siparis')->name("siparis.")->group(function () {
            Route::get("/", [SiparisController::class, "adminIndex"])->middleware('yetki:siparis-gor,siparis-tumunugor')->name("index");
            Route::get("/liste", [SiparisController::class, "adminList"])->middleware('yetki:siparis-gor,siparis-tumunugor')->name("liste");
            Route::get("/detay/{siparis}", [SiparisController::class, "goster"])->middleware('yetki:siparis-gor,siparis-tumunugor')->name("goster");
            Route::get("/duzenle/{siparis}", [SiparisController::class, "duzenle"])->middleware('yetki:siparis-duzenle')->name("duzenle");
            Route::post("/duzenle/{siparis}", [SiparisController::class, "duzenlePost"]);
            Route::post("/sil/{siparis}", [SiparisController::class, "sil"])->middleware('yetki:siparis-sil');
        });

        Route::prefix('bulten')->name("bulten.")->group(function () {
            Route::get("/", [BultenController::class, "adminIndex"])->middleware('yetki:bulten-gor,bulten-tumunugor')->name("index");
            Route::get("/liste", [BultenController::class, "adminList"])->middleware('yetki:bulten-gor,bulten-tumunugor')->name("liste");
            Route::post("/sil/{bulten}", [BultenController::class, "sil"])->middleware('yetki:bulten-sil');
        });

        Route::prefix('iletisimform')->name("iletisimform.")->group(function () {
            Route::get("/", [IletisimFormController::class, "adminIndex"])->name("index");
            Route::get("/liste", [IletisimFormController::class, "adminList"])->name("liste");
            Route::get("/detay/{iletisimForm}", [IletisimFormController::class, "goster"]);
            Route::post("/sil/{iletisimForm}", [IletisimFormController::class, "sil"]);
        });

        Route::prefix('kupon')->name("kupon.")->group(function () {
            Route::get("/", [KuponController::class, "adminIndex"])->middleware('yetki:siparis-gor,siparis-tumunugor')->name("index");
            Route::get("/liste", [KuponController::class, "adminList"])->middleware('yetki:siparis-gor,siparis-tumunugor')->name("liste");
            Route::get("/ekle", [KuponController::class, "ekle"])->middleware('yetki:siparis-ekle')->name("ekle");
            Route::post("/ekle", [KuponController::class, "eklePost"]);
            Route::get("/duzenle/{kupon}", [KuponController::class, "duzenle"])->middleware('yetki:siparis-duzenle')->name("duzenle");
            Route::post("/duzenle/{kupon}", [KuponController::class, "duzenlePost"]);
            Route::post("/sil/{kupon}", [KuponController::class, "sil"])->middleware('yetki:siparis-sil');
        });

        Route::prefix('popup')->name("popup.")->group(function () {
            Route::get("/", [PopupController::class, "adminIndex"])->middleware('yetki:popup-gor,popup-tumunugor')->name("index");
            Route::get("/liste", [PopupController::class, "adminList"])->middleware('yetki:popup-gor,popup-tumunugor')->name("liste");
            Route::get("/ekle", [PopupController::class, "ekle"])->middleware('yetki:popup-ekle')->name("ekle");
            Route::post("/ekle", [PopupController::class, "eklePost"]);
            Route::get("/duzenle/{popup}", [PopupController::class, "duzenle"])->middleware('yetki:popup-ekle')->name("duzenle");
            Route::post("/duzenle/{popup}", [PopupController::class, "duzenlePost"]);
            Route::post("/siralamaduzenle", [PopupController::class, "siralamaDuzenle"]);
            Route::post("/sil/{popup}", [PopupController::class, "sil"])->middleware('yetki:popup-sil');
        });

        Route::prefix('kullanici')->name("kullanici.")->group(function () {
            Route::get("/", [KullaniciController::class, "adminIndex"])->middleware('yetki:kullanici-gor,kullanici-tumunugor')->name("index");
            Route::get("/liste", [KullaniciController::class, "adminList"])->middleware('yetki:kullanici-gor,kullanici-tumunugor')->name("liste");
            Route::get("/ekle", [KullaniciController::class, "ekle"])->middleware('yetki:kullanici-ekle')->name("ekle");
            Route::post("/ekle", [KullaniciController::class, "eklePost"]);
            Route::get("/detay/{kullanici}", [KullaniciController::class, "goster"])->middleware('yetki:kullanici-gor,kullanici-tumunugor');
            Route::get("/duzenle/{kullanici}", [KullaniciController::class, "duzenle"])->middleware('yetki:kullanici-duzenle')->name("duzenle");
            Route::post("/duzenle/{kullanici}", [KullaniciController::class, "duzenlePost"]);
            Route::post("/sil/{kullanici}", [KullaniciController::class, "sil"])->middleware('yetki:kullanici-sil');
        });

        Route::prefix('adminyonetim')->name("admin.")->group(function () {
            Route::get("/", [AdminController::class, "adminIndex"])->middleware('yetki:admin-gor,admin-tumunugor')->name("index");
            Route::get("/liste", [AdminController::class, "adminList"])->middleware('yetki:admin-gor,admin-tumunugor')->name("liste");
            Route::get("/ekle", [AdminController::class, "ekle"])->middleware('yetki:admin-ekle')->name("ekle");
            Route::post("/ekle", [AdminController::class, "eklePost"]);
            Route::get("/duzenle/{admin}", [AdminController::class, "duzenle"])->middleware('yetki:admin-duzenle')->name("duzenle");
            Route::post("/duzenle/{admin}", [AdminController::class, "duzenlePost"]);
            Route::post("/sil/{admin}", [AdminController::class, "sil"])->middleware('yetki:admin-sil');
        });

        Route::prefix('yetki')->name("yetki.")->group(function () {
            Route::get("/", [YetkiController::class, "adminIndex"])->name("index");
            Route::get("/liste", [YetkiController::class, "adminList"])->name("liste");
            Route::get("/ekle", [YetkiController::class, "ekle"])->name("ekle");
            Route::post("/ekle", [YetkiController::class, "eklePost"]);
            Route::get("/duzenle/{yetki}", [YetkiController::class, "duzenle"])->name("duzenle");
            Route::post("/duzenle/{yetki}", [YetkiController::class, "duzenlePost"]);
            Route::post("/sil/{yetki}", [YetkiController::class, "sil"]);
        });

        Route::prefix('yorum')->name("yorum.")->group(function () {
            Route::get("/", [YorumController::class, "adminIndex"])->name("index");
            Route::get("/liste", [YorumController::class, "adminList"])->name("liste");
            Route::get("/ekle", [YorumController::class, "ekle"])->name("ekle");
            Route::post("/ekle", [YorumController::class, "eklePost"]);
            Route::get("/duzenle/{yorum}", [YorumController::class, "duzenle"])->name("duzenle");
            Route::post("/duzenle/{yorum}", [YorumController::class, "duzenlePost"]);

            Route::post("/siralamaduzenle", [UrunController::class, "siralamaDuzenle"]);

            Route::post("/sil/{yorum}", [YorumController::class, "sil"]);
        });


        Route::prefix('ayar')->name("ayar.")->group(function () {
            Route::get("/", [AyarController::class, "adminIndex"])->middleware('yetki:ayar-gor')->name("index");
            Route::post("/duzenle", [AyarController::class, "duzenlePost"])->middleware('yetki:ayar-duzenle');
        });

        Route::prefix("sitemap")->name("sitemap.")->group(function () {
            Route::post('/guncelle', [SiteMapController::class, 'guncelle'])->name('guncelle');
            Route::get('/indir', [SiteMapController::class, 'indir'])->name('indir');
        });

        /*         
        Route::post('/kargo/create', [KargoController::class, 'createCargo'])->name('kargo.create');
        Route::post('/fatura-gonder', [FaturaController::class, 'gonderFatura']); 
        */
    });
});
