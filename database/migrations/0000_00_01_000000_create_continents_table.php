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
        Schema::create('continents', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->string('token')->unique(); // Token pour les URL conviviales

            $table->string('name')->unique(); // Nom du continent : Afrique, Europe...
            $table->string('code', 3)->unique(); // Code abrégé : AF, EU, AS...

            $table->string('description')->nullable(); // Description optionnelle du continent
            $table->string('path_img')->default('others/all/continents/images/default.png'); // Chemin vers une image représentant le continent
            $table->unsignedBigInteger('population')->nullable(); // Population totale du continent, pas de population négative
            $table->decimal('area', 10, 2)->nullable(); // Superficie du continent, en km², pas de superficie négative

            $table->integer('sort_order')->default(0); // Utile dans les selects/listes // Pour l'ordre d'affichage : 0 en premier
            $table->boolean('is_active')->default(false); // Indique si le continent est actif
            $table->timestamps(); // created_at et updated_at
            $table->softDeletes(); // Crée automatiquement la colonne deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('continents');
    }
};
