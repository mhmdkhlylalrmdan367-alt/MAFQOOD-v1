<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Abilities catalog (code => label)
    |--------------------------------------------------------------------------
    */
    'abilities' => [
        'roles.view' => 'View Roles',
        'roles.create' => 'Create Roles',
        'roles.update' => 'Update Roles',
        'roles.delete' => 'Delete Roles',

        //categories
        'categories.view' => 'View Categories',
        'categories.create' => 'Create Categories',
        'categories.update' => 'Update Categories',
        'categories.delete' => 'Delete Categories',
        //admins
        'admins.view' => 'View Admins',
        'admins.create' => 'Create Admins',
        'admins.update' => 'Update Admins',
        'admins.delete' => 'Delete Admins',
        //items
        'items.view' => 'View Items',
        'items.update' => 'Update Items',
        'items.delete' => 'Delete Items',
        //users
        'users.view' => 'View Users',
        'users.update' => 'Update Users',
        'users.delete' => 'Delete Users',
        //reports
        'reports.view' => 'View Reports',
        'reports.update' => 'Update Reports',
        //sitereports
        'sitereports.view' => 'View Site Reports',
        'sitereports.export' => 'Export Site Reports',
    ],

    /*
    |--------------------------------------------------------------------------
    | Super-admin column on the user model (null = disabled)
    |--------------------------------------------------------------------------
    */
    'super_admin_column' => 'super_admin',

    'models' => [
        'role' => Melbedran\RolePermession\Models\Role::class,
        'role_ability' => Melbedran\RolePermession\Models\RoleAbility::class,
    ],

    'tables' => [
        'roles' => 'roles',
        'role_abilities' => 'role_abilities',
        'role_user' => 'role_user',
    ],

    'morph' => 'authorizable',

    'register_gates' => true,

    /*
    |--------------------------------------------------------------------------
    | Load package migrations automatically
    |--------------------------------------------------------------------------
    */
    'load_migrations' => true,

    'blade' => [
        'enabled' => true,
        'can' => 'canAbility',
        'cannot' => 'cannotAbility',
        'canAny' => 'canAnyAbility',
        'canAll' => 'canAllAbility',
    ],

    /*
    |--------------------------------------------------------------------------
    | Built-in admin UI (Blade)
    |--------------------------------------------------------------------------
    */
    'ui' => [
        'enabled' => true,
        'prefix' => 'admin/roles',
        'middleware' => ['web', 'auth:admin'],
        'route_name_prefix' => 'role-permession.',
    ],

];
