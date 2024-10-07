<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin = Role::create(['name' => 'Admin']);
        $user = Role::create(['name' => 'AdminBYR']);

        //Permission::create(['name' => 'Configuration.Category.index'])->syncRoles([$admin]);
        
        //Permission::create(['name' => 'Admin.AVM.index'])->syncRoles(['Admin']);
        //Permission::create(['name' => 'Admin.IPB.index'])->syncRoles(['Admin']);
        //Permission::create(['name' => 'Admin.YH100.index'])->syncRoles(['Admin']);

        Permission::create(['name' => 'Home.Menu.index'])->syncRoles(['Admin']);


    }
}
