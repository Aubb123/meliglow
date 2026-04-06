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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->foreignId('role_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('countrie_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('lastname'); // Nom de l'utilisateur
            $table->string('firstname'); // Prénom de l'utilisateur
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_active')->default(true); // État du compte (bloqué/débloqué) True = Actif (Débloqué)  False = Désactivé (bloqué)
            
            // Verification timestamps
            $table->dateTime('email_verified_at')->nullable();
            $table->dateTime('phone_verified_at')->nullable();
            $table->enum('sexe', ['man', 'woman'])->nullable(); // sexe de l'utilisateur ( 'homme', 'femme' )
            $table->date('birth_date')->nullable(); // Date de naissance de l'utilisateur
            $table->string('phone')->nullable(); // Numéro de téléphone de l'utilisateur

            // Gestion des fonds
            $table->decimal('balance', 15, 2)->default(0); // Solde du compte utilisateur
                
            // Social media links
            $table->text('bio')->nullable(); // Biographie de l'utilisateur
            $table->string('facebook_link')->nullable(); // Lien Facebook de l'utilisateur
            $table->string('twitter_link')->nullable(); // Lien Twitter de l'utilisateur
            $table->string('instagram_link')->nullable(); // Lien Instagram de l'utilisateur
            $table->string('linkedin_link')->nullable(); // Lien LinkedIn de l'utilisateur
            $table->string('youtube_link')->nullable(); // Lien YouTube de l'utilisateur
            $table->string('tiktok_link')->nullable(); // Lien TikTok de l'utilisateur
            $table->string('whatsapp_link')->nullable(); // Lien WhatsApp de l'utilisateur
            $table->string('website_link')->nullable(); // Lien vers le site personnel ou l'utilisateur
            
            // FedaPay customer ID
            $table->string('fedapay_customer_id')->nullable();

            $table->rememberToken();
            // last_login timestamp
            $table->dateTime('last_login_at')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Crée automatiquement la colonne deleted_at
        });

        // Schema::create('password_reset_tokens', function (Blueprint $table) {
        //     $table->string('email')->primary();
        //     $table->string('token');
        //     $table->dateTime('created_at')->nullable();
        // });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            $table->string('token')->unique();
            $table->string('otp_code')->unique();
            $table->dateTime('reset_token_expires_at');

            $table->string('email')->nullable(); // Adresse e-mail de l'utilisateur
            $table->string('phone')->nullable(); // Numéro de téléphone de l'utilisateur
            $table->dateTime('used_at')->nullable(); // Date d'utilisation du token
            $table->dateTime('expired_at')->nullable(); // Date d'expiration du token
            $table->timestamps();
        });
        
        Schema::create('account_reset_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            $table->string('token')->unique();
            $table->string('otp_code')->unique();
            $table->dateTime('reset_token_expires_at');

            $table->string('email')->nullable(); // Adresse e-mail de l'utilisateur
            $table->string('phone')->nullable(); // Numéro de téléphone de l'utilisateur
            $table->dateTime('used_at')->nullable(); // Date d'utilisation du token
            $table->dateTime('expired_at')->nullable(); // Date d'expiration du token
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('account_reset_tokens');
    }
};
