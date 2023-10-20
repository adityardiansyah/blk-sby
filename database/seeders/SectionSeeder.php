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
                'name_section' => 'Users',
                'order' => 4,
                'icons' => 'people',
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
