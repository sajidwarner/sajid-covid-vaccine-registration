<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use App\Models\VaccineCenter;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VaccineCentersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            VaccineCenter::create([
                'name' => 'Center ' . $faker->city,
                'daily_limit' => $faker->numberBetween(10, 50),
            ]);
        }
    }
}
