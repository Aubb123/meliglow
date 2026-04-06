<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $now = getDateTime();

        // ===== BLOG 1 - LEADERSHIP =====
        Blog::create([
            'title' => 'De l\'échec à la réussite : Comment transformer ses défaites en victoires',
            'token' => Str::random(10),
            'content' => 'L\'échec fait partie intégrante du parcours de tout leader authentique. Loin d\'être une fatalité, il peut devenir le tremplin vers des succès extraordinaires.
                
                Prenez l\'exemple de Sara Traoré, aujourd\'hui PDG d\'une entreprise technologique prospère en Côte d\'Ivoire. À 25 ans, sa première startup a fait faillite, la laissant endettée et découragée. Mais au lieu de baisser les bras, elle a analysé minutieusement ses erreurs : mauvaise étude de marché, équipe mal constituée, gestion financière défaillante.
                
                Cette introspection douloureuse mais nécessaire lui a permis de rebondir avec une approche plus mature. Elle a investi dans sa formation, s\'est entourée de mentors expérimentés et a testé son nouveau concept sur un marché plus restreint avant de se lancer.
                
                Trois clés pour transformer l\'échec en force : d\'abord, accepter la responsabilité sans s\'accabler. Ensuite, identifier les leçons concrètes à retenir. Enfin, utiliser cette expérience comme une référence pour éviter les mêmes pièges.
                
                L\'échec n\'est pas le contraire du succès, c\'est son préalable. Chaque revers nous apprend quelque chose d\'essentiel sur nous-mêmes et sur notre environnement. Les plus grands leaders africains ont tous cette particularité : ils transforment leurs cicatrices en étoiles.',
            
            'path_img' => 'others/all/blogs/images/01.png',
            'views' => 247,
            'time_read' => 7,
            'is_visible' => true,
            'categorie_id' => 1, // Leadership
            'user_id' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ===== BLOG 2 - ENTREPRENEURIAT =====
        Blog::create([
            'title' => 'Entrepreneuriat en Afrique : Pourquoi commencer petit peut mener grand',
            'token' => Str::random(10),
            'content' => 'Contrairement aux idées reçues, les plus beaux succès entrepreneuriaux africains ont souvent commencé très modestement. L\'histoire de Kemi Adeyemi en est l\'illustration parfaite.
                
                Tout a commencé dans sa cuisine de Lagos avec 50 000 nairas (environ 120$). Kemi préparait des épices traditionnelles qu\'elle vendait sur le marché local. Son secret ? Une recette familiale transmise par sa grand-mère et une obsession pour la qualité.
                
                Au lieu de rêver grand immédiatement, elle a perfectionné son processus, fidélisé sa clientèle de proximité et réinvesti chaque bénéfice. Petit à petit, elle a automatisé sa production, développé de nouveaux produits et étendu sa distribution.
                
                Aujourd\'hui, ses épices "Mama\'s Secret" sont vendues dans 12 pays africains et elle emploie plus de 200 personnes. Son chiffre d\'affaires dépasse les 5 millions de dollars.
                
                La leçon ? Commencer petit permet de tester réellement son marché, d\'ajuster son offre sans risquer gros, et de construire des fondations solides. C\'est aussi l\'occasion d\'apprendre les métiers de l\'entreprise : vente, production, gestion, marketing.
                
                En Afrique, où l\'accès au financement reste un défi, cette approche progressive est souvent la plus viable. Elle développe aussi cette résilience si caractéristique des entrepreneurs africains qui savent faire beaucoup avec peu.',
            
            'path_img' => 'others/all/blogs/images/02.png',
            'views' => 189,
            'time_read' => 6,
            'is_visible' => true,
            'categorie_id' => 3, // Entrepreneuriat
            'user_id' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ===== BLOG 3 - RÉSILIENCE =====
        Blog::create([
            'title' => 'La force du bambou : L\'art de plier sans se briser face aux tempêtes de la vie',
            'token' => Str::random(10),
            'content' => 'Le bambou est l\'une des plantes les plus résistantes au monde. Contrairement au chêne qui peut se briser face à une tempête trop forte, le bambou plie, s\'adapte, et se redresse toujours.
                
                Cette métaphore illustre parfaitement le parcours de Dr. Aminata Sankara, aujourd\'hui reconnue comme l\'une des chirurgiennes les plus respectées d\'Afrique de l\'Ouest. Pourtant, son chemin n\'a pas été un long fleuve tranquille.
                
                Issue d\'une famille modeste du Burkina Faso, elle a vu ses études de médecine interrompues par des difficultés financières à trois reprises. Chaque fois, au lieu de se décourager, elle a trouvé des solutions créatives : travail de nuit, bourses d\'excellence, parrainage par des organisations.
                
                Sa plus grande épreuve ? Un accident qui a failli mettre fin à sa carrière de chirurgienne. Pendant des mois, elle a dû réapprendre à utiliser sa main dominante. "J\'ai compris que la résilience, ce n\'est pas d\'être fort en permanence, m\'a-t-elle confié. C\'est d\'accepter d\'être vulnérable et de chercher de nouveaux chemins."
                
                La vraie résilience s\'apprend et se cultive. Elle nécessite trois ingrédients : la flexibilité mentale pour s\'adapter, un réseau de soutien solide, et la conviction profonde que chaque épreuve porte en elle les graines de la croissance.
                
                Comme le bambou, nous pouvons apprendre à danser avec les tempêtes plutôt que de lutter contre elles.',
            
            'path_img' => 'others/all/blogs/images/03.png',
            'views' => 156,
            'time_read' => 8,
            'is_visible' => true,
            'categorie_id' => 4, // Résilience
            'user_id' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ===== BLOG 4 - LIFESTYLE =====
        Blog::create([
            'title' => 'L\'équilibre à l\'africaine : Concilier ambition professionnelle et valeurs familiales',
            'token' => Str::random(10),
            'content' => 'Dans la culture africaine, la famille n\'est pas juste une unité, c\'est un écosystème. Concilier ses ambitions professionnelles avec ces valeurs profondes représente un défi unique que beaucoup de leaders africains naviguent avec brio.
                
                Fatima Mahamadou, directrice générale d\'une banque au Niger, a développé sa propre philosophie de l\'équilibre. "Mon succès professionnel n\'a de sens que s\'il contribue au bien-être de ma famille élargie et de ma communauté", explique-t-elle.
                
                Plutôt que de voir la famille comme un frein à sa carrière, elle l\'a intégrée dans sa stratégie de réussite. Elle a créé un fonds familial qui finance l\'éducation des jeunes de son village, implique ses proches dans ses projets entrepreneuriaux, et fait de sa réussite un levier pour toute sa communauté.
                
                Son secret ? Des rituels non négociables : petit-déjeuner familial tous les dimanches, retour au village natal tous les trimestres, et un temps quotidien sans technologie consacré aux siens.
                
                L\'équilibre africain ne ressemble pas aux modèles occidentaux. Il s\'appuie sur l\'interdépendance, la solidarité et la notion d\'ubuntu : "Je suis parce que nous sommes".
                
                Pour réussir cet équilibre, il faut redéfinir le succès personnel comme un succès collectif, planifier ses responsabilités familiales comme ses objectifs professionnels, et cultiver la patience africaine qui sait que tout aboutit en son temps.',
            
            'path_img' => 'others/all/blogs/images/04.png',
            'views' => 203,
            'time_read' => 6,
            'is_visible' => true,
            'categorie_id' => 2, // LifeStyle
            'user_id' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ===== BLOG 5 - PARCOURS INSPIRANTS =====
        Blog::create([
            'title' => 'De gardien de nuit à millionnaire : L\'incroyable ascension de Moussa Konaté',
            'token' => Str::random(10),
            'content' => 'Il y a quinze ans, Moussa Konaté parcourait les couloirs silencieux d\'un centre commercial d\'Abidjan, lampe torche en main, veillant sur la sécurité des boutiques. Aujourd\'hui, il est à la tête d\'un empire de la sécurité privée qui opère dans huit pays africains.
                
                Son histoire commence par une nécessité : nourrir sa famille. Arrivé d\'un village de Côte d\'Ivoire avec pour seul bagage sa détermination, Moussa a accepté ce travail de gardien de nuit mal payé mais qui lui laissait les journées libres.
                
                C\'est pendant ces longues heures nocturnes qu\'il a eu ses meilleures idées. Il observait les failles de sécurité, imaginait des solutions, griffonnait des plans sur des bouts de papier. "La nuit, on a le temps de réfléchir différemment", raconte-t-il avec le sourire.
                
                Sa première innovation ? Un système d\'alerte connecté artisanal qu\'il a bricolé avec des pièces de récupération. Les commerçants ont été impressionnés par son ingéniosité et lui ont fait confiance pour sécuriser leurs établissements.
                
                Petit à petit, il a économisé, formé d\'anciens collègues, investi dans du matériel professionnel. Son approche : combiner technologie moderne et connaissance intime du terrain africain.
                
                "Mon avantage sur les grandes multinationales ? Je comprends nos réalités, nos défis, nos besoins spécifiques", explique celui qui emploie aujourd\'hui plus de 2000 personnes.
                
                Son conseil aux jeunes : "Ne méprisez aucun travail. Chaque expérience vous apprend quelque chose d\'unique. Et n\'oubliez jamais : les plus grandes réussites naissent souvent des plus grandes nécessités."',
            
            'path_img' => 'others/all/blogs/images/05.png',
            'views' => 312,
            'time_read' => 9,
            'is_visible' => true,
            'categorie_id' => 5, // Parcours Inspirants
            'user_id' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

    }
}
