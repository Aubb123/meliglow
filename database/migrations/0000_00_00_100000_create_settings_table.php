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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->string('key')->unique(); //  Clé du paramètre
            $table->text('value'); // Valeur du paramètre
            $table->string('type')->default('string'); // string, integer, boolean, json
            $table->text('description')->nullable(); // Description du paramètre
            $table->boolean('is_public')->default(false); // Paramètre public ou privé
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
