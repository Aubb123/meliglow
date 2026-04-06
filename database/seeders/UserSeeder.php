<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $now = getDateTime();

        User::create([
            'token' => Str::random(10),
            'lastname' => 'DJOKONON',
            'firstname' => 'Moniras',
            'email' => 'monirasdjokonon@gmail.com',
            'password' => Hash::make('password'),
            'sexe' => 'man',
            'is_active' => true,
            'role_id' => 1, // Admin
            'countrie_id' => 21, // Bénin
            'remember_token' => Str::random(10),
            'email_verified_at' => $now,
            'fedapay_customer_id' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        User::create([
            'token' => Str::random(10),
            'lastname' => 'KOTO',
            'firstname' => 'Aubanel',
            'email' => 'aubanelk@gmail.com',
            'password' => Hash::make('password'),
            'sexe' => 'man',
            'is_active' => true,
            'role_id' => 2, // Developper
            'countrie_id' => 21, // Bénin
            'remember_token' => Str::random(10),
            'email_verified_at' => $now,
            'fedapay_customer_id' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        User::create([
            'token' => Str::random(10),

            'lastname' => 'User',
            'firstname' => 'Regular',
            'email' => 'regularuser@gmail.com',

            'password' => Hash::make('password'),
            'sexe' => 'man',
            'is_active' => true,
            'role_id' => 10, // User
            'countrie_id' => 21, // Bénin
            'remember_token' => Str::random(10),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // User::create([
        //     'token' => Str::random(10),

        //     'lastname' => 'DEGLA',
        //     'firstname' => 'Fabrice',
        //     'email' => 'deglafabrice@gmail.com',

        //     'password' => Hash::make('password'),
        //     'sexe' => 'man',
        //     'is_active' => true,
        //     'role_id' => 10, // User
        //     'countrie_id' => 21, // Bénin
        //     'remember_token' => Str::random(10),
        //     'email_verified_at' => $now,
        //     'created_at' => $now,
        //     'updated_at' => $now,
        // ]);
        
        // User::create([
        //     'token' => Str::random(10),

        //     'lastname' => 'DOE',
        //     'firstname' => 'John',
        //     'email' => 'doe@gmail.com',

        //     'password' => Hash::make('password'),
        //     'sexe' => 'man',
        //     'is_active' => true,
        //     'role_id' => 10, // User
        //     'countrie_id' => 21, // Bénin
        //     'remember_token' => Str::random(10),
        //     'email_verified_at' => $now,
        //     'fedapay_customer_id' => 78537,
        //     'created_at' => $now,
        //     'updated_at' => $now,
        // ]);

    }
}
