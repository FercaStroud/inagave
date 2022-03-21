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
            $price = Price::create([
                'weight' => (float)0.416,
                'price' => (float)27.5,
                'default' => 0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
    }
}
