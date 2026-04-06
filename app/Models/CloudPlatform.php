<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CloudPlatform extends Model
{
    /** @use HasFactory<\Database\Factories\CloudPlatformFactory> */
    use HasFactory;

    protected $fillable = [
        'token',
        'label',
        'name',
        'api_endpoint',
        'api_key',
        'api_secret',
        'description',
        'status',
        'metadata',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    // Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ----
    // Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ----
    // Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ----
    // Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ----

    public function cloudFolders(): HasMany
    {
        return $this->hasMany(CloudFolder::class)->orderBy('id', 'asc');
    }

    public function cloudFiles(): HasMany
    {
        return $this->hasMany(CloudFile::class);
    }

    // Helper ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ----
    // Helper ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ----
    // Helper ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ----
    // Helper ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ----

    // Fonction pour générer un token unique pour la plateforme cloud
    public static function generateUniqueToken(): string
    {        
        do {
            $token = bin2hex(random_bytes(10)); // Génère un token de 20 caractères (10 octets)
        } while (self::where('token', $token)->exists()); // Vérifie que le token est unique

        return $token;
    }
}
