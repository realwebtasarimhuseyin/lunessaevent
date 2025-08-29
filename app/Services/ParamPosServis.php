<?php

namespace App\Services;

use App\SanalPos\ParamPos;

class ParamPosServis
{
    public static function kartTaksitBilgi($kartNo)
    {
        $kartBilgi = ParamPos::istekGonderKartBilgi($kartNo);

        if ($kartBilgi["Sonuc"] !== "1" || $kartBilgi["Sonuc_Str"] !== "Başarılı") {
            return response()->json([]);
        }

        $bin = $kartBilgi["BINS"][0];

        if ($bin["Kart_Tip"] === "Credit Card" || $bin["Kart_Tip"] == "Kredi Kartı") {          
            $oranlar = collect(ParamPos::istekGonderKomisyon()["Oranlar"]);
            return self::filterCommissionRates($oranlar, $bin["SanalPOS_ID"]);
        }

        return [];
    }

    public static function filterCommissionRates($oranlar, $sanalPosId)
    {
        $filteredData = $oranlar->filter(function ($oran) use ($sanalPosId) {
            return $oran['SanalPOS_ID'] == $sanalPosId;
        })->flatMap(function ($oran) {
            return collect($oran)->filter(function ($value, $key) {
                return str_starts_with($key, 'MO_');
            });
        });

        $result = $filteredData->map(function ($oran, $key) {
            $ay = ltrim(substr($key, 3), '0');
            return [
                'ay' => $ay,
                'oran' => $oran
            ];
        })->filter(function ($item) {
            return $item['ay'] != '1' && $item['oran'] >= 0;
        });

        return $result->values()->toArray();
    }
}
