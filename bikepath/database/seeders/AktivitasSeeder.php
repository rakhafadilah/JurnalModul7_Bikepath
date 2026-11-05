<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Aktivitas;
use App\Models\JalurSepeda;
use App\Models\User;
use Faker\Factory as Faker;

class AktivitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $userIds  = User::pluck('id')->all();
        $jalurIds = JalurSepeda::pluck('id')->all();

        for ($i = 0; $i < 25; $i++) {
            Aktivitas::create([
                'user_id'         => $faker->randomElement($userIds),
                'jalur_sepeda_id' => $faker->randomElement($jalurIds),
                'tanggal'         => $faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
                'durasi_menit'    => $faker->numberBetween(20, 180),
                'jarak_km'        => $faker->randomFloat(2, 3, 60),
                'kecepatan_rata'  => $faker->randomFloat(2, 10, 30),
                'catatan'         => $faker->sentence(8),
            ]);
        }
    }
}
