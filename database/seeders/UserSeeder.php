<?php

namespace Database\Seeders;

use HasRoles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Primer Usuario Admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'email_notification' => 'it@ykm.com.mx',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'Department_id' => 16,
        ])->assignRole('Admin');
        User::create([
            'name' => 'Javier Luna',
            'email' => 'javier.luna@ykm.com.mx',
            'email_notification' => 'javier.luna@ykm.com.mx',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'Department_id' => 6,
        ])->assignRole('Admin');
        User::create([
            'name' => 'Karla Jimena  Gonzalez Gonzalez',
            'email' => 'karla.gonzalez@ykm.com.mx',
            'email_notification' => 'karla.gonzalez@ykm.com.mx',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'Department_id' => 6,
        ])->assignRole('Admin');
        User::create([
            'name' => 'Ana Paulina Quintanilla Aguirre',
            'email' => 'ana.quintanilla@ykm.com.mx',
            'email_notification' => 'ana.quintanilla@ykm.com.mx',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'Department_id' => 6,
        ])->assignRole('Admin');
    }

}
