<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Début Seeders
        $this->call([

            TruncateTables::class,

            SettingSeeder::class,
            CloudPlatformSeeder::class,
            RoleSeeder::class,
            ContinentSeeder::class,
            CountrySeeder::class,
            
            UserSeeder::class,

            ProductCategorySeeder::class,
            ProductSeeder::class,
            
        ]);
        // Fin Seeders
    }
}
