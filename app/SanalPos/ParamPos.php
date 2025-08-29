<?php

namespace App\SanalPos;

use DOMDocument;
use Illuminate\Support\Facades\Http;

class ParamPos
{

    /** 3D DOĞRULAMA İŞLEMİ */
    public static function istekGonderUCD($siparisBilgi)
    {
        $islemId = uniqid();
        $siparisId = $siparisBilgi["siparisId"];
        $paramPosUrl = config('sanalpos.api_url');
        $paramPosKullaniciKod = config('sanalpos.client_code');
        $paramPosGuid = config('sanalpos.client_guid');

        $hashDegerleri = [
            $paramPosKullaniciKod,
            $paramPosGuid,
            $siparisBilgi["taksit"],
            $siparisBilgi["islemTutar"],
            $siparisBilgi["toplamTutar"],
            $siparisId
        ];

        $hash = hashSifreleme($hashDegerleri);

        $veri = [
            "kullaniciIp" => request()->ip(),
            "islemId" => $islemId,
            "siparisId" => $siparisId,
            "paramPosUrl" => $paramPosUrl,
            "paramPosKullaniciKod" => $paramPosKullaniciKod,
            "paramPosKullaniciAdi" => config('sanalpos.client_username'),
            "paramPosKullaniciSifre" => config('sanalpos.client_password'),
            "paramPosGuid" => $paramPosGuid,
            "hash" => $hash,
            "kartSahibi" => $siparisBilgi["kartSahibi"],
            "kartNo" => $siparisBilgi["kartNo"],
            "kartAy" => $siparisBilgi["kartAy"],
            "kartYil" => $siparisBilgi["kartYil"],
            "kartCvc" => $siparisBilgi["kartCvc"],
            "kartGsm" => $siparisBilgi["kartGsm"],
            "taksit" => $siparisBilgi["taksit"],
            "islemTutar" => $siparisBilgi["islemTutar"],
            "toplamTutar" => $siparisBilgi["toplamTutar"],
        ];

        $xml = self::xmlUretUCD($veri);

        $response = Http::withHeaders([
            'Content-Type' => 'application/soap+xml; charset=utf-8',
            'SOAPAction' => 'https://turkpos.com.tr/TP_WMD_UCD'
        ])->withBody($xml, 'application/soap+xml')->post($paramPosUrl);

        return self::cevabiIsleUCD($response);
    }

    private static function xmlUretUCD($veri)
    {
        return '<?xml version="1.0" encoding="utf-8"?>
        <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                          xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                          xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
            <soap12:Body>
                <TP_WMD_UCD xmlns="https://turkpos.com.tr/">
                    <G>
                        <CLIENT_CODE>' . $veri['paramPosKullaniciKod'] . '</CLIENT_CODE>
                        <CLIENT_USERNAME>' . $veri['paramPosKullaniciAdi'] . '</CLIENT_USERNAME>
                        <CLIENT_PASSWORD>' . $veri['paramPosKullaniciSifre'] . '</CLIENT_PASSWORD>
                    </G>
                    <GUID>' . $veri['paramPosGuid'] . '</GUID>
                    <KK_Sahibi>' . $veri['kartSahibi'] . '</KK_Sahibi>
                    <KK_No>' . $veri['kartNo'] . '</KK_No>
                    <KK_SK_Ay>' . $veri['kartAy'] . '</KK_SK_Ay>
                    <KK_SK_Yil>' . $veri['kartYil'] . '</KK_SK_Yil>
                    <KK_CVC>' . $veri['kartCvc'] . '</KK_CVC>
                    <KK_Sahibi_GSM>' . $veri['kartGsm'] . '</KK_Sahibi_GSM>
                    <Hata_URL>' . route('odeme.basarisiz') . '</Hata_URL>
                    <Basarili_URL>' . route('odeme.basarili') . '</Basarili_URL>
                    <Siparis_ID>' . $veri['siparisId'] . '</Siparis_ID>
                    <Siparis_Aciklama>-</Siparis_Aciklama>
                    <Taksit>' . $veri['taksit'] . '</Taksit>
                    <Islem_Tutar>' . $veri['islemTutar'] . '</Islem_Tutar>
                    <Toplam_Tutar>' . $veri['toplamTutar'] . '</Toplam_Tutar>
                    <Islem_Hash>' . $veri['hash'] . '</Islem_Hash>
                    <Islem_Guvenlik_Tip>3D</Islem_Guvenlik_Tip>
                    <Islem_ID>' . $veri['islemId'] . '</Islem_ID>
                    <IPAdr>' . $veri['kullaniciIp'] . '</IPAdr>
                    <Ref_URL>' . env('APP_URL') . '</Ref_URL>
                    <Data1>a</Data1>
                    <Data2>a</Data2>
                    <Data3>a</Data3>
                    <Data4>a</Data4>
                    <Data5>a</Data5>
                </TP_WMD_UCD>
            </soap12:Body>
        </soap12:Envelope>';
    }
    private static function cevabiIsleUCD($response)
    {
        if ($response->successful()) {
            $dom = new DOMDocument();
            $dom->loadXML($response->body());

            $body = $dom->getElementsByTagName('Body')->item(0);
            $responseElement = $body->getElementsByTagName('TP_WMD_UCDResponse')->item(0);
            $resultElement = $responseElement->getElementsByTagName('TP_WMD_UCDResult')->item(0);

            return [
                'durum' => true,
                'Islem_ID' => $resultElement->getElementsByTagName('Islem_ID')->item(0)->nodeValue,
                'Islem_GUID' => $resultElement->getElementsByTagName('Islem_GUID')->item(0)->nodeValue,
                'UCD_HTML' => $resultElement->getElementsByTagName('UCD_HTML')->item(0)->nodeValue,
                'UCD_MD' => $resultElement->getElementsByTagName('UCD_MD')->item(0)->nodeValue,
                'Sonuc' => $resultElement->getElementsByTagName('Sonuc')->item(0)->nodeValue,
                'Sonuc_Str' => $resultElement->getElementsByTagName('Sonuc_Str')->item(0)->nodeValue,
                'Banka_Sonuc_Kod' => $resultElement->getElementsByTagName('Banka_Sonuc_Kod')->item(0)->nodeValue,
                'Siparis_ID' => $resultElement->getElementsByTagName('Siparis_ID')->item(0)->nodeValue,
            ];
        } else {
            return [
                'durum' => false,
                'detay' => $response->body()
            ];
        }
    }

    /*************************************************************** 
     * 
     * KARTTAN PARA ÇEKME İŞLEMİ */

    public static function istekGonderPay($veri)
    {

        $paramPosGuid = config('sanalpos.client_guid');

        $hashDegerleri = [
            $veri["islemGUID"],
            $veri["md"],
            $veri["mdStatus"],
            $veri["orderId"],
            $paramPosGuid
        ];

        $hash = hashSifreleme($hashDegerleri);

        if (!($veri["islemHash"] == $hash)) {
            return to_route('odeme-basarisiz');
        }

        $paramPosUrl = config('sanalpos.api_url');
        $paramPosKullaniciKod = config('sanalpos.client_code');
        $paramPosGuid = config('sanalpos.client_guid');


        $veri = [
            "paramPosKullaniciKod" => $paramPosKullaniciKod,
            "paramPosKullaniciAdi" => config('sanalpos.client_username'),
            "paramPosKullaniciSifre" => config('sanalpos.client_password'),
            "paramPosGuid" => $paramPosGuid,
            "ucdMd" => $veri["md"],
            "islemGuid" => $veri["islemGUID"],
            "siparisId" => $veri["orderId"],
        ];

        $xml = self::xmlUretPay($veri);

        $response = Http::withHeaders([
            'Content-Type' => 'application/soap+xml; charset=utf-8',
            'SOAPAction' => 'https://turkpos.com.tr/TP_WMD_Pay'
        ])->withBody($xml, 'application/soap+xml')->post($paramPosUrl);

        return self::cevabiIslePay($response);
    }

    private static function xmlUretPay($veri)
    {
        return '<?xml version="1.0" encoding="utf-8"?>
        <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
                         xmlns:xsd="http://www.w3.org/2001/XMLSchema" 
                         xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
          <soap12:Body>
            <TP_WMD_Pay xmlns="https://turkpos.com.tr/">
              <G>
                <CLIENT_CODE>' . $veri["paramPosKullaniciKod"] . '</CLIENT_CODE>
                <CLIENT_USERNAME>' . $veri["paramPosKullaniciAdi"] . '</CLIENT_USERNAME>
                <CLIENT_PASSWORD>' . $veri["paramPosKullaniciSifre"] . '</CLIENT_PASSWORD>
              </G>
              <GUID>' . $veri["paramPosGuid"] . '</GUID>
              <UCD_MD>' . $veri["ucdMd"] . '</UCD_MD>
              <Islem_GUID>' . $veri["islemGuid"] . '</Islem_GUID>
              <Siparis_ID>' . $veri["siparisId"] . '</Siparis_ID>
            </TP_WMD_Pay>
          </soap12:Body>
        </soap12:Envelope>';
    }

    private static function cevabiIslePay($response)
    {
        if ($response->successful()) {
            $dom = new DOMDocument();
            $dom->loadXML($response->body());

            $body = $dom->getElementsByTagName('Body')->item(0);
            $responseElement = $body->getElementsByTagName('TP_WMD_PayResponse')->item(0);
            $resultElement = $responseElement->getElementsByTagName('TP_WMD_PayResult')->item(0);

            return [
                'Sonuc' => $resultElement->getElementsByTagName('Sonuc')->item(0)->nodeValue,
                'Sonuc_Ack' => $resultElement->getElementsByTagName('Sonuc_Ack')->item(0)->nodeValue,
                'Dekont_ID' => $resultElement->getElementsByTagName('Dekont_ID')->item(0)->nodeValue,
                'Siparis_ID' => $resultElement->getElementsByTagName('Siparis_ID')->item(0)->nodeValue,
            ];
        } else {
            return [
                'hata' => 'İstek başarısız',
                'detay' => $response->body()
            ];
        }
    }

    /*************************************************************** 
     * 
     * KREDİ KARTI TAKSİT KOMİSYONLARU */

    public static function istekGonderKomisyon()
    {
        $paramPosUrl = config('sanalpos.api_url');
        $paramPosKullaniciKod = config('sanalpos.client_code');
        $paramPosGuid = config('sanalpos.client_guid');

        $veri = [
            "paramPosKullaniciKod" => $paramPosKullaniciKod,
            "paramPosKullaniciAdi" => config('sanalpos.client_username'),
            "paramPosKullaniciSifre" => config('sanalpos.client_password'),
            "paramPosGuid" => $paramPosGuid,
        ];

        $xml = self::xmlUretKomisyon($veri);

        $response = Http::withHeaders([
            'Content-Type' => 'application/soap+xml; charset=utf-8',
            'SOAPAction' => 'https://turkpos.com.tr/TP_Ozel_Oran_Liste'
        ])->withBody($xml, 'application/soap+xml')->post($paramPosUrl);

        return self::cevabiIsleKomisyon($response);
    }

    private static function xmlUretKomisyon($veri)
    {

        return '<?xml version="1.0" encoding="utf-8"?>
        <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
                         xmlns:xsd="http://www.w3.org/2001/XMLSchema" 
                         xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
          <soap12:Body>
            <TP_Ozel_Oran_SK_Liste xmlns="https://turkpos.com.tr/">
              <G>
                <CLIENT_CODE>' . $veri["paramPosKullaniciKod"] . '</CLIENT_CODE>
                <CLIENT_USERNAME>' . $veri["paramPosKullaniciAdi"] . '</CLIENT_USERNAME>
                <CLIENT_PASSWORD>' . $veri["paramPosKullaniciSifre"] . '</CLIENT_PASSWORD>
              </G>
              <GUID>' . $veri["paramPosGuid"] . '</GUID>
            </TP_Ozel_Oran_SK_Liste>
          </soap12:Body>
        </soap12:Envelope>';
    }

    private static function cevabiIsleKomisyon($response)
    {
        if ($response->successful()) {
            $dom = new DOMDocument();
            $dom->loadXML($response->body());

            $body = $dom->getElementsByTagName('Body')->item(0);

            $responseElement = $body->getElementsByTagName('TP_Ozel_Oran_SK_ListeResponse')->item(0);
            $resultElement = $responseElement->getElementsByTagName('TP_Ozel_Oran_SK_ListeResult')->item(0);

            $sonuc = $resultElement->getElementsByTagName('Sonuc')->item(0)->nodeValue;
            $sonucStr = $resultElement->getElementsByTagName('Sonuc_Str')->item(0)->nodeValue;

            $dtBilgiElement = $resultElement->getElementsByTagName('DT_Bilgi')->item(0);

            $oranlar = [];

            if ($dtBilgiElement) {
                $dataSet = $dtBilgiElement->getElementsByTagName('NewDataSet')->item(0);
                $dtOzelOranlar = $dataSet->getElementsByTagName('DT_Ozel_Oranlar_SK');

                foreach ($dtOzelOranlar as $oran) {
                    $krediKartiBanka = $oran->getElementsByTagName('Kredi_Karti_Banka')->item(0);

                    if ($krediKartiBanka) {
                        $oranlar[] = [
                            'Ozel_Oran_SK_ID' => $oran->getElementsByTagName('Ozel_Oran_SK_ID')->item(0)->nodeValue,
                            'GUID' => $oran->getElementsByTagName('GUID')->item(0)->nodeValue,
                            'SanalPOS_ID' => $oran->getElementsByTagName('SanalPOS_ID')->item(0)->nodeValue,
                            'Kredi_Karti_Banka' => $oran->getElementsByTagName('Kredi_Karti_Banka')->item(0)->nodeValue,
                            'Kredi_Karti_Banka_Gorsel' => $oran->getElementsByTagName('Kredi_Karti_Banka_Gorsel')->item(0)->nodeValue,
                            'MO_01' => $oran->getElementsByTagName('MO_01')->item(0)->nodeValue,
                            'MO_02' => $oran->getElementsByTagName('MO_02')->item(0)->nodeValue,
                            'MO_03' => $oran->getElementsByTagName('MO_03')->item(0)->nodeValue,
                            'MO_04' => $oran->getElementsByTagName('MO_04')->item(0)->nodeValue,
                            'MO_05' => $oran->getElementsByTagName('MO_05')->item(0)->nodeValue,
                            'MO_06' => $oran->getElementsByTagName('MO_06')->item(0)->nodeValue,
                            'MO_07' => $oran->getElementsByTagName('MO_07')->item(0)->nodeValue,
                            'MO_08' => $oran->getElementsByTagName('MO_08')->item(0)->nodeValue,
                            'MO_09' => $oran->getElementsByTagName('MO_09')->item(0)->nodeValue,
                            'MO_10' => $oran->getElementsByTagName('MO_10')->item(0)->nodeValue,
                            'MO_11' => $oran->getElementsByTagName('MO_11')->item(0)->nodeValue,
                            'MO_12' => $oran->getElementsByTagName('MO_12')->item(0)->nodeValue,
                        ];
                    }
                }
            }

            return [
                'Sonuc' => $sonuc,
                'Sonuc_Str' => $sonucStr,
                'Oranlar' => $oranlar,
            ];
        } else {
            return [
                'hata' => 'İstek başarısız',
                'detay' => $response->body()
            ];
        }
    }


    public static function istekGonderKartBilgi($kartNo)
    {
        $paramPosUrl = config('sanalpos.api_url');
        $paramPosKullaniciKod = config('sanalpos.client_code');

        $veri = [
            "paramPosKullaniciKod" => $paramPosKullaniciKod,
            "paramPosKullaniciAdi" => config('sanalpos.client_username'),
            "paramPosKullaniciSifre" => config('sanalpos.client_password'),
            "BIN" => $kartNo,
        ];

        $xml = self::xmlUretKartBilgi($veri);

        $response = Http::withHeaders([
            'Content-Type' => 'application/soap+xml; charset=utf-8',
            'SOAPAction' => 'https://turkpos.com.tr/BIN_SanalPos'
        ])->withBody($xml, 'application/soap+xml')->post($paramPosUrl);

        return self::cevabiIsleKartBilgi($response);
    }

    private static function xmlUretKartBilgi($veri)
    {

        return '<?xml version="1.0" encoding="utf-8"?>
         <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
                         xmlns:xsd="http://www.w3.org/2001/XMLSchema" 
                         xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
            <soap12:Body>
                <BIN_SanalPos xmlns="https://turkpos.com.tr/">
                    <G>
                        <CLIENT_CODE>' . $veri["paramPosKullaniciKod"] . '</CLIENT_CODE>
                        <CLIENT_USERNAME>' . $veri["paramPosKullaniciAdi"] . '</CLIENT_USERNAME>
                        <CLIENT_PASSWORD>' . $veri["paramPosKullaniciSifre"] . '</CLIENT_PASSWORD>
                    </G>
                    <BIN>' . $veri["BIN"] . '</BIN>
                </BIN_SanalPos>
            </soap12:Body>
        </soap12:Envelope>';
    }

    private static function cevabiIsleKartBilgi($response)
    {
        if ($response->successful()) {
            $dom = new DOMDocument();
            $dom->loadXML($response->body());

            $body = $dom->getElementsByTagName('Body')->item(0);
            $responseElement = $body->getElementsByTagName('BIN_SanalPosResponse')->item(0);
            $resultElement = $responseElement->getElementsByTagName('BIN_SanalPosResult')->item(0);

            $sonuc = $resultElement->getElementsByTagName('Sonuc')->item(0)->nodeValue;
            $sonucStr = $resultElement->getElementsByTagName('Sonuc_Str')->item(0)->nodeValue;

            $dtBilgiElement = $resultElement->getElementsByTagName('DT_Bilgi')->item(0);

            $binler = [];

            if ($dtBilgiElement) {
                $dataSet = $dtBilgiElement->getElementsByTagName('NewDataSet')->item(0);
                $tempElements = $dataSet->getElementsByTagName('Temp');

                foreach ($tempElements as $temp) {
                    $binler[] = [
                        'BIN' => $temp->getElementsByTagName('BIN')->item(0) ? $temp->getElementsByTagName('BIN')->item(0)->nodeValue : null,
                        'SanalPOS_ID' => $temp->getElementsByTagName('SanalPOS_ID')->item(0) ? $temp->getElementsByTagName('SanalPOS_ID')->item(0)->nodeValue : null,
                        'Kart_Banka' => $temp->getElementsByTagName('Kart_Banka')->item(0) ? $temp->getElementsByTagName('Kart_Banka')->item(0)->nodeValue : null,
                        'DKK' => $temp->getElementsByTagName('DKK')->item(0) ? $temp->getElementsByTagName('DKK')->item(0)->nodeValue : null,
                        'Kart_Tip' => $temp->getElementsByTagName('Kart_Tip')->item(0) ? $temp->getElementsByTagName('Kart_Tip')->item(0)->nodeValue : null,
                        'Kart_Org' => $temp->getElementsByTagName('Kart_Org')->item(0) ? $temp->getElementsByTagName('Kart_Org')->item(0)->nodeValue : null,
                        'Banka_Kodu' => $temp->getElementsByTagName('Banka_Kodu')->item(0) ? $temp->getElementsByTagName('Banka_Kodu')->item(0)->nodeValue : null,
                    ];
                }
            }

            return [
                'Sonuc' => $sonuc,
                'Sonuc_Str' => $sonucStr,
                'BINS' => $binler,
            ];
        } else {
            return [
                'hata' => 'İstek başarısız',
                'detay' => $response->body()
            ];
        }
    }

}
