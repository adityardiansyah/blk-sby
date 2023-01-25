<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateShop extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shop')->insert([
            [
                'name' => 'SOGO SURABAYA',
                'location' => 'SURABAYA',
                'address' => 'Surabaya',
                'latitude' => '',
                'longitude' => '',
                'status' => 'active'
            ],
            [
                'name' => 'SOGO SIDOARJO',
                'location' => 'SIDOARJO',
                'address' => 'Sidoarjo',
                'latitude' => '',
                'longitude' => '',
                'status' => 'active'
            ]
        ]);
    }
}
