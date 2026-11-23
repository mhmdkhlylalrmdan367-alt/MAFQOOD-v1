<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $adminRole = Role::where('name', 'admin')->first();
        User::updateOrCreate(
            ['email' => 'admin@mafqood.com'],
            [
                'name' => 'مستخدم تجريبي',
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
