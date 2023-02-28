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
        // $this->call(GroupSeeder::class);
        // $this->call(UserGroup::class);
        // \App\Models\User::factory(10)->create();
    }
}
