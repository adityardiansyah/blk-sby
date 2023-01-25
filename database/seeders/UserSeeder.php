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
                'password' => Hash::make('admin123')
            ],
            [
                'name' => 'Adi MKT',
                'username' => 'adimkt',
                'password' => Hash::make('adimkt')
            ],
            [
                'name' => 'Rahmawati',
                'username' => 'rahmawati',
                'password' => Hash::make('rahmawati')
            ],
            [
                'name' => 'Syahrini',
                'username' => 'syahrini',
                'password' => Hash::make('syahrini')
            ]
        ]);
    }
}
