<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kullanici>
 */
class AdminFactory extends Factory
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
            'super_admin' => true,
            'sifre' => Hash::make('real12345'),
        ];
    }
}
