<?php

namespace Database\Seeders;

use App\Models\Komunitas;
use App\Models\KomunitasPesan;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

// Data demo untuk halaman Community, Friends, dan Profile.
class SocialSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $users = User::all();

        if ($users->count() < 2) {
            return;
        }

        $levels = ['beginner', 'intermediate', 'pro'];
        $bikes  = ['Road Bike', 'Mountain Bike', 'Gravel Bike', 'Fixie', 'Hybrid'];

        // Lengkapi profil tiap rider
        foreach ($users as $u) {
            $u->update([
                'full_name'     => $u->name,
                'bike_type'     => $faker->randomElement($bikes),
                'cycling_level' => $faker->randomElement($levels),
                'address'       => $faker->city . ', Jawa Barat',
            ]);
        }

        // Anggota + beberapa pesan untuk tiap komunitas
        foreach (Komunitas::all() as $k) {
            $members = $users->random(min(5, $users->count()));
            $k->anggota()->syncWithoutDetaching($members->pluck('id')->all());

            foreach (range(1, 4) as $i) {
                KomunitasPesan::create([
                    'komunitas_id' => $k->id,
                    'user_id'      => $members->random()->id,
                    'pesan'        => $faker->sentence(8),
                ]);
            }
        }

        // Pertemanan: tiap rider mengikuti beberapa rider lain
        foreach ($users as $u) {
            $others = $users->where('id', '!=', $u->id)->random(min(3, $users->count() - 1));
            $u->following()->syncWithoutDetaching($others->pluck('id')->all());
        }
    }
}
