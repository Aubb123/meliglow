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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique(); // Token unique pour identification interne
            $table->string('label')->unique(); // Nom du rôle (ex. : client, superviseur, admins)
            $table->text('description')->nullable(); // Description du rôle (facultatif)
            $table->timestamps();
            $table->softDeletes(); // Crée automatiquement la colonne deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
