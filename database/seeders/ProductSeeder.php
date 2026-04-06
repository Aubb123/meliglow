<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = getDateTime();

        // Récupération des IDs des catégories
        $categories = DB::table('product_categories')->pluck('id', 'name');

        // On suppose qu'un user admin existe avec l'id 1
        $userId = User::where('id', 1)->where('role_id', 1)->first()->id;

        $products = [

            // ─── Perruques naturelles ───────────────────────────────────────
            [
                'category'        => 'Perruques naturelles',
                'name'            => 'Perruque lisse naturelle noire',
                'description'     => 'Perruque en cheveux humains 100% naturels, lisse et brillante. Longueur mi-dos, idéale pour un look élégant au quotidien. Facile à coiffer et à entretenir. Parfaite pour les cheveux. Légère et confortable, parfaite pour les cheveux naturels, résistante à la chaleur et aux produits coiffants. Disponible en plusieurs longueurs et coloris.',
                'purchase_price'  => 45000,
                'sale_price'      => 75000,
                'promotional_price' => 65000,
                'stock'           => 20,
                'is_visible'      => true,
            ],
            [
                'category'        => 'Perruques naturelles',
                'name'            => 'Perruque bouclée afro naturelle',
                'description'     => 'Perruque en vrais cheveux humains avec des boucles serrées style afro. Légère et confortable, parfaite pour les cheveux naturels. Résistante à la chaleur et aux produits coiffants. Disponible en plusieurs longueurs et coloris. Idéale pour un look naturel et volumineux au quotidien. Facile à coiffer et à entretenir, convient aux cheveux crépus et bouclés.',
                'purchase_price'  => 50000,
                'sale_price'      => 85000,
                'promotional_price' => null,
                'stock'           => 15,
                'is_visible'      => true,
            ],
            [
                'category'        => 'Perruques naturelles',
                'name'            => 'Perruque ondulée longue',
                'description'     => 'Perruque en cheveux humains avec des ondulations douces. Longueur XXL pour un style glamour et sophistiqué. Légère et confortable, parfaite pour les cheveux naturels, résistante à la chaleur et aux produits coiffants. Disponible en plusieurs longueurs et coloris. Idéale pour un look naturel et volumineux au quotidien. Facile à coiffer et à entretenir, convient aux cheveux crépus et bouclés.',
                'purchase_price'  => 60000,
                'sale_price'      => 95000,
                'promotional_price' => 80000,
                'stock'           => 10,
                'is_visible'      => true,
            ],

            // ─── Perruques synthétiques ─────────────────────────────────────
            [
                'category'        => 'Perruques synthétiques',
                'name'            => 'Perruque synthétique courte pixie',
                'description'     => 'Perruque courte style pixie cut en fibre synthétique de haute qualité. Légère, facile à porter et à entretenir. Disponible en plusieurs coloris, idéale pour un look moderne et audacieux au quotidien. Résistante à la chaleur jusqu\'à 180°C, convient aux cheveux naturels, facile à coiffer et à entretenir, parfaite pour les cheveux crépus et bouclés.',
                'purchase_price'  => 8000,
                'sale_price'      => 18000,
                'promotional_price' => 15000,
                'stock'           => 35,
                'is_visible'      => true,
            ],
            [
                'category'        => 'Perruques synthétiques',
                'name'            => 'Perruque synthétique longue lisse',
                'description'     => 'Perruque longue et lisse en fibre synthétique résistante à la chaleur. Disponible en plusieurs coloris, idéale pour un look élégant et sophistiqué au quotidien. Légère, facile à porter et à entretenir, parfaite pour les cheveux naturels. Résistante à la chaleur jusqu\'à 180°C, convient aux cheveux crépus et bouclés, facile à coiffer et à entretenir.',
                'purchase_price'  => 10000,
                'sale_price'      => 22000,
                'promotional_price' => null,
                'stock'           => 40,
                'is_visible'      => true,
            ],

            // ─── Huile de ricin ─────────────────────────────────────────────
            [
                'category'        => 'Huile de ricin',
                'name'            => 'Huile de ricin pure 100ml',
                'description'     => 'Huile de ricin vierge pressée à froid. Favorise la pousse des cheveux, des cils et des sourcils. Hydrate et renforce le cheveu. Idéale pour les cheveux secs et abîmés, convient à tous les types de cheveux, notamment les cheveux crépus et bouclés. Riche en acides gras essentiels, vitamine E et minéraux pour nourrir en profondeur et stimuler la croissance capillaire.',
                'purchase_price'  => 1500,
                'sale_price'      => 3500,
                'promotional_price' => null,
                'stock'           => 100,
                'is_visible'      => true,
            ],
            [
                'category'        => 'Huile de ricin',
                'name'            => 'Huile de ricin noire jamaïcaine 250ml',
                'description'     => 'Huile de ricin noire jamaïcaine authentique, riche en oméga-9. Idéale pour stimuler la croissance capillaire et lutter contre la casse. Convient à tous les types de cheveux, notamment les cheveux crépus et bouclés. Riche en acides gras essentiels, vitamine E et minéraux pour nourrir en profondeur et stimuler la croissance capillaire.',
                'purchase_price'  => 2500,
                'sale_price'      => 5500,
                'promotional_price' => 4500,
                'stock'           => 80,
                'is_visible'      => true,
            ],

            // ─── Huile de coco ──────────────────────────────────────────────
            [
                'category'        => 'Huile de coco',
                'name'            => 'Huile de noix de coco vierge 200ml',
                'description'     => 'Huile de coco bio pressée à froid, non raffinée. Nourrit en profondeur, réduit les frisottis et protège les pointes. Idéale pour les cheveux secs et abîmés, convient à tous les types de cheveux, notamment les cheveux crépus et bouclés. Riche en acides gras essentiels, vitamine E et minéraux pour nourrir en profondeur et protéger les cheveux contre les agressions extérieures.',
                'purchase_price'  => 2000,
                'sale_price'      => 4500,
                'promotional_price' => null,
                'stock'           => 90,
                'is_visible'      => true,
            ],

            // ─── Huiles capillaires ─────────────────────────────────────────
            [
                'category'        => 'Huiles capillaires',
                'name'            => 'Huile mixte croissance capillaire 150ml',
                'description'     => 'Mélange d\'huiles essentielles et végétales (romarin, menthe, ricin) pour booster la pousse et densifier les cheveux. Idéale pour les cheveux secs et abîmés, convient à tous les types de cheveux, notamment les cheveux crépus et bouclés. Riche en acides gras essentiels, vitamine E et minéraux pour nourrir en profondeur et stimuler la croissance capillaire.',
                'purchase_price'  => 3000,
                'sale_price'      => 6500,
                'promotional_price' => 5500,
                'stock'           => 60,
                'is_visible'      => true,
            ],

            // ─── Soins & Masques ────────────────────────────────────────────
            [
                'category'        => 'Soins & Masques',
                'name'            => 'Masque capillaire au karité 500ml',
                'description'     => 'Masque nourrissant au beurre de karité et à l\'huile d\'argan. Répare les cheveux abîmés, restaure la brillance et la souplesse. Idéale pour les cheveux secs et abîmés, convient à tous les types de cheveux, notamment les cheveux crépus et bouclés. Riche en acides gras essentiels, vitamine E et minéraux pour nourrir en profondeur et restaurer la santé des cheveux.',
                'purchase_price'  => 3500,
                'sale_price'      => 7500,
                'promotional_price' => null,
                'stock'           => 50,
                'is_visible'      => true,
            ],
            [
                'category'        => 'Soins & Masques',
                'name'            => 'Après-shampoing démêlant 400ml',
                'description'     => 'Après-shampoing sans sulfates ni parabènes. Démêle facilement, hydrate et protège les cheveux naturels et colorés. Idéale pour les cheveux secs et abîmés, convient à tous les types de cheveux, notamment les cheveux crépus et bouclés. Riche en acides gras essentiels, vitamine E et minéraux pour nourrir en profondeur et protéger les cheveux contre les agressions extérieures.',
                'purchase_price'  => 2500,
                'sale_price'      => 5000,
                'promotional_price' => 4200,
                'stock'           => 70,
                'is_visible'      => true,
            ],

            // ─── Extensions capillaires ─────────────────────────────────────
            [
                'category'        => 'Extensions capillaires',
                'name'            => 'Extensions clip-in lisses noires 55cm',
                'description'     => 'Extensions en clip en cheveux mélangés, lisses et soyeuses. Longueur 55cm, 7 pièces pour un volume naturel et discret. Faciles à poser et à retirer, parfaites pour changer de look en un instant. Légères et confortables, parfaites pour les cheveux naturels, résistantes à la chaleur et aux produits coiffants, faciles à coiffer et à entretenir, parfaites pour les cheveux crépus et bouclés.',
                'purchase_price'  => 12000,
                'sale_price'      => 25000,
                'promotional_price' => null,
                'stock'           => 25,
                'is_visible'      => true,
            ],

            // ─── Shampoings ─────────────────────────────────────────────────
            [
                'category'        => 'Shampoings',
                'name'            => 'Shampoing hydratant au miel 500ml',
                'description'     => 'Shampoing doux enrichi au miel et à l\'aloe vera. Hydrate, nettoie en douceur et prévient le dessèchement des cheveux crépus et bouclés. Idéale pour les cheveux secs et abîmés, convient à tous les types de cheveux, notamment les cheveux crépus et bouclés. Riche en acides gras essentiels, vitamine E et minéraux pour nourrir en profondeur et protéger les cheveux contre les agressions extérieures.',
                'purchase_price'  => 2000,
                'sale_price'      => 4500,
                'promotional_price' => null,
                'stock'           => 85,
                'is_visible'      => true,
            ],

            // ─── Produits coiffants ─────────────────────────────────────────
            [
                'category'        => 'Produits coiffants',
                'name'            => 'Gel coiffant fixation forte 250ml',
                'description'     => 'Gel capillaire à fixation ultra forte pour des coiffures durables. Ne laisse pas de résidu blanc, convient aux cheveux crépus et texturés. Idéale pour les cheveux secs et abîmés, convient à tous les types de cheveux, notamment les cheveux crépus et bouclés. Riche en acides gras essentiels, vitamine E et minéraux pour nourrir en profondeur et protéger les cheveux contre les agressions extérieures.',
                'purchase_price'  => 1500,
                'sale_price'      => 3200,
                'promotional_price' => 2800,
                'stock'           => 120,
                'is_visible'      => true,
            ],
            [
                'category'        => 'Produits coiffants',
                'name'            => 'Sérum lissant anti-frisottis 100ml',
                'description'     => 'Sérum léger à base de silicone et d\'huile d\'argan. Lisse, protège de l\'humidité et apporte brillance et légèreté. Idéale pour les cheveux secs et abîmés, convient à tous les types de cheveux, notamment les cheveux crépus et bouclés. Riche en acides gras essentiels, vitamine E et minéraux pour nourrir en profondeur et protéger les cheveux contre les agressions extérieures.',
                'purchase_price'  => 2500,
                'sale_price'      => 5500,
                'promotional_price' => null,
                'stock'           => 65,
                'is_visible'      => true,
            ],

            // ─── Accessoires capillaires ────────────────────────────────────
            [
                'category'        => 'Accessoires capillaires',
                'name'            => 'Bonnet en satin anti-casse',
                'description'     => 'Bonnet de nuit en satin double face. Protège les cheveux pendant le sommeil, réduit la casse et préserve l\'hydratation. Idéale pour les cheveux secs et abîmés, convient à tous les types de cheveux, notamment les cheveux crépus et bouclés. Riche en acides gras essentiels, vitamine E et minéraux pour nourrir en profondeur et protéger les cheveux contre les agressions extérieures.',
                'purchase_price'  => 800,
                'sale_price'      => 2000,
                'promotional_price' => null,
                'stock'           => 150,
                'is_visible'      => true,
            ],

            // ─── Colorations ────────────────────────────────────────────────
            [
                'category'        => 'Colorations',
                'name'            => 'Coloration permanente bordeaux intense',
                'description'     => 'Coloration capillaire permanente teinte bordeaux intense. Couvre les cheveux blancs à 100%, tenue longue durée jusqu\'à 8 semaines. Idéale pour les cheveux secs et abîmés, convient à tous les types de cheveux, notamment les cheveux crépus et bouclés. Riche en acides gras essentiels, vitamine E et minéraux pour nourrir en profondeur et protéger les cheveux contre les agressions extérieures.',
                'purchase_price'  => 1800,
                'sale_price'      => 4000,
                'promotional_price' => 3500,
                'stock'           => 55,
                'is_visible'      => true,
            ],

            // ─── Produit en brouillon (exemple) ─────────────────────────────
            [
                'category'        => 'Perruques synthétiques',
                'name'            => 'Perruque synthétique colorée tie-dye',
                'description'     => 'Perruque aux couleurs tendance tie-dye (rose, violet, bleu). En cours de configuration, bientôt disponible. Légère, facile à porter et à entretenir. Disponible en plusieurs coloris, idéale pour un look moderne et audacieux au quotidien. Résistante à la chaleur jusqu\'à 180°C, convient aux cheveux naturels, facile à coiffer et à entretenir, parfaite pour les cheveux crépus et bouclés. Riche en acides gras essentiels, vitamine E et minéraux pour nourrir en profondeur et protéger les cheveux contre les agressions extérieures.',
                'purchase_price'  => 12000,
                'sale_price'      => 27000,
                'promotional_price' => null,
                'stock'           => 0,
                'is_visible'      => false, // Brouillon
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'user_id'            => $userId,
                'product_categorie_id' => $categories[$product['category']],
                'name'               => $product['name'],
                'description'        => $product['description'],
                'purchase_price'     => $product['purchase_price'],
                'sale_price'         => $product['sale_price'],
                'promotional_price'  => $product['promotional_price'],
                'stock'              => $product['stock'],
                'is_visible'         => $product['is_visible'],
                'views'              => rand(0, 500),
                'created_at'         => $now,
                'updated_at'         => $now,
            ]);
        }
    }
}