<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ButtonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_actions')
            ->insert([
                [
                    'name' => 'lihat',
                    'description' => 'Hak untuk mengakses halaman',
                ],
                [
                    'name' => 'tambah',
                    'description' => 'Tombol aksi untuk menambah data',
                ],
                [
                    'name' => 'edit',
                    'description' => 'Tombol aksi untuk mengedit data',
                ],
                [
                    'name' => 'hapus',
                    'description' => 'Tombol aksi untuk menghapus data',
                ]
            ]);
    }
}
