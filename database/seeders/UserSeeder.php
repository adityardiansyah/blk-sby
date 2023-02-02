<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            [
                'name' => 'Admininstrator',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'status' => 'active'
            ],
            [
                'name' => 'Adi MKT',
                'username' => 'adimkt',
                'password' => Hash::make('adimkt'),
                'status' => 'active'
            ],
            [
                'name' => 'Rahmawati',
                'username' => 'rahmawati',
                'password' => Hash::make('rahmawati'),
                'status' => 'active'
            ],
            [
                'name' => 'Syahrini',
                'username' => 'syahrini',
                'password' => Hash::make('syahrini'),
                'status' => 'active'
            ]
        ]);
    }
}
