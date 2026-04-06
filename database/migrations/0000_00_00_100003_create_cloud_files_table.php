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
        Schema::create('cloud_files', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->foreignId('cloud_folder_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete(); // ID de la plateforme cloud à laquelle appartient ce fichier

            // Champs pour savoir si le fichier est une vidéo officielle, si 'file_type' est 'video'
            $table->boolean('is_official_video')->default(false);

            $table->string('fileable_type');
            $table->unsignedBigInteger('fileable_id');
            
            $table->string('file_id')->nullable(); // ID du fichier sur la plateforme cloud
            $table->string('file_name');
            $table->enum('file_type', ['images', 'videos', 'zips']); // Ex: 'video', 'image', 'zip'
            $table->unsignedBigInteger('file_size'); // En octets
            $table->string('mime_type'); // Ex: 'video/mp4', 'image/jpeg', 'application/pdf'
            $table->text('shareable_link')->nullable(); // Lien partageable du fichier
            $table->string('hash')->nullable(); // Hash du fichier pour vérifier les doublons
            $table->json('metadata')->nullable(); // Stockage de métadonnées supplémentaires spécifiques à la plateforme (thumbnail, etc.)
            $table->timestamps();

            $table->index(['fileable_type', 'fileable_id']); // Index pour les relations polymorphiques
            $table->index('cloud_folder_id');
            $table->index('file_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cloud_files');
    }
};
