<?php

namespace Database\Seeders;

use App\Percentage;
use Illuminate\Database\Seeder;

class PercentagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Percentage::create([
            'name' => 'USER',
            'value' => 80,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        Percentage::create([
            'name' => 'INAGAVE',
            'value' => 10.5,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        Percentage::create([
            'name' => 'MERCADO_PAGO',
            'value' => 9.5,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
