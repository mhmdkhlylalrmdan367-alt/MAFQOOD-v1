<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CountryRegionSeeder::class,
            CategorySeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
        ]);
    }
}
