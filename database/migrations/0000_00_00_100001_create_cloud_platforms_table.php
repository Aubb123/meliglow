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
        Schema::create('cloud_platforms', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique(); // Token unique pour identifier la plateforme de manière sécurisée
            $table->string('label')->nullable(); // Libellé de la plateforme
            $table->string('name'); // Ex: 'drime', 'google_drive', 'mega', 'vdocipher' etc.
            $table->string('api_endpoint')->nullable(); // URL de l'API de la plateforme
            $table->string('api_key')->nullable(); // Clé API pour accéder à la plateforme
            $table->string('api_secret')->nullable(); // Secret API pour accéder à la plateforme
            $table->text('description')->nullable(); // Description de la plateforme
            $table->enum('status', ['active', 'inactive'])->default('active'); // Statut de la plateforme
            $table->json('metadata')->nullable(); // Stockage de métadonnées supplémentaires spécifiques à la plateforme (ex: limites de stockage, fonctionnalités, etc.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cloud_platforms');
    }
};
