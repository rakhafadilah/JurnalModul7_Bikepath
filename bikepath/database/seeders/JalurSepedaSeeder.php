<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JalurSepeda;
use Faker\Factory as Faker;

class JalurSepedaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $kota = ['Bandung', 'Cimahi', 'Lembang', 'Dago', 'Ciwidey', 'Soreang'];

        for ($i = 0; $i < 12; $i++) {
            JalurSepeda::create([
                'nama'              => 'Jalur ' . $faker->streetName,
                'kota'              => $faker->randomElement($kota),
                'titik_awal'        => $faker->streetName,
                'titik_akhir'       => $faker->streetName,
                'jarak_km'          => $faker->randomFloat(2, 2, 40),
                'tingkat_kesulitan' => $faker->randomElement(['Mudah', 'Sedang', 'Sulit']),
                'deskripsi'         => $faker->sentence(12),
            ]);
        }
    }
}
