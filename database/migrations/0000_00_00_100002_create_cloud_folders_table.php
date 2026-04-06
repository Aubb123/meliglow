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
        Schema::create('cloud_folders', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->foreignId('cloud_platform_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete(); // ID de la plateforme cloud à laquelle appartient ce fichier
            
            $table->string('folder_name'); // Nom du dossier
            $table->string('path')->nullable(); // Chemin complet du dossier (ex: "parent_folder/sub_folder")
            $table->string('folder_id')->unique()->nullable(); // ID du dossier sur la plateforme cloud
            $table->json('metadata')->nullable(); // Stockage de métadonnées supplémentaires spécifiques à la plateforme (thumbnail, etc.)

            $table->foreignId('cloud_folder_id')->nullable()->constrained('cloud_folders')->cascadeOnUpdate()->nullOnDelete(); // ID du dossier parent (pour les sous-dossiers)
            $table->timestamps();

            $table->index(['cloud_platform_id', 'folder_id', 'cloud_folder_id']); // Index pour accélérer les recherches par plateforme et ID de dossier

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cloud_folders');
    }
};
