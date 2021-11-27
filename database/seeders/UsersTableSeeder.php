<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'lastname' => 'Lastname',
            'second_lastname' => 'Secondlastname',
            'address' => 'Calle Falsa, #123',
            'country' => 'MX',
            'state' => 'Coahuila',
            'city' => 'Torreón',
            'municipality' => 'Torreón',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin'),
            'type_id' => 1,
        ]);

        User::create([
            'name' => 'Normal',
            'lastname' => 'Lastname',
            'second_lastname' => 'Secondlastname',
            'address' => 'Calle Falsa, #123',
            'country' => 'MX',
            'state' => 'Coahuila',
            'city' => 'Torreón',
            'municipality' => 'Torreón',
            'email' => 'normal@example.com',
            'password' => bcrypt('normal'),
            'type_id' => 2,
        ]);

        User::create([
            'name' => 'Fernando',
            'lastname' => 'Cárdenas',
            'second_lastname' => 'González',
            'address' => 'Calle Falsa, #123',
            'country' => 'MX',
            'state' => 'Coahuila',
            'city' => 'Torreón',
            'municipality' => 'Torreón',
            'email' => 'hola@ferca.dev',
            'password' => bcrypt('normal'),
            'type_id' => 2,
        ]);

    }
}
