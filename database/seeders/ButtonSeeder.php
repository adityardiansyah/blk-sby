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
                'code' => '<button type="button" class="btn float-end" onclick="addData([id])"><i class="bi bi-plus"></i> Tambah</button>',
                'name' => 'add',
                'position' => 'header'
            ]);

        DB::table('button')
            ->insert([
                'code' => "<button type='button' class='btn btn-sm ms-2 groupEdit' onclick='detail([id])' title='Edit'><i class='bi bi-pencil'></i></button>",
                'name' => 'edit',
                'position' => 'table'
            ]);

        DB::table('button')
            ->insert([
                'code' => "<button type='button' class='btn btn-sm ms-2' onclick='deletes([id])' title='Hapus'><i class='bi bi-trash'></i></button>",
                'name' => 'delete',
                'position' => 'table'
            ]);

        DB::table('button')
            ->insert([
                'code' => "<button type='button' class='btn btn-sm ms-2' onclick='viewDetail([id])' title='Lihat Detail'><i class='bi bi-eye'></i></button>",
                'name' => 'detail',
                'position' => 'table'
            ]);
    }
}
