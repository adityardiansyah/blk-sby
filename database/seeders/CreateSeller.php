<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateSeller extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sellers')->insert([
            [
                'shop_id' => '1',
                'user_id' => '3',
                'no_seller' => 'A001',
                'name' => 'Rahmawati Suep',
                'phone' => '08454243423',
                'email' => 'rahmawati@gmail.com',
                'photo' => '',
                'status' => 'active',
            ],
            [
                'shop_id' => '2',
                'user_id' => '4',
                'no_seller' => 'A001',
                'name' => 'Syahrini kesini',
                'phone' => '08454243423',
                'email' => 'syahrini@gmail.com',
                'photo' => '',
                'status' => 'active',
            ]
        ]);
    }
}
