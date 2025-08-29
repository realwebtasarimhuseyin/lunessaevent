<?php

namespace App\Enums;

enum SayfaBasliklariEnum: string
{
    case ANASAYFA = 'Anasayfa';
    case ILETISIM = 'İletişim';
    case HAKKIMIZDA = 'Hakkımızda';
    case GIZLILIKPOLITIKASI = 'Gizlilik Politikası';
    case MESAFELISATIS = 'Mesafeli Satış Sözleşmesi';
    case IADEPOLITIKASI = ' İade Politikası';
    case CEREZPOLITIKASI = 'Çerez Politikası';
    case TESLIMATKOSULLARI = 'Teslimat Koşulları';
    case KVKK = 'KVKK';
    case MISYON = 'Misyon';
    case VIZYON = 'Vizyon';
}
