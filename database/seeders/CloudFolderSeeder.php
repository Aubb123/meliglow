<?php

namespace Database\Seeders;

use App\Models\CloudFolder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CloudFolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = getDateTime();
        
        // ===== CloudFolder 4 - Vdocipher 1
        CloudFolder::create([
            'token' => CloudFolder::generateUniqueToken(),
            'cloud_platform_id' => 4, // ID de la plateforme cloud associée (ex: Drime, Vdocipher etc.)

            'folder_name' => 'vdocipher_folder_1', // Nom du dossier dans la plateforme cloud
            'path' => null, // Chemin du dossier dans la plateforme cloud (ex: "parent_folder/sub_folder")
            'folder_id' => null, // ID du dossier sur la plateforme cloud (ex: ID du dossier sur Drime, ID du dossier sur Vdocipher etc.)
            'metadata' => json_decode([
                'description' => 'Dossier pour les vidéos Vdocipher',
                'created_by' => 'Seeder',
            ]),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

    }
}
