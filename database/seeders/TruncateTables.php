<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TruncateTables extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Désactiver les contraintes de clés étrangères
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::disableForeignKeyConstraints(); 

        $tables = [
            'account_reset_tokens',
            'blogs',
            'cache',
            'cache_locks',
            'categories',
            'cloud_files',
            'cloud_folders',
            'cloud_platforms',
            'comments',
            'contacts',
            'continents',
            'countries',
            'failed_jobs',
            'faqs',
            'jobs',
            'job_batches',
            // 'migrations',
            'notifications',
            'password_reset_tokens',
            'product_categories',
            'products',
            'roles',
            'sessions',
            'settings',
            'subscribes',
            'taggables',
            'tags',
            'users',
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }


        // Activer les contraintes de clés étrangères
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Schema::enableForeignKeyConstraints();
    }
}
