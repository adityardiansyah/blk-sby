<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 1,
                'name_menu' => 'SKU',
                'url' => '/sku',
                'icons' => '',
                'order' => 1,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 1,
                'name_menu' => 'Warna',
                'url' => '/color',
                'icons' => '',
                'order' => 2,
                'status' => 'active',
            ]);
        
        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 1,
                'name_menu' => 'Ukuran',
                'url' => '/size',
                'icons' => '',
                'order' => 3,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 2,
                'name_menu' => 'Toko',
                'url' => '/shop',
                'icons' => '',
                'order' => 1,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 2,
                'name_menu' => 'Seller',
                'url' => '/seller',
                'icons' => '',
                'order' => 2,
                'status' => 'active',
            ]);
        
        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 3,
                'name_menu' => 'In',
                'url' => '/adjusment/in',
                'icons' => '',
                'order' => 1,
                'status' => 'active',
            ]);
        
        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 3,
                'name_menu' => 'Out',
                'url' => '/adjusment/out',
                'icons' => '',
                'order' => 2,
                'status' => 'active',
            ]);
        
        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 4,
                'name_menu' => 'User',
                'url' => '/users',
                'icons' => '',
                'order' => 1,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 4,
                'name_menu' => 'Create Section',
                'url' => '/create-section',
                'icons' => '',
                'order' => 3,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 5,
                'name_menu' => 'Daftar Produk',
                'url' => '/conversion',
                'icons' => '',
                'order' => 1,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 5,
                'name_menu' => 'Penerimaan Barang',
                'url' => '/goodsreceive',
                'icons' => '',
                'order' => 2,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 5,
                'name_menu' => 'Retur Gudang',
                'url' => '/returnwarehouse',
                'icons' => '',
                'order' => 3,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 6,
                'name_menu' => 'Penjualan',
                'url' => '/sales',
                'icons' => '',
                'order' => 1,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 6,
                'name_menu' => 'Retur Penjualan',
                'url' => '/returnsales',
                'icons' => '',
                'order' => 2,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 6,
                'name_menu' => 'Stock Fisik',
                'url' => '/stockopname',
                'icons' => '',
                'order' => 3,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 7,
                'name_menu' => 'Laporan',
                'url' => '/laporan',
                'icons' => '',
                'order' => 1,
                'status' => 'active',
            ]);
        
        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 8,
                'name_menu' => 'Group',
                'url' => '/group',
                'icons' => '',
                'order' => 2,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 8,
                'name_menu' => 'Aksi',
                'url' => '/button',
                'icons' => '',
                'order' => 2,
                'status' => 'active',
            ]);
    }
}
