<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'manager@one.com',
            'phone' => '07123456789',
            'role_id' => 1,
            'city' => 'Nairobi',
            'address' => '123 Main street',
            'password' => Hash::make('Admin123!'),
        ]);
    }
}
