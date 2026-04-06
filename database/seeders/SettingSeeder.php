<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = getDateTime();
        
        // Paramètre : nom du site web
        $token = Str::random(10);
        while(Setting::where('token', $token)->exists()) {
            $token = Str::random(10);
        }
        Setting::create([
            'token' => $token,
            'key' => 'site_name',
            'value' => 'Aunalearn App',
            'type' => 'string',
            'description' => 'Nom du site web',
            'is_public' => true,
            'created_at' => now()->subHours(2),
            'updated_at' => now()->subHours(2),
        ]);
        // Paramètre : nom du site web

        // Paramètre : mode maintenance
        $token = Str::random(10);
        while(Setting::where('token', $token)->exists()) {
            $token = Str::random(10);
        }
        Setting::create([
            'token' => $token,
            'key' => 'maintenance_mode',
            'value' => 'false',
            'type' => 'boolean',
            'description' => 'Mode maintenance activé ou désactivé',
            'is_public' => false,
            'created_at' => now()->subHours(2),
            'updated_at' => now()->subHours(2),
        ]);
        // Paramètre : mode maintenance

        // $token = Str::random(10);
        // while(Setting::where('token', $token)->exists()) {
        //     $token = Str::random(10);
        // }
        // Setting::create([
        //     'token' => $token,
        //     'key' => 'aunadi/aunalearn',
        //     'value' => 30, // Pourcentage de 30%
        //     'type' => 'string',
        //     'description' => '',
        //     'is_public' => false,
        //     'created_at' => now()->subHours(2),
        //     'updated_at' => now()->subHours(2),
        // ]);

    }
}
