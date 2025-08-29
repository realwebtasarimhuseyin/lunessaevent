<?php

namespace App\Services;

use Exception;
use SoapClient;
use SoapFault;

class SuratKargo {
    // WSDL URL
    public $liveRequest = 'https://webservices.suratkargo.com.tr/services.asmx?wsdl';
    public $username;
    public $password;
    public $dealerNo;
    public $lang = 'TR';
    public $query;

    function __construct($data = []) {
        if(!class_exists('SoapClient')) {
            echo 'SoapClient Not Found';
            exit;
        }

        $this->username = env('SURAT_KARGO_USERNAME');
        $this->password = env('SURAT_KARGO_PASSWORD');
        $this->dealerNo = env('SURAT_KARGO_DEALER_NO');

        $this->query();
    }

    function query() {
        $url = $this->liveRequest;
        $this->query = new SoapClient($url, ['trace' => 1]);
    }

    function createCargo($data = []) {

        $defaults = [
            'KisiKurum'                => '',
            'SahisBirim'               => '',
            'AliciAdresi'              => '',
            'Il'                       => '',
            'Ilce'                     => '',
            'TelefonEv'                => '',
            'TelefonIs'                => '',
            'TelefonCep'               => '',
            'Email'                    => '',
            'AliciKodu'                => '',
            'KargoTuru'                => 3,
            'OdemeTipi'                => 1,
            'IrsaliyeSeriNo'           => '',
            'IrsaliyeSiraNo'           => '',
            'ReferansNo'               => '',
            'OzelKargoTakipNo'         => '',
            'Adet'                     => 1,
            'BirimDesi'                => 7,
            'BirimKg'                  => 1,
            'KargoIcerigi'             => '',
            'KapidanOdemeTahsilatTipi' => '',
            'KapidanOdemeTutari'       => '',
            'EkHizmetler'              => '',
            'TasimaSekli'              => 1,
            'TeslimSekli'              => 1,
            'SevkAdresi'               => '',
            'GonderiSekli'             => 0,
            'TeslimSubeKodu'           => '',
            'Pazaryerimi'              => 0,
            'EntegrasyonFirmasi'       => '',
            'Iademi'                   => 0
        ];

        $data = array_merge($defaults, $data);

        $cargoData = [
            'KullaniciAdi' => $this->username,
            'Sifre'        => $this->password,
            'Gonderi'      => $data,
        ];

        try {
            $r = $this->query->GonderiyiKargoyaGonderYeni($cargoData);
            
            $lastRequest = $this->query->__getLastRequest();
            $lastResponse = $this->query->__getLastResponse();
            
            /*\Log::info('SOAP Request: ' . $lastRequest);
            \Log::info('SOAP Response: ' . $lastResponse);*/
            
            return $r;
        } catch (Exception $e) {
            /*\Log::error('Gönderi Hatası: ' . $e->getMessage());
            \Log::error('Last Request: ' . $this->query->__getLastRequest());*/
            return null;
        }
    }

    function cancelCargo($data = []) {

        $cargoData = [
            'wsUserName'   => $this->username,
            'wsPassword'   => $this->password,
            'userLanguage' => $this->lang,
            'cargoKeys'    => $data['cargoKeys'],
        ];

        try {
            return $this->query->cancelShipment($cargoData);
        } catch (Exception $e) {
            print_r('Hata : ' . $e->getMessage());
        }
    }

    function cargoStatus($data) {

        $cargoData = [
            'wsUserName'        => $this->username,
            'wsPassword'        => $this->password,
            'wsLanguage'        => $this->lang,
            'keys'              => $data['cargoKeys'] ?? $data['invoiceKey'],
            'keyType'           => isset($data['cargoKeys']) ? 0 : 1,
            'addHistoricalData' => true,
            'onlyTracking'      => true,
        ];

        try {
            return $this->query->queryShipment($cargoData);
        } catch (Exception $e) {
            print_r('Hata : ' . $e->getMessage());
        }
    }
}
