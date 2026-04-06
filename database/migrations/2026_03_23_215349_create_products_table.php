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
        Schema::create('products', function (Blueprint $table) {
            // Champs de base
            $table->id();
            $table->string('token')->unique();

            // Clés étrangères
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('product_categorie_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            $table->string('name');
            $table->text('description');
            
            // Prix d'achat, de vente, promotionnel, etc.
            $table->decimal('purchase_price', 10, 2); // Prix d'achat
            $table->decimal('sale_price', 10, 2); // Prix de vente
            $table->decimal('promotional_price', 10, 2)->nullable(); // Prix promotionnel, nullable si pas de promotion

            // Quantité en stock et visibilité
            $table->unsignedInteger('stock'); // Quantité en stock
            $table->boolean('is_visible')->default(false); // FALSE = Brouillon, TRUE = Publié
            $table->unsignedInteger('views')->default(0); // Pour compter le nombre de vues du produit

            $table->boolean('is_featured')->default(false); // FALSE = Non mis en avant, TRUE = Mis en avant

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
