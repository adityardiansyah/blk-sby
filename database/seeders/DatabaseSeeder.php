<?php

namespace Database\Seeders;

use App\Models\UserGroup;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(CreateShop::class);
        $this->call(CreateSeller::class);
        $this->call(SectionSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(UserGroupSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(ButtonSeeder::class);
        // \App\Models\User::factory(10)->create();
    }
}
