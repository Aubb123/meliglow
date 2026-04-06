<?php

namespace Database\Seeders;

use App\Models\Subscribe;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubscribeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $now = getDateTime();

        Subscribe::create([
            'token' => Str::random(10),
            'email' => 'johndoe@mail.com',
            'etat' => true, 
            // 'user_id' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Subscribe::create([
            'token' => Str::random(10),
            'email' => 'josias@mail.com',
            'etat' => true,
            // 'user_id' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Subscribe::create([
            'token' => Str::random(10),
            'email' => 'avrelle@mail.com',
            'etat' => true,
            // 'user_id' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
