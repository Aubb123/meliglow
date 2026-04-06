<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $now = getDateTime();

        // Role N°1 : Admins
        Role::create([
            'label' => 'Admins',
            'token' => Str::random(10),
            'description' => 'Le role est attribué aux administrateurs du site, leur permettant de gérer les utilisateurs, les rôles, les permissions et administrer le contenu du site.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Role N°2 : Developpeur
        Role::create([
            'label' => 'Developer',
            'token' => Str::random(10),
            'description' => 'Le role est attribué aux développeurs du site, leur permettant de gérer le code, les fonctionnalités et les performances du site.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Role N°3 : Moderateur
        Role::create([
            'label' => 'Moderator',
            'token' => Str::random(10),
            'description' => 'Le role est attribué aux modérateurs du site, leur permettant de gérer les contenus et les utilisateurs de manière plus approfondie. Ils peuvent approuver ou modifier des contenus générés par les utilisateurs.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Role N°4 : ????
        Role::create([
            'label' => '????',
            'token' => Str::random(10),
            'description' => '????',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Role N°5 : ?????
        Role::create([
            'label' => '?????', 
            'token' => Str::random(10),
            'description' => '?????',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Role N°6 : ??????
        Role::create([
            'label' => '??????',
            'token' => Str::random(10),
            'description' => '??????',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Role N°7 : ???????
        Role::create([
            'label' => '???????',
            'token' => Str::random(10),
            'description' => '???????',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Role N°8 : ????????
        Role::create([
            'label' => '????????',
            'token' => Str::random(10),
            'description' => '????????',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Role N°9 : ?????????
        Role::create([
            'label' => '?????????',
            'token' => Str::random(10),
            'description' => '?????????',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Role N°10 : Visiteur|Utilisateur
        Role::create([
            'label' => 'User', 
            'token' => Str::random(10),
            'description' => 'Le role est attribué aux visiteurs ou aux utilisateurs du site, leur permettant de consulter le contenu sans avoir accès aux fonctionnalités d\'administration.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        
    }
}
