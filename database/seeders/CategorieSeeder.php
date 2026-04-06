<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = getDateTime();

        // Leadership - Version alternative
        Categorie::create([
            'name' => 'Leadership',
            'token' => Str::random(10),
            'path_img' => 'others/all/categories/images/default.jpg',
            'description' => 'Parcours de leaders inspirants, techniques de management et développement des compétences de direction pour transformer les défis en opportunités.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // LifeStyle - Version alternative
        Categorie::create([
            'name' => 'LifeStyle',
            'token' => Str::random(10),
            'path_img' => 'others/all/categories/images/default.jpg',
            'description' => 'Art de vivre épanouissant, gestion du stress, habitudes de succès et témoignages sur l\'équilibre entre ambitions professionnelles et bien-être personnel.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Entrepreneuriat
        Categorie::create([
            'name' => 'Entrepreneuriat',
            'token' => Str::random(10),
            'path_img' => 'others/all/categories/images/default.jpg',
            'description' => 'Histoires de création d\'entreprises, conseils pratiques pour entrepreneurs et stratégies pour surmonter les échecs et rebondir.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Résilience
        Categorie::create([
            'name' => 'Résilience',
            'token' => Str::random(10),
            'path_img' => 'others/all/categories/images/default.jpg',
            'description' => 'Témoignages inspirants de dépassement de soi, techniques de gestion des épreuves et méthodes pour transformer les obstacles en tremplins.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Parcours
        Categorie::create([
            'name' => 'Parcours',
            'token' => Str::random(10),
            'path_img' => 'others/all/categories/images/default.jpg',
            'description' => 'Histoires vraies de personnalités qui ont marqué leur époque, leurs échecs, leurs succès et les leçons à en tirer.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

    }
}
