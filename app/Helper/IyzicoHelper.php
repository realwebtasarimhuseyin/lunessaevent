<?php

namespace App\Helper;

use Iyzipay\Options;
use Iyzipay\Model\Locale;
use Iyzipay\Model\Currency;
use Iyzipay\Model\PaymentGroup;
use Iyzipay\Model\BasketItemType;
use Iyzipay\Request\CreateCheckoutFormInitializeRequest;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\Address;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\CheckoutFormInitialize;
use Iyzipay\Request\RetrieveCheckoutFormRequest;
use Iyzipay\Model\CheckoutForm;

class IyzicoHelper
{
    public static function odemeOlustur(array $parametreler)
    {
        // API anahtarlari ve base URL
        $apiKey = env("IYZICO_API_KEY");
        $secretKey = env("IYZICO_SECRET_KEY");
        $url_base = env('IYZICO_BASEURL');

        // Seçenekleri başlat
        $secenekler = new Options();
        $secenekler->setApiKey($apiKey);
        $secenekler->setSecretKey($secretKey);
        $secenekler->setBaseUrl($url_base);

        // İstek nesnesini başlat
        $istek = new CreateCheckoutFormInitializeRequest();
        $istek->setLocale(Locale::TR);
        $istek->setConversationId($parametreler['konusma_id']);
        $istek->setPrice($parametreler['fiyat']);
        $istek->setPaidPrice($parametreler['odenen_fiyat']);
        $istek->setCurrency(Currency::TL);
        $istek->setBasketId($parametreler['sepet_id']);
        $istek->setPaymentGroup(PaymentGroup::PRODUCT);

        // Alıcı (Buyer) bilgilerini ayarla
        $alici = new Buyer();
        $alici->setId($parametreler['alici_id']);
        $alici->setName($parametreler['alici_ad']);
        $alici->setSurname($parametreler['alici_soyad']);
        $alici->setGsmNumber($parametreler['alici_telefon']);
        $alici->setEmail($parametreler['alici_email']);
        $alici->setIdentityNumber($parametreler['alici_tc']);
        $alici->setLastLoginDate($parametreler['alici_son_giris']);
        $alici->setRegistrationDate($parametreler['alici_kayit_tarihi']);
        $alici->setRegistrationAddress($parametreler['alici_adres']);
        $alici->setIp($parametreler['alici_ip']);
        $alici->setCity($parametreler['alici_sehir']);
        $alici->setCountry($parametreler['alici_ulke']);
        $alici->setZipCode($parametreler['alici_posta_kodu']);
        $istek->setBuyer($alici);

        // Teslimat ve fatura adreslerini ayarla
        $teslimatAdresi = new Address();
        $teslimatAdresi->setContactName($parametreler['teslimat_ad']);
        $teslimatAdresi->setCity($parametreler['teslimat_sehir']);
        $teslimatAdresi->setCountry($parametreler['teslimat_ulke']);
        $teslimatAdresi->setAddress($parametreler['teslimat_adres']);
        $teslimatAdresi->setZipCode($parametreler['teslimat_posta_kodu']);
        $istek->setShippingAddress($teslimatAdresi);

        $faturaAdresi = new Address();
        $faturaAdresi->setContactName($parametreler['fatura_ad']);
        $faturaAdresi->setCity($parametreler['fatura_sehir']);
        $faturaAdresi->setCountry($parametreler['fatura_ulke']);
        $faturaAdresi->setAddress($parametreler['fatura_adres']);
        $faturaAdresi->setZipCode($parametreler['fatura_posta_kodu']);
        $istek->setBillingAddress($faturaAdresi);

        // Sepet öğelerini ayarla
        $sepetUrunleri = [];
        foreach ($parametreler['sepet_urunleri'] as $urun) {
            $sepetItem = new BasketItem();
            $sepetItem->setId($urun['id']);
            $sepetItem->setName($urun['ad']);
            $sepetItem->setCategory1($urun['kategori1']);
            $sepetItem->setCategory2($urun['kategori2']);
            $sepetItem->setItemType(BasketItemType::PHYSICAL);
            $sepetItem->setPrice($urun['fiyat']);
            $sepetUrunleri[] = $sepetItem;
        }
        $istek->setBasketItems($sepetUrunleri);

        // Callback URL
        $istek->setCallbackUrl($parametreler['geri_donus_url']);

        // Ödeme formunu oluştur
        $odeme = CheckoutFormInitialize::create($istek, $secenekler);

        // Dönen veriyi hazırla
        $data = [
            'ham_sonuc' => json_decode($odeme->getRawResult(), true),
            'locale' => $odeme->getLocale(),
            'konusma_id' => $odeme->getConversationId(),
            'hata_kodu' => $odeme->getErrorCode(),
            'hata_mesaji' => $odeme->getErrorMessage(),
            'hata_grubu' => $odeme->getErrorGroup(),
            'sistem_zamani' => $odeme->getSystemTime(),
            'token' => $odeme->getToken(),
            'token_sure_son' => $odeme->getTokenExpireTime(),
            'odeme_sayfasi_url' => $odeme->getPaymentPageUrl(),
            'imza' => $odeme->getSignature(),
            'html' => $odeme->getCheckoutFormContent(),
            'durum' => $odeme->getStatus(),
        ];

        // İmza doğrulaması
        $imza = $odeme->getSignature();
        $token = $odeme->getToken();
        $konusmaId = $odeme->getConversationId();

        $hesaplananImza = self::imzaHesapla(array($konusmaId, $token));
        $dogrulandi = $imza == $hesaplananImza;

        return [
            'data' => $data,
            'imza_dogrulama' => $dogrulandi
        ];
    }

    // İmza hesaplama fonksiyonu
    public static function imzaHesapla(array $veriler)
    {
        $secretKey = env("IYZICO_SECRET_KEY");
        $dataToSign = implode(':', $veriler);
        $mac = hash_hmac('sha256', $dataToSign, $secretKey, true);
        return bin2hex($mac);
    }

    // Geri dönüş işlemi
    public static function geriDonus($istek)
    {
        $token = $istek->input('token');

        $istekObjesi = new RetrieveCheckoutFormRequest();
        $istekObjesi->setLocale(Locale::TR);
        $istekObjesi->setConversationId("123456789");
        $istekObjesi->setToken($token);

        $apiAnahtari = env("IYZICO_API_KEY");
        $secretAnahtari = env("IYZICO_SECRET_KEY");
        $urlTemeli = env('IYZICO_BASEURL');

        $secenekler = new Options();
        $secenekler->setApiKey($apiAnahtari);
        $secenekler->setSecretKey($secretAnahtari);
        $secenekler->setBaseUrl($urlTemeli);

        $odemeFormu = CheckoutForm::retrieve($istekObjesi, $secenekler);

        // Genel ödeme bilgilerini al
        $taksit = $odemeFormu->getInstallment();
        $odemeDurumu = $odemeFormu->getPaymentStatus();
        $odemeId = $odemeFormu->getPaymentId();
        $paraBirimi = $odemeFormu->getCurrency();
        $sepetId = $odemeFormu->getBasketId();
        $konusmaId = $odemeFormu->getConversationId();
        $odenenTutar = $odemeFormu->getPaidPrice();
        $fiyat = $odemeFormu->getPrice();
        $token = $odemeFormu->getToken();
        $imza = $odemeFormu->getSignature();
        $hata = $odemeFormu->getErrorMessage();

        // Ödeme ile ilgili kart ve işlem bilgilerini al
        $kartTuru = $odemeFormu->getCardType();
        $kartBirligi = $odemeFormu->getCardAssociation();
        $kartAilesi = $odemeFormu->getCardFamily();
        $binNumarasi = $odemeFormu->getBinNumber();
        $sonDortHaneliNumara = $odemeFormu->getLastFourDigits();
        $fraudDurumu = $odemeFormu->getFraudStatus();
        $merchantKomisyonOrani = $odemeFormu->getMerchantCommissionRate();
        $merchantKomisyonTutari = $odemeFormu->getMerchantCommissionRateAmount();
        $iyziKomisyonOraniTutari = $odemeFormu->getIyziCommissionRateAmount();
        $iyziKomisyonÜcreti = $odemeFormu->getIyziCommissionFee();

        $itemTransactions = $odemeFormu->getPaymentItems();
        $urunler = [];

        if (!empty($itemTransactions)) {
            foreach ($itemTransactions as $transaction) {

                $urunler[] = [
                    'urunId' => $transaction->getItemId(),
                    'odemeTransactionId' => $transaction->getPaymentTransactionId(),
                    'islemDurumu' => $transaction->getTransactionStatus(),
                    'urunFiyatı' => $transaction->getPrice(),
                    'odemeFiyatı' => $transaction->getPaidPrice(),
                    'merchantKomisyonOrani' => $transaction->getMerchantCommissionRate(),
                    'merchantKomisyonTutari' => $transaction->getMerchantCommissionRateAmount(),
                    'iyziKomisyonOraniTutari' => $transaction->getIyziCommissionRateAmount(),
                    'iyziKomisyonÜcreti' => $transaction->getIyziCommissionFee(),
                ];
            }
        }

        $callbackUrl = $odemeFormu->getCallbackUrl();
        $authKod = $odemeFormu->getAuthCode();
        $paymentPhase = $odemeFormu->getPhase();
        $status = $odemeFormu->getStatus();


        $hesaplananImza = self::imzaHesapla(array($odemeDurumu, $odemeId, $paraBirimi, $sepetId, $konusmaId, $odenenTutar, $fiyat, $token));
        $dogrulandi = $imza == $hesaplananImza;

        return [
            'taksit' => $taksit,
            'odemeDurumu' => $odemeDurumu,
            'odemeId' => $odemeId,
            'paraBirimi' => $paraBirimi,
            'sepetId' => $sepetId,
            'konusmaId' => $konusmaId,
            'odenenTutar' => $odenenTutar,
            'fiyat' => $fiyat,
            'token' => $token,
            'imza' => $imza,
            'dogrulandi' => $dogrulandi,
            'hata' => $hata,
            'kartTuru' => $kartTuru,
            'kartBirligi' => $kartBirligi,
            'kartAilesi' => $kartAilesi,
            'binNumarasi' => $binNumarasi,
            'sonDortHaneliNumara' => $sonDortHaneliNumara,
            'fraudDurumu' => $fraudDurumu,
            'merchantKomisyonOrani' => $merchantKomisyonOrani,
            'merchantKomisyonTutari' => $merchantKomisyonTutari,
            'iyziKomisyonOraniTutari' => $iyziKomisyonOraniTutari,
            'iyziKomisyonÜcreti' => $iyziKomisyonÜcreti,
            'urunler' => $urunler,
            'callbackUrl' => $callbackUrl,
            'authKod' => $authKod,
            'paymentPhase' => $paymentPhase,
            'status' => $status
        ];
    }
}
