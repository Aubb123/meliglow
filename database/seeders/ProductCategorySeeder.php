<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = getDateTime();

        $categories = [
            [
                'name'        => 'Perruques',
                'description' => 'Perruques naturelles et synthétiques pour tous les styles et toutes les occasions.',
            ],
            [
                'name'        => 'Perruques naturelles',
                'description' => 'Perruques fabriquées à partir de vrais cheveux humains pour un rendu ultra-naturel.',
            ],
            [
                'name'        => 'Perruques synthétiques',
                'description' => 'Perruques en fibre synthétique, légères et faciles à entretenir.',
            ],
            [
                'name'        => 'Huiles capillaires',
                'description' => 'Huiles nourrissantes pour hydrater, fortifier et faire briller les cheveux.',
            ],
            [
                'name'        => 'Huile de ricin',
                'description' => 'Huile de ricin pure pour stimuler la pousse des cheveux et des cils.',
            ],
            [
                'name'        => 'Huile de coco',
                'description' => 'Huile de noix de coco pour nourrir en profondeur et protéger les cheveux.',
            ],
            [
                'name'        => 'Soins & Masques',
                'description' => 'Masques capillaires, après-shampoings et soins intensifs pour cheveux abîmés.',
            ],
            [
                'name'        => 'Extensions capillaires',
                'description' => 'Extensions en clip, tissage ou kératine pour ajouter volume et longueur.',
            ],
            [
                'name'        => 'Shampoings',
                'description' => 'Shampoings adaptés aux cheveux naturels, colorés, secs ou gras.',
            ],
            [
                'name'        => 'Accessoires capillaires',
                'description' => 'Bonnets, filets, élastiques, pinces et tout ce qu\'il faut pour coiffer et protéger vos cheveux.',
            ],
            [
                'name'        => 'Colorations',
                'description' => 'Colorations et teintures pour cheveux naturels ou perruques, du noir intense aux teintes vibrantes.',
            ],
            [
                'name'        => 'Produits coiffants',
                'description' => 'Gels, mousses, sérums et sprays pour fixer, lisser ou boucler vos cheveux.',
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::create([
                'name'        => $category['name'],
                'description' => $category['description'],
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }
    }
}
