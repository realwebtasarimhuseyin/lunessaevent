<?php

use App\Helper\IpApiHelper;
use App\Models\Ayar;
use App\Models\Doviz;
use App\Models\KullaniciHareketleri;
use App\Models\KullaniciIndirim;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use hisorange\BrowserDetect\Parser as Browser;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// Sayfa başlığı getiren fonksiyon
if (!function_exists('getSayfaBasligi')) {
    /**
     * Sayfa başlığı belirlemek için slug değerine göre başlık döndürür.
     *
     * @param string $slug Sayfa slug'ı
     * @return string Sayfa başlığı
     */
    function getSayfaBasligi(string $slug): string
    {
        return match ($slug) {
            'anasayfa' => \App\Enums\SayfaBasliklariEnum::ANASAYFA->value,
            'iletisim' => \App\Enums\SayfaBasliklariEnum::ILETISIM->value,
            'hakkimizda' => \App\Enums\SayfaBasliklariEnum::HAKKIMIZDA->value,
            'gizlilik-politikasi' => \App\Enums\SayfaBasliklariEnum::GIZLILIKPOLITIKASI->value,
            'mesafeli-satis' => \App\Enums\SayfaBasliklariEnum::MESAFELISATIS->value,
            'iade-politikasi' => \App\Enums\SayfaBasliklariEnum::IADEPOLITIKASI->value,
            'cerez-politikasi' => \App\Enums\SayfaBasliklariEnum::CEREZPOLITIKASI->value,
            'teslimat-kosullari' => \App\Enums\SayfaBasliklariEnum::TESLIMATKOSULLARI->value,
            'kvkk' => \App\Enums\SayfaBasliklariEnum::KVKK->value,
            'misyon' => \App\Enums\SayfaBasliklariEnum::MISYON->value,
            'vizyon' => \App\Enums\SayfaBasliklariEnum::VIZYON->value,
            default => 'Başlık bulunamadı',
        };
    }
}

if (!function_exists('dilVerisi')) {
    function dilVerisi($model, $dilModel)
    {
        $dil = App::getLocale();

        return $model->$dilModel->where('dil', $dil);
    }
}



if (!function_exists('rota')) {
    /**
     * Belirtilen rota adını locale bilgisi ile birlikte döndürür.
     *
     * @param string $rotaIsim Rota adı
     * @param array $parametre Parametreler
     * @param string|null $dil Dil bilgisi (Varsayılan: Geçerli dil)
     * @return string URL
     */
    function rota(string $rotaIsim, array $parametre = [], $dil = null): string
    {
        if (!$dil) {
            $dil = App::getLocale();
        }

        $desteklenenDiller = config('app.supported_locales', ['tr']); // Desteklenen dilleri konfigürasyondan al
        $tekDilMi = count($desteklenenDiller) === 1;

        $dilEklenmesinRotalar = [
            'index',
            'kvkk',
        ];

        if ($tekDilMi || in_array($rotaIsim, $dilEklenmesinRotalar)) {
            return route($rotaIsim, $parametre);
        }

        return route($dil . "." . $rotaIsim, array_merge(['locale' => $dil], $parametre));
    }
}



// Ayar değeri getirme fonksiyonu
if (!function_exists('ayar')) {
    /**
     * Ayarlar tablosundan dil desteğiyle ayar değerini alır.
     *
     * @param string $isim Ayar adı
     * @param string $dil Ayar dili (varsayılan: tr)
     * @return string Ayar değeri
     */
    function ayar(string $isim, string $dil = "tr"): string
    {
        $ayar = Ayar::where("ayar_isim", $isim)->first();
        return $ayar?->ayarDiller->where('dil', $dil)->first()->deger ?? "";
    }
}

// Tekli indirim oranı hesaplama fonksiyonu (varyant destekli)
if (!function_exists('tekliIndirimOran')) {
    /**
     * Ürünün veya varyantın indirim oranını hesaplar.
     *
     * @param object $urun Ürün nesnesi
     * @param object|null $varyant Varyant nesnesi (opsiyonel)
     * @return string İndirim yüzdesi
     */
    function tekliIndirimOran($urun, $varyant = null): string
    {
        $birimFiyat = $varyant ? $varyant->birim_fiyat : $urun->birim_fiyat;
        $indirimYuzde = $urun->indirim_yuzde;
        $indirimTutar = $urun->indirim_tutar;

        if ($indirimYuzde > 0) {
            return $indirimYuzde;
        }

        return $indirimTutar > 0 ? max(($indirimTutar / $birimFiyat) * 100, 0) : '0';
    }
}

// İndirim yüzdesini formatlama fonksiyonu
if (!function_exists('formatIndirimYuzdesi')) {
    function formatIndirimYuzdesi($indirimYuzde): string
    {
        return rtrim(rtrim(sprintf('%.2f', $indirimYuzde), '0'), '.');
    }
}

// İndirimli fiyat hesaplama fonksiyonu (varyant destekli)
if (!function_exists('indirimliFiyatHesapla')) {
    /**
     * Ürünün veya varyantın indirimli fiyatını hesaplar.
     *
     * @param object $urun Ürün nesnesi
     * @param object|null $varyant Varyant nesnesi (opsiyonel)
     * @return float İndirimli fiyat
     */
    function indirimliFiyatHesapla($urun, $varyant = null): float
    {
        $birimFiyat = $varyant ? $varyant->birim_fiyat : $urun->birim_fiyat;
        $indirimOran = tekliIndirimOran($urun, $varyant);
        $indirimliFiyat = $birimFiyat - ($birimFiyat * ($indirimOran / 100));


        return round(kullaniciIndirimOrani($urun, $indirimliFiyat), 2);
    }
}

// Varyant seçimi fonksiyonu
if (!function_exists('urunVaryantSec')) {
    /**
     * Ürün varyantını getirir.
     *
     * @param int $urunId Ürün ID
     * @param array $secimler Seçilen varyant kombinasyonu
     * @return object|null Varyant nesnesi
     */
    function urunVaryantSec($urunId, $secimler)
    {
        $varyant = DB::table('urun_varyant_secim')
            ->where('urun_id', $urunId)
            ->whereJsonContains('urun_varyantlar', $secimler)
            ->first();

        return $varyant ?: null;
    }
}

// Kısa yazı oluşturma fonksiyonu
if (!function_exists('kisa_yazi')) {
    /**
     * Metni belirli bir uzunlukta kırpar ve sonuna "..." ekler.
     * Türkçe karakterlerle uyumlu çalışır.
     *
     * @param string $yazi Orijinal metin
     * @param int $limit Karakter sınırı (varsayılan: 150)
     * @return string Kısaltılmış metin
     */
    function kisa_yazi($yazi, $limit = 150): string
    {
        $temizYazi = strip_tags($yazi);
        if (mb_strlen($temizYazi, 'UTF-8') <= $limit) {
            return $temizYazi;
        }
        return mb_substr($temizYazi, 0, $limit, 'UTF-8') . '...';
    }
}

// Hash şifreleme fonksiyonu
if (!function_exists('hashSifreleme')) {
    /**
     * Hash değerlerini birleştirir ve SHA1 algoritması ile şifreler.
     *
     * @param array $hashDegerleri Hash için kullanılacak değerler
     * @return string Şifrelenmiş hash değeri
     */
    function hashSifreleme($hashDegerleri): string
    {
        $hashDegeri = implode('', $hashDegerleri);
        return base64_encode(sha1(mb_convert_encoding($hashDegeri, "ISO-8859-9"), true));
    }
}

// Görseli Base64 formatına çevirme fonksiyonu
if (!function_exists('base64_encode_image')) {
    /**
     * Dosya yolundaki görseli Base64 formatına çevirir.
     *
     * @param string $path Dosya yolu
     * @return string Base64 formatında görsel
     */
    function base64_encode_image($path)
    {
        $file = Storage::get($path); // Dosya içeriğini al
        $type = Storage::mimeType($path); // Dosya tipini al
        return 'data:' . $type . ';base64,' . base64_encode($file); // Base64 formatında döndür
    }
}

// Editor içerik formatlama fonksiyonu
if (!function_exists('formatEditor')) {
    /**
     * Editor içeriğinde bulunan Base64 görselleri kaydeder ve URL'lerini günceller.
     *
     * @param string $modul Modül adı
     * @param string $slug Slug bilgisi
     * @param string $icerik HTML içerik
     * @return string Güncellenmiş HTML içerik
     */
    function formatEditor($modul, $slug, $icerik)
    {
        $dom = new \DOMDocument();
        $dom->loadHTML(mb_convert_encoding($icerik, 'HTML-ENTITIES', 'UTF-8'));
        $resimler = $dom->getElementsByTagName('img');

        foreach ($resimler as $resim) {
            $resimKaynak = $resim->getAttribute('src');
            if (strpos($resimKaynak, 'data:image') === 0) {
                preg_match('/^data:image\/(\w+);base64,/', $resimKaynak, $tur);
                $resimTuru = $tur[1];
                $resimVerisi = substr($resimKaynak, strpos($resimKaynak, ',') + 1);
                $resimVerisi = base64_decode($resimVerisi);
                $dosyaAdi = uniqid() . '.' . $resimTuru;
                $dosyaYolu = $modul . '_resim/' . $slug . '/editor/' . $dosyaAdi;
                Storage::disk('public')->put($dosyaYolu, $resimVerisi);
                $resimUrl = ltrim(Storage::url($dosyaYolu), '/');
                $resim->setAttribute('src', $resimUrl);
            }
        }

        $govde = $dom->getElementsByTagName('body')->item(0);
        $govdeIcerigi = '';
        foreach ($govde->childNodes as $cocuk) {
            $govdeIcerigi .= $dom->saveHTML($cocuk);
        }
        return $govdeIcerigi;
    }
}

// Tarih formatlama fonksiyonu
if (!function_exists('formatZaman')) {
    /**
     * Verilen tarih bilgisini istenilen formatta döndürür.
     *
     * @param string $tarih Tarih bilgisi
     * @param string $format Format tipi (full, yil, saat, plus)
     * @return string Formatlanmış tarih
     */
    function formatZaman($tarih, $format = "full"): string
    {
        return match ($format) {
            'full' => Carbon::parse($tarih)->format('d.m.Y H:i:s'),
            'yil' => Carbon::parse($tarih)->format('d.m.Y'),
            'saat' => Carbon::parse($tarih)->format('H:i'),
            'plus' => Carbon::parse($tarih)->format('d.m.Y H:i'),
            default => "Tarih Formatı Bulunamadı ...",
        };
    }
}

// Para formatlama fonksiyonu
if (!function_exists('formatPara')) {
    /**
     * Para birimini Türk formatına göre düzenler.
     *
     * @param float $number Para miktarı
     * @param int $decimals Ondalık basamak sayısı (varsayılan: 2)
     * @return string Formatlanmış para birimi
     */
    function formatPara(float $number, int $decimals = 2): string
    {
        return number_format($number, $decimals, ",", ".");
    }
}

if (!function_exists('yetkiKontrol')) {
    /**
     * Kullanıcının belirli bir yetkisi olup olmadığını kontrol eder.
     *
     * @param mixed $permissions
     * @return bool
     */
    function yetkiKontrol($permissions = null)
    {
        $user = auth()->guard('admin');
        if ($user->check()) {
            $user = $user->user();

            if (!$user->isSuperAdmin()) {
                if ($permissions) {
                    if (is_array($permissions)) {
                        foreach ($permissions as $permission) {
                            if ($user->can($permission)) {
                                return true;
                            }
                        }
                    } else {
                        if ($user->can($permissions)) {
                            return true;
                        }
                    }
                }
            } else {
                return true;
            }

            return false; // Kullanıcı belirtilen rol ve yetkilere sahip değilse
        }
        return false;
    }
}

if (!function_exists('rolKontrol')) {
    /**
     * Kullanıcının belirli bir rolü olup olmadığını kontrol eder.
     *
     * @param mixed $roles
     * @return bool
     */
    function rolKontrol($roles = null)
    {
        $user = auth()->guard('admin');
        if ($user->check()) {
            $user = $user->user();

            if ($roles) {
                if (is_array($roles)) {
                    foreach ($roles as $role) {
                        if ($user->hasRole($role)) {
                            return true;
                        }
                    }
                } else {
                    if ($user->hasRole($roles)) {
                        return true;
                    }
                }
            }

            return false; // Kullanıcı belirtilen rollere sahip değilse
        }
        return false;
    }
}

if (!function_exists('admin')) {
    function admin()
    {
        if (auth()->guard('admin')->check()) {
            return auth()->guard('admin')->user();
        }
        return [];
    }
}

if (!function_exists('kullaniciHareketleri')) {
    function kullaniciHareketleri()
    {
        $ip_adresi = request()->ip();
        $ipSorgu = IpApiHelper::getIpInfo();

        $kullanici_id = Auth::guard('web')->check() ? Auth::guard('web')->id() : null;
        $url = request()->path();

        if (!empty($ipSorgu) && !empty($ipSorgu["country"]) && $ipSorgu["country"] == "Türkiye") {
            KullaniciHareketleri::create([
                'kullanici_id' => $kullanici_id,
                'ip_adresi' => $ip_adresi,
                'url' => $url,
                'tarayici_isim' => Browser::browserFamily() ?? '',
                'tarayici_surum' => Browser::browserVersion() ?? '',
                'platform_isim' => Browser::platformFamily() ?? '',
                'platform_surum' => Browser::platformVersion() ?? "0.00",
                'cihaz_tip' => (Browser::isDesktop() ? "Bilgisayar" : (Browser::isMobile() ? "Telefon" : "Diğer")),
                'bot_bilgi' => Browser::isBot(),
                'ulke' => $ipSorgu["country"],
                'il_id' => $ipSorgu["region"]
            ]);
        }
    }
}

if (!function_exists('depolamaUrl')) {
    function depolamaUrl($dosyaKaydi = null, $varsayilan = 'web/images/varsayilan_resim.png')
    {
        if (!empty($dosyaKaydi)) {
            if (!empty($dosyaKaydi->resim_url)) {
                $dosyaYolu = $dosyaKaydi->resim_url;
            } else if (!empty($dosyaKaydi->video_url)) {
                $dosyaYolu = $dosyaKaydi->video_url;
            } else {
                return Storage::url($varsayilan);
            }

            return Storage::exists($dosyaYolu) ? Storage::url($dosyaYolu) : Storage::url($varsayilan);
        }
        return Storage::url($varsayilan);
    }
}

if (!function_exists('dovizler')) {
    function dovizler($doviz)
    {
        $dovizDeger = null;

        // Veritabanı sorgularını tek seferde çekip performansı artırıyoruz
        $dovizVerisi = Doviz::where('doviz', strtoupper($doviz))->first();

        if (!$dovizVerisi) {
            return 0; // Geçersiz döviz tipi için 0 dönüyoruz
        }

        switch (strtoupper($doviz)) {
            case 'USD':
                $dovizDeger = $dovizVerisi->kur;
                break;
            case 'XAG': // Gümüş Ons
                $dolarDeger = Doviz::where('doviz', 'USD')->value('kur');
                $dovizDeger = $dovizVerisi->kur * $dolarDeger;
                break;
            case 'GUMUS-GRAM':
                $dolarDeger = Doviz::where('doviz', 'USD')->value('kur');
                $dovizDeger = ($dovizVerisi->kur * $dolarDeger); // Ons'tan gram çevirimi
                break;
            default:
                $dovizDeger = 0;
                break;
        }

        return $dovizDeger;
    }
}

if (!function_exists('kullaniciIndirimOrani')) {
    function kullaniciIndirimOrani($urun, $fiyat)
    {
        if (Auth::guard('web')->check()) {
            $kullaniciId = Auth::guard('web')->id();
            $kullaniciIndirimi = KullaniciIndirim::where('kullanici_id', $kullaniciId)
                ->where('urun_kategori_id', $urun->urun_kategori_id)
                ->first();

            if ($kullaniciIndirimi) {
                $indirimOrani = $kullaniciIndirimi->deger ?? 0;
                return $fiyat - ($fiyat * ($indirimOrani / 100));
            }
        }
        return $fiyat;
    }
}
