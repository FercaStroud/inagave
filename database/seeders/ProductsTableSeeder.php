<?php

namespace Database\Seeders;

use App\ProductImage;
use Faker\Factory;
use Illuminate\Database\Seeder;
use App\Product;

class ProductsTableSeeder extends Seeder
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
        $imageLimit = 3;

        for ($i = 0; $i < $limit; $i++) {
            $product = Product::create([
                'estate' => $faker->text(20),
                'size' => $faker->numberBetween(1, 100),
                'quantity' => $faker->numberBetween(100, 1000),
                'price' => $faker->randomFloat(2, 1, 50),
                'age' => $faker->numberBetween(1, 7),
                'municipality' => $faker->text(18),
                'location_url' => $faker->url(),
                'location' => '24.170300138817815, -110.29608660056246',
                'description' => $faker->sentence(20, true),
                'planted_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'user_id' => 1,
            ]);

            for ($j = 0; $j < $imageLimit; $j++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'name' => $faker->text(75),
                    'src' => '3gm1WRjIM7JIt1wpH7NbAthQkBN7ARqUECnEqXlFBxv95bbVCSOI2nBIC01sjMhY1lPq.jpg',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
            }
        }
    }
}
