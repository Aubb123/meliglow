<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $now = getDateTime();

        // Contact 1 - Entrepreneur souhaitant partager son parcours
        Contact::create([
            'token' => Str::random(10),
            'fullname' => 'Aminata Diop',
            'email' => 'aminata.diop@gmail.com',
            'phone' => '+22165432187',
            'message' => 'Bonjour ! J\'ai lu l\'article sur Sara Traoré et j\'aimerais partager mon propre parcours d\'échec et de renaissance dans l\'agroalimentaire. Comment puis-je soumettre mon témoignage sur votre plateforme ?',
            'user_id' => 2,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Contact 2 - Jeune demandant des conseils
        Contact::create([
            'token' => Str::random(10),
            'fullname' => 'Kevin Gbaguidi',
            'email' => 'kevin.gbaguidi@etudiant.uac.bj',
            'phone' => '+22997654321',
            'message' => 'Salut ! Je suis étudiant en master à l\'UAC et vos articles m\'inspirent énormément. J\'aimerais avoir des conseils pour développer ma confiance en soi avant de lancer ma startup dans le digital. Proposez-vous du coaching ?',
            'user_id' => null, // Contact anonyme
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Contact 3 - Professionnelle souhaitant collaborer
        Contact::create([
            'token' => Str::random(10),
            'fullname' => 'Dr. Fatoumata Sangaré',
            'email' => 'f.sangare@clinique-bamako.ml',
            'phone' => '+22376543210',
            'message' => 'Félicitations pour votre plateforme ! Je suis psychologue clinicienne au Mali et j\'aimerais contribuer avec des articles sur la résilience psychologique et la gestion du trauma. Êtes-vous ouverts aux collaborations d\'experts ?',
            'user_id' => 3,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Contact 4 - Parent cherchant des ressources
        Contact::create([
            'token' => Str::random(10),
            'fullname' => 'Marie-Claire Assogba',
            'email' => 'mc.assogba@yahoo.fr',
            'phone' => '+22994123456',
            'message' => 'Bonsoir, je suis maman de 3 enfants et enseignante. Vos articles sur l\'équilibre famille-carrière me parlent beaucoup. Organisez-vous des ateliers pour parents sur le développement de la résilience chez les enfants ?',
            'user_id' => 5,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Contact 5 - Entrepreneur demandant du mentorat
        Contact::create([
            'token' => Str::random(10),
            'fullname' => 'Moussa Traoré',
            'email' => 'moussa.traore.startup@outlook.com',
            'phone' => '+22670987654',
            'message' => 'Bonjour l\'équipe ! L\'histoire de Moussa Konaté m\'a profondément marqué car j\'ai un parcours similaire. Je viens de créer ma petite entreprise de logistique mais je me sens isolé. Avez-vous un réseau de mentors ou une communauté d\'entrepreneurs que je pourrais rejoindre ?',
            'user_id' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

    }
}
