<?php

namespace Database\Seeders;

use App\Models\Continent;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContinentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = getDateTime();

        $continents = [
            [
                'name' => 'Afrique',
                'code' => 'AF',
                'token' => Str::random(10),
                'description' => 'Le continent africain est le deuxième continent le plus peuplé et le deuxième plus grand en superficie.',
                'path_img' => 'others/all/continents/images/default.png',
                'population' => 1400000000, // ~1.4 milliards
                'area' => 30370000.00, // 30,37 millions km²
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Asie',
                'code' => 'AS',
                'token' => Str::random(10),
                'description' => 'L\'Asie est le plus grand et le plus peuplé des continents.',
                'path_img' => 'others/all/continents/images/default.png',
                'population' => 4700000000, // ~4.7 milliards
                'area' => 44579000.00, // 44,58 millions km²
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Europe',
                'code' => 'EU',
                'token' => Str::random(10),
                'description' => 'L\'Europe est un continent riche en histoire et en diversité culturelle.',
                'path_img' => 'others/all/continents/images/default.png',
                'population' => 750000000, // ~750 millions
                'area' => 10180000.00, // 10,18 millions km²
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Amérique du Nord',
                'code' => 'NA',
                'token' => Str::random(10),
                'description' => 'L\'Amérique du Nord comprend le Canada, les États-Unis, le Mexique et l\'Amérique centrale.',
                'path_img' => 'others/all/continents/images/default.png',
                'population' => 600000000, // ~600 millions
                'area' => 24709000.00, // 24,71 millions km²
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Amérique du Sud',
                'code' => 'SA',
                'token' => Str::random(10),
                'description' => 'L\'Amérique du Sud abrite la forêt amazonienne, la plus grande forêt tropicale du monde.',
                'path_img' => 'others/all/continents/images/default.png',
                'population' => 430000000, // ~430 millions
                'area' => 17840000.00, // 17,84 millions km²
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Océanie',
                'code' => 'OC',
                'token' => Str::random(10),
                'description' => 'L\'Océanie comprend l\'Australie, la Nouvelle-Zélande et les îles du Pacifique.',
                'path_img' => 'others/all/continents/images/default.png',
                'population' => 45000000, // ~45 millions
                'area' => 8525989.00, // 8,53 millions km²
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Antarctique',
                'code' => 'AN',
                'token' => Str::random(10),
                'description' => 'L\'Antarctique est le continent le plus froid, le plus sec et le plus venteux de la Terre.',
                'path_img' => 'others/all/continents/images/default.png',
                'population' => 0, // Aucune population permanente
                'area' => 14200000.00, // 14,2 millions km²
                'sort_order' => 7,
                'is_active' => false, // Peut-être inactif car pas habité
            ],
        ];

        foreach ($continents as $continent) {
            Continent::create([
                'name' => $continent['name'],
                'code' => $continent['code'],
                'token' => Str::random(10),
                'description' => $continent['description'],
                'path_img' => $continent['path_img'],
                'population' => $continent['population'],
                'area' => $continent['area'],
                'sort_order' => $continent['sort_order'],
                'is_active' => $continent['is_active'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
