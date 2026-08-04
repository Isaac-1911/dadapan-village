<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sellerRole = Role::where('name', 'seller')->first();

        if (!$sellerRole){
            $this->command->error('Role seller belum ada. Jalankan RoleSeeder dulu.');
            return;
        }

        User::firstOrCreate(
            ['email' => 'seller@desadadapan.id'],
            [
                'role_id' => $sellerRole->id,
                'name' => 'Seller Desa Dadapan',
                'password' => Hash::make('password123'),
                'phone' => null,
                'is_active' => true
            ]
        );
    }


}
