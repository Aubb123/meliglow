<?php

namespace Database\Seeders;

use App\Models\Taggable;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaggableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $now = getDateTime();

        Taggable::create([
            'tag_id' => 1,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Taggable::create([
            'tag_id' => 1,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 2,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Taggable::create([
            'tag_id' => 1,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 3,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Taggable::create([
            'tag_id' => 1,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 4,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Taggable::create([
            'tag_id' => 1,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 5,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ...

        Taggable::create([
            'tag_id' => 2,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Taggable::create([
            'tag_id' => 2,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 2,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Taggable::create([
            'tag_id' => 2,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 3,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Taggable::create([
            'tag_id' => 2,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 4,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Taggable::create([
            'tag_id' => 2,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 5,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ...

        Taggable::create([
            'tag_id' => 3,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Taggable::create([
            'tag_id' => 3,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 2,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Taggable::create([
            'tag_id' => 3,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 3,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Taggable::create([
            'tag_id' => 3,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 4,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Taggable::create([
            'tag_id' => 3,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 5,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ...

        Taggable::create([
            'tag_id' => 4,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Taggable::create([
            'tag_id' => 4,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 2,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Taggable::create([
            'tag_id' => 4,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 3,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Taggable::create([
            'tag_id' => 4,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 4,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Taggable::create([
            'tag_id' => 4,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 5,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ...

        Taggable::create([
            'tag_id' => 5,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Taggable::create([
            'tag_id' => 5,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 2,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Taggable::create([
            'tag_id' => 5,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 3,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Taggable::create([
            'tag_id' => 5,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 4,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Taggable::create([
            'tag_id' => 5,
            'taggable_type' => 'App\Models\Blog',
            'taggable_id' => 5,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
