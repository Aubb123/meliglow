<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->foreignId('categorie_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            
            $table->string('title');
            $table->longText('content');
            $table->string('path_img');
            $table->unsignedInteger('views')->default(0); //Pour compter le nombre de vue du blog
            $table->unsignedSmallInteger('time_read'); //Temps de lecture estimé en minutes
            $table->boolean('is_visible')->default(false); // FALSE = Brouillon, TRUE = Publié
            $table->timestamps();
            $table->softDeletes(); // Crée automatiquement la colonne deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
