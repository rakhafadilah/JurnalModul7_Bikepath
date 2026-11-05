<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Komunitas;
use Faker\Factory as Faker;

class KomunitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 8; $i++) {
            Komunitas::create([
                'nama'           => 'Gowes ' . $faker->unique()->city,
                'kota'           => $faker->city,
                'deskripsi'      => $faker->sentence(10),
                'jumlah_anggota' => $faker->numberBetween(10, 500),
            ]);
        }
    }
}
