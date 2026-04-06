<?php

namespace Database\Seeders;

use App\Models\CloudPlatform;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CloudPlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = getDateTime();

        // ===== CloudPlat 1 - Drime aunalearn@gmail.com =====
        CloudPlatform::create([
            // 'token' => CloudPlatform::generateUniqueToken(),
            'token' => '73ef648374e052f2f1a2',

            'label' => 'Drime 1 fiacrearistide53@gmail.com', // Libellé de la plateforme (ex: 'Drime', 'Google Drive', 'Mega', 'Vdocipher' etc.)
            
            // Nom de la plateforme de stockage cloud TOUJOURS en minuscule et sans espaces (ex: 'drime', 'google_drive', 'mega', 'vdocipher' etc.)
            'name' => 'drime', // Nom de la plateforme de stockage cloud TOUJOURS en minuscule et sans espaces (ex: 'drime', 'google_drive', 'mega', 'vdocipher' etc.)
            // Nom de la plateforme de stockage cloud TOUJOURS en minuscule et sans espaces (ex: 'drime', 'google_drive', 'mega', 'vdocipher' etc.)

            'api_endpoint' => env('DRIME_API_URL', null), // URL de l'API de Drime
            'api_key' => env('DRIME_API_TOKEN', null), // Clé API pour accéder à Drime
            'api_secret' => env('DRIME_API_SECRET', null), // Secret API pour accéder à Drime
            'description' => 'Drime est une plateforme de stockage cloud spécialisée dans les fichiers multimédias, offrant des fonctionnalités avancées pour la gestion et la diffusion de vidéos et d\'images.',
            'status' => 'active',
            'metadata' => [
                'storage_limit' => '20GB',
                'features' => ['video_transcoding', 'image_optimization', 'secure_access'],
            ],
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        
        // // ===== CloudPlat 2 - Drime aunadev2@gmail.com =====
        // CloudPlatform::create([
        //     // 'token' => CloudPlatform::generateUniqueToken(),
        //     'token' => 'g7874pplep7fxcb2qw41',

        //     'label' => 'Drime 2 aunadev2@gmail.com', // Libellé de la plateforme (ex: 'Drime', 'Google Drive', 'Mega', 'Vdocipher' etc.)
            
        //     // Nom de la plateforme de stockage cloud TOUJOURS en minuscule et sans espaces (ex: 'drime', 'google_drive', 'mega', 'vdocipher' etc.)
        //     'name' => 'drime', // Nom de la plateforme de stockage cloud TOUJOURS en minuscule et sans espaces (ex: 'drime', 'google_drive', 'mega', 'vdocipher' etc.)
        //     // Nom de la plateforme de stockage cloud TOUJOURS en minuscule et sans espaces (ex: 'drime', 'google_drive', 'mega', 'vdocipher' etc.)

        //     'api_endpoint' => env('DRIME_API_URL_2', null), // URL de l'API de Drime
        //     'api_key' => env('DRIME_API_TOKEN_2', null), // Clé API pour accéder à Drime
        //     'api_secret' => env('DRIME_API_SECRET_2', null), // Secret API pour accéder à Drime
        //     'description' => 'Drime est une plateforme de stockage cloud spécialisée dans les fichiers multimédias, offrant des fonctionnalités avancées pour la gestion et la diffusion de vidéos et d\'images.',
        //     'status' => 'active',
        //     'metadata' => [
        //         'storage_limit' => '20GB',
        //         'features' => ['video_transcoding', 'image_optimization', 'secure_access'],
        //     ],
        //     'created_at' => $now,
        //     'updated_at' => $now,
        // ]);

        // // ===== CloudPlat 3 - Mega =====
        // CloudPlatform::create([
        //     // 'token' => CloudPlatform::generateUniqueToken(),
        //     'token' => 'f5ec50932cb3366063cb',

        //     'label' => 'Mega 1 fiacrearistide53@gmail.com', // Libellé de la plateforme (ex: 'Drime', 'Google Drive', 'Mega', 'Vdocipher' etc.)

        //     // Nom de la plateforme de stockage cloud TOUJOURS en minuscule et sans espaces (ex: 'drime', 'google_drive', 'mega', 'vdocipher' etc.)
        //     'name' => 'mega', // Nom de la plateforme de stockage cloud TOUJOURS en minuscule et sans espaces (ex: 'drime', 'google_drive', 'mega', 'vdocipher' etc.)
        //     // Nom de la plateforme de stockage cloud TOUJOURS en minuscule et sans espaces (ex: 'drime', 'google_drive', 'mega', 'vdocipher' etc.)

        //     'api_endpoint' => env('MEGA_API_URL', null), // URL de l'API de Mega
        //     'api_key' => env('MEGA_API_TOKEN', null), // Clé API pour accéder à Mega
        //     'api_secret' => env('MEGA_API_SECRET', null), // Secret API pour accéder à Mega
        //     'description' => 'Mega est une plateforme de stockage cloud offrant un espace de stockage généreux et une sécurité renforcée grâce à un chiffrement de bout en bout, idéale pour les utilisateurs à la recherche d\'une solution de stockage sécurisée.',
        //     'status' => 'inactive',
        //     'metadata' => [
        //         'storage_limit' => '20GB',
        //         'features' => ['end_to_end_encryption', 'large_file_support', 'collaboration_tools'],
        //     ],
        //     'created_at' => $now,
        //     'updated_at' => $now,
        // ]);

        // // ===== CloudPlat 4 - Vdocipher =====
        // CloudPlatform::create([
        //     // 'token' => CloudPlatform::generateUniqueToken(),
        //     'token' => '125e3b0efbdd87ef0ba2',

        //     'label' => 'Vdocipher 1 tesben@gmail.com', // Libellé de la plateforme (ex: 'Drime', 'Google Drive', 'Mega', 'Vdocipher' etc.)
            
        //     // Nom de la plateforme de stockage cloud TOUJOURS en minuscule et sans espaces (ex: 'drime', 'google_drive', 'mega', 'vdocipher' etc.)
        //     'name' => 'vdocipher', // Nom de la plateforme de stockage cloud TOUJOURS en minuscule et sans espaces (ex: 'drime', 'google_drive', 'mega', 'vdocipher' etc.)
        //     // Nom de la plateforme de stockage cloud TOUJOURS en minuscule et sans espaces (ex: 'drime', 'google_drive', 'mega', 'vdocipher' etc.)

        //     'api_endpoint' => env('VDOCIPHER_API_URL', null), // URL de l'API de Vdocipher
        //     'api_key' => env('VDOCIPHER_API_TOKEN', null), // Clé API pour accéder à Vdocipher
        //     'api_secret' => env('VDOCIPHER_API_SECRET', null), // Secret API pour accéder à Vdocipher
        //     'description' => 'Vdocipher est une plateforme de streaming vidéo sécurisée, offrant des fonctionnalités avancées de protection du contenu et de diffusion en continu, idéale pour les entreprises et les créateurs de contenu qui souhaitent protéger leurs vidéos contre le piratage.',
        //     'status' => 'active',
        //     'metadata' => [
        //         'storage_limit' => '5GB',
        //         'features' => ['secure_video_streaming', 'content_protection', 'analytics'],
        //     ],
        //     'created_at' => $now,
        //     'updated_at' => $now,
        // ]);

    }
}
