<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'display_name_ar' => 'مدير', 'display_name_en' => 'Admin'],
            ['name' => 'moderator', 'display_name_ar' => 'مشرف', 'display_name_en' => 'Moderator'],
            ['name' => 'user', 'display_name_ar' => 'مستخدم', 'display_name_en' => 'User'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role['name']], $role);
        }

        $permissions = [
            ['name' => 'manage_users', 'display_name_ar' => 'إدارة المستخدمين', 'display_name_en' => 'Manage Users'],
            ['name' => 'manage_items', 'display_name_ar' => 'إدارة الإعلانات', 'display_name_en' => 'Manage Items'],
            ['name' => 'manage_categories', 'display_name_ar' => 'إدارة التصنيفات', 'display_name_en' => 'Manage Categories'],
            ['name' => 'manage_reports', 'display_name_ar' => 'إدارة البلاغات', 'display_name_en' => 'Manage Reports'],
            ['name' => 'manage_settings', 'display_name_ar' => 'إدارة الإعدادات', 'display_name_en' => 'Manage Settings'],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(['name' => $perm['name']], $perm);
        }

        $admin = Role::where('name', 'admin')->first();
        $moderator = Role::where('name', 'moderator')->first();

        $admin->permissions()->sync(Permission::pluck('id'));
        $moderator->permissions()->sync(
            Permission::whereIn('name', ['manage_items', 'manage_reports'])->pluck('id')
        );
    }
}