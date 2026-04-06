<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $now = getDateTime();

        Tag::create([
            'name' => 'confiance en soi',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'estime de soi',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'motivation',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'objectifs',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ===== TAGS LEADERSHIP =====
        Tag::create([
            'name' => 'leadership',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'management',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'équipe',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'communication',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'influence',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ===== TAGS LIFESTYLE =====
        Tag::create([
            'name' => 'équilibre vie-travail',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'habitudes',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'bien-être',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'productivité',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'santé mentale',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ===== TAGS RÉSILIENCE =====
        Tag::create([
            'name' => 'résilience',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'échec',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'rebond',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'dépassement de soi',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'adversité',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'persévérance',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ===== TAGS ENTREPRENEURIAT =====
        Tag::create([
            'name' => 'entrepreneuriat',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'startup',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'innovation',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'business model',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'financement',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'pivot',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ===== TAGS PARCOURS =====
        Tag::create([
            'name' => 'témoignage',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'inspiration',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'success story',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'leçons de vie',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'transformation',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ===== TAGS COMPÉTENCES =====
        Tag::create([
            'name' => 'soft skills',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'networking',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'négociation',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'prise de parole',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'gestion du temps',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ===== TAGS CONTEXTE AFRICAIN/BÉNINOIS =====
        Tag::create([
            'name' => 'Afrique',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'Bénin',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'jeunesse africaine',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'diaspora',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ===== TAGS DOMAINES SPÉCIFIQUES =====
        Tag::create([
            'name' => 'technologie',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'agriculture',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'éducation',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'finance',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'art et culture',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ===== TAGS ACTIONS/CONSEILS =====
        Tag::create([
            'name' => 'conseils pratiques',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'méthode',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'stratégie',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Tag::create([
            'name' => 'plan d\'action',
            'token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

    }

}
