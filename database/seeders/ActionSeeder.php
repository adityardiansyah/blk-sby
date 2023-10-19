<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('actions')
            ->insert([
                'menu_id' => 17,
                'master_action_id' => 1
            ]);

        DB::table('actions')
            ->insert([
                'menu_id' => 18,
                'master_action_id' => 1
            ]);

        DB::table('action_groups')
            ->insert([
                'action_id' => 1,
                'group_id' => 1
            ]);

        DB::table('action_groups')
            ->insert([
                'action_id' => 2,
                'group_id' => 1
            ]);
    }
}
