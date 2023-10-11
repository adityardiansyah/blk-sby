<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Master',
                'order' => 2,
                'icons' => 'diagram-3',
                'status' => 'active',
            ]);
            
        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Toko',
                'order' => 1,
                'icons' => 'shop',
                'status' => 'active',
            ]);

        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Adjusment',
                'order' => 3,
                'icons' => 'diagram-3',
                'status' => 'active',
            ]);

        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Users',
                'order' => 4,
                'icons' => 'people',
                'status' => 'active',
            ]);

        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Barang',
                'order' => 5,
                'icons' => 'box-seam',
                'status' => 'active',
            ]);

        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Penjualan',
                'order' => 6,
                'icons' => 'cart-check',
                'status' => 'active',
            ]);

        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Laporan',
                'order' => 7,
                'icons' => 'file-earmark-bar-graph',
                'status' => 'active',
            ]);

        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Settings',
                'order' => 8,
                'icons' => 'file-earmark-bar-graph',
                'status' => 'active',
            ]);
    }
}
