<?php

namespace Database\Seeders;

use App\Models\ZRC;
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

        $this->call(DepartmentSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ZRCSeeder::class);
        $this->call(ZRTSeeder::class);
    }
}
