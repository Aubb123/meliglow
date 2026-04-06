<?php

namespace App\Models;

use App\Models\CloudFolder;
use App\Models\CloudPlatform;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class CloudFolder extends Model
{
    /** @use HasFactory<\Database\Factories\CloudFolderFactory> */
    use HasFactory;

    protected $fillable = [
        'token',
        'cloud_platform_id',
        'folder_name',
        'path',
        'folder_id',
        'metadata',
        'cloud_folder_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * Boot method pour générer automatiquement le token
     */
    protected static function boot()
    {
        parent::boot();

        // Génère un token unique lors de la création d'un nouveau dossier
        static::creating(function ($model) {
            if (empty($model->token)) {
                $model->token = self::generateUniqueToken();
            }
        });
            
    }

    /**
     * Génère un token unique
     */
    protected static function generateUniqueToken(): string
    {
        do {
            $token = Str::random(10); // Génère un token de 10 caractères
        } while (self::where('token', $token)->exists());

        return $token;
    }

    // Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ----
    // Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ----
    // Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ----
    // Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ----

    /**
     * Relation avec la plateforme cloud
     */
    public function cloudPlatform(): BelongsTo
    {
        return $this->belongsTo(CloudPlatform::class);
    }

    public function children()
    {
        return $this->hasMany(CloudFolder::class, 'cloud_folder_id');
    }

    public function parentFolder(): BelongsTo
    {
        return $this->belongsTo(CloudFolder::class, 'cloud_folder_id');
    }

}
