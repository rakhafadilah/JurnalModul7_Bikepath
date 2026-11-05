<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name'     => $faker->name,
                'email'    => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
            ]);
        }

        User::updateOrCreate(
            ['email' => 'admin@bikepath.test'],
            ['name' => 'Admin BikePath', 'password' => Hash::make('admin123')]
        );
    }
}