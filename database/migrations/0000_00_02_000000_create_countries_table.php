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
        Schema::create('countries', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->string('token')->unique(); // Token pour les URL conviviales
            $table->foreignId('continent_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            $table->string('name')->unique(); // Nom du pays
            $table->string('code', 3)->unique(); // Code ISO Alpha-3 : FRA, USA, BEN...
            $table->string('code_2', 2)->unique(); // Code ISO Alpha-2 : FR, US, BJ...
            $table->string('phone_code', 5); // Indicatif téléphonique : +33, +229...

            $table->boolean('is_active')->default(true); // Indique si le pays est actif

            $table->string('path_img')->default('others/all/countries/images/default.png'); // Chemin vers une image représentant le pays

            $table->timestamps();
            $table->softDeletes(); // Crée automatiquement la colonne deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
