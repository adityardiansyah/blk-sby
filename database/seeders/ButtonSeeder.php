<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ButtonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('button')
            ->insert([
                'code' => '<button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modal_add"><i class="bi bi-plus"></i> Tambah</button>',
                'name' => 'tambah',
                'position' => 'header'
            ]);

        DB::table('button')
            ->insert([
                'code' => "<button type='button' class='btn btn-warning btn-sm' onclick='detail([id])'>Edit</button>",
                'name' => 'edit',
                'position' => 'table'
            ]);

        DB::table('button')
            ->insert([
                'code' => '',
                'name' => 'delete',
                'position' => 'table'
            ]);
    }
}
