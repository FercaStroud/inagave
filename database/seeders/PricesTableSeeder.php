<?php

namespace Database\Seeders;

use App\Price;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PricesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $limit = 10;

        for ($i = 0; $i < $limit; $i++) {
            $price = Price::create([
                'year' => (Integer)'202'.$i,
                'price' => $faker->randomFloat(2, 1, 1000),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
