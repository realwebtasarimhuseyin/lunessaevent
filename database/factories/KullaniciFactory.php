<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kullanici>
 */
class KullaniciFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'isim' => "İnfo",
            'soyisim' => "Real",
            'eposta' => "info@realwebtasarim.com",
            'telefon' => "0555 555 5555",
            'sifre' => Hash::make('busra12345'),
        ];
    }
}
