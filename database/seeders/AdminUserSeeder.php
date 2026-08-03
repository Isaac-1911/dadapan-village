<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        if (!$adminRole) {
            $this->command->error('Role admin belum ada. Jalankan RoleSeeder dulu.');
            return;
        }

        User::firstOrCreate(
            ['email' => 'admin@desadadapan.id'],
            [
                'role_id' => $adminRole->id,
                'name' => 'Admin Desa Dadapan',
                'password' => Hash::make('password123'), // ganti sebelum production!
                'phone' => null,
                'is_active' => true,
            ]
        );
    }
}
