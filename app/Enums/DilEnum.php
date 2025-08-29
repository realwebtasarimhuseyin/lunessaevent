<?php

namespace App\Enums;

enum DilEnum: string
{
    case TR = 'Türkçe';
    case EN = 'İngilizce';
    case FR = 'Fransızca';

    public static function fromValue(string $value): ?self
    {
        return match($value) {
            'tr' => self::TR,
            'en' => self::EN,
            'fr' => self::FR,
            default => null,
        };
    }
}
