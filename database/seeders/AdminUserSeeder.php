<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        User::updateOrCreate(
            ['email' => 'admin@mafqood.com'],
            [
                'name' => 'مدير النظام',
                'password' => Hash::make('admin1234'),
                'phone' => '+963999999999',
                'role_id' => $adminRole->id,
                'is_active' => true,
                'email_verified_at' => now(),
                'locale' => 'ar',
            ]
        );
    }
}