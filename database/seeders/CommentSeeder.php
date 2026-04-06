<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $now = getDateTime();

        $comments = [
            // Commentaires sur l'échec et la réussite (Leadership)
            'Cette histoire de Sara Traoré me motive énormément ! J\'ai aussi vécu un échec entrepreneurial au Bénin, cet article me donne espoir.',
            'Merci pour ce témoignage. Au Mali, nous avons un proverbe qui dit "La chute n\'est pas l\'échec, ne pas se relever l\'est". Cet article l\'illustre parfaitement.',
            'J\'ai partagé cet article avec tous les jeunes entrepreneurs de mon incubateur à Dakar. Très inspirant !',
            
            // Commentaires sur l'entrepreneuriat africain
            'L\'histoire de Kemi avec ses épices me rappelle ma grand-mère qui faisait la même chose ! Ça prouve qu\'on peut réussir en partant de nos traditions.',
            'Enfin un article qui montre qu\'on peut réussir sans lever des millions ! Commencer petit, c\'est la réalité africaine.',
            'Je suis entrepreneur au Burkina Faso et je confirme : la progression étape par étape, c\'est la clé du succès durable.',
            'Bravo pour valoriser nos success stories africaines ! On en a besoin pour inspirer nos jeunes.',
            
            // Commentaires sur la résilience
            'La métaphore du bambou est magnifique. En tant qu\'infirmière, j\'ai appris que la flexibilité sauve plus de vies que la rigidité.',
            'Dr. Sankara est un exemple pour nous toutes. J\'étudie en médecine et ses difficultés me motivent à persévérer.',
            'Merci pour ce message d\'espoir. Après avoir perdu mon emploi, cet article me rappelle que je peux rebondir.',
            'L\'ubuntu mentionné ici résonne avec nos valeurs togolaises. Nous sommes plus forts ensemble.',
            
            // Commentaires sur l'équilibre lifestyle africain
            'Enfin quelqu\'un qui comprend nos réalités ! Concilier carrière et famille élargie, c\'est notre défi quotidien.',
            'Fatima Mahamadou a raison : notre réussite doit profiter à toute la communauté. C\'est ça l\'esprit africain !',
            'J\'applique déjà certains de ces rituels familiaux. Le petit-déjeuner dominical est sacré chez nous aussi.',
            'Merci de montrer qu\'on peut réussir sans renier nos valeurs traditionnelles.',
            
            // Commentaires sur le parcours de Moussa Konaté
            'Quelle ascension ! Moussa prouve qu\'aucun travail n\'est petit quand on a de l\'ambition.',
            'Son histoire me rappelle mon père qui a aussi commencé gardien avant de créer sa société. Respect !',
            'J\'ai eu les larmes aux yeux en lisant ce témoignage. Il faut diffuser ces histoires dans nos écoles !',
            'Moussa Konaté devrait être invité dans les universités pour motiver nos étudiants.',
            
            // Commentaires généraux et encourageants
            'Cette plateforme "Parcours et Résilience" est exactement ce dont l\'Afrique a besoin ! Continuez !',
            'Vos articles changent ma façon de voir les défis. Merci pour cette belle initiative.',
            'Je recommande ce blog à tous mes collègues. Du contenu de qualité enfin !',
            'Hâte de lire le prochain témoignage. Ces histoires nourrissent mon âme d\'entrepreneur.',
            'Grâce à vos articles, j\'ai repris confiance en mes projets. Merci infiniment !',
            
            // Commentaires avec référence géographique
            'Depuis Lomé, je vous félicite pour ce travail remarquable. L\'Afrique de l\'Ouest se reconnaît dans ces parcours.',
            'En tant que jeune Ivoirienne, ces témoignages me parlent directement. Continuez à nous inspirer !',
            'De Ouagadougou, un grand merci ! Vos histoires résonnent avec nos réalités burkinabées.',
            'Depuis Cotonou, je partage tous vos articles sur mes réseaux. Du travail de qualité !',
            
            // Commentaires avec impact personnel
            'Votre blog m\'a aidée à surmonter une période difficile. Ces témoignages sont thérapeutiques.',
            'J\'ai changé de perspective sur mes échecs grâce à vos articles. Merci pour cette transformation.',
            'Mon fils de 20 ans lit tous vos articles. Ça l\'inspire dans ses études d\'ingénieur.',
            'En tant que coach, je recommande votre plateforme à tous mes clients. Du contenu authentique !',
            
            // Commentaires d'engagement communautaire
            'J\'ai créé un club de lecture dans mon quartier autour de vos articles. L\'impact est réel !',
            'Nos discussions familiales ont changé depuis qu\'on lit vos témoignages ensemble.',
            'J\'utilise vos histoires dans mes formations leadership. Elles touchent plus que les théories occidentales.',
            'Bravo pour donner la parole aux vrais héros africains. Nos médias devraient s\'en inspirer.',
        ];

        foreach ($comments as $i => $content) {
            Comment::create([
                'content' => $content,
                'commentable_id' => rand(1, 5), // ID d'article de blog aléatoire (correspondant aux 5 blogs créés)
                'commentable_type' => 'App\\Models\\Blog',
                'token' => Str::random(10),
                'is_visible' => $i % 4 !== 0, // 75% des commentaires sont publiés, 25% en attente de modération
                'user_id' => rand(3, 10), // Utilisateurs aléatoires (ajustez selon vos utilisateurs)
                'created_at' => $now->subDays(rand(0, 30)), // Commentaires étalés sur 30 jours
                'updated_at' => $now->subDays(rand(0, 30)),
            ]);
        }

    }
}
