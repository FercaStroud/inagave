<?php

namespace Database\Seeders;

use App\Setting;
use Faker\Factory;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        Setting::create([
            'maintenance' => $faker->randomFloat(2, 1, 50),
        ]);
    }
}
