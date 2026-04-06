<?php

namespace App\Models;

use App\Models\CloudFolder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class CloudFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'cloud_folder_id',

        'is_official_video', // ← Nouveau champ pour indiquer si c'est une vidéo officielle

        'fileable_type',
        'fileable_id',

        'file_id',
        'file_name',
        'file_type',
        'file_size',
        'mime_type',
        'shareable_link',
        'hash',
        'metadata',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'file_size' => 'integer',
    ];

    /**
     * Boot method pour générer automatiquement le token
     */
    protected static function boot()
    {
        parent::boot();

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

    public function fileable()
    {
        return $this->morphTo();
    }

    public function cloudFolder(): BelongsTo
    {
        return $this->belongsTo(CloudFolder::class);
    }

    // Helper ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ----
    // Helper ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ----
    // Helper ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ----
    // Helper ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ----

    /**
     * Scope pour filtrer par plateforme
     */
    public function scopePlatform($query, string $platform)
    {
        return $query->where('platform', $platform);
    }

    /**
     * Scope pour filtrer par type de fichier
     */
    public function scopeFileType($query, string $type)
    {
        return $query->where('file_type', $type);
    }

    /**
     * Vérifie si c'est une vidéo
     */
    public function isVideo(): bool
    {
        return $this->file_type === 'video';
    }

    /**
     * Vérifie si c'est une image
     */
    public function isImage(): bool
    {
        return $this->file_type === 'image';
    }

    /**
     * Récupère la taille formatée
     */
    public function getFormattedSizeAttribute(): string
    {
        if (!$this->file_size) {
            return 'N/A';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $size = $this->file_size;
        $unitIndex = 0;

        while ($size >= 1024 && $unitIndex < count($units) - 1) {
            $size /= 1024;
            $unitIndex++;
        }

        return round($size, 2) . ' ' . $units[$unitIndex];
    }

    /**
     * Récupère l'URL du fichier
     */
    public function getUrlAttribute(): ?string
    {
        return $this->shareable_link;
    }

    /**
     * Récupère l'URL directe pour affichage (images, vidéos)
     */
    public function getDirectUrlAttribute(): ?string
    {
        // Priorité à l'URL directe stockée dans metadata
        if (isset($this->metadata['direct_url'])) {
            return $this->metadata['direct_url'];
        }

        // Sinon, construire l'URL directe à partir du file_id
        if ($this->file_id && $this->platform === 'drime') {
            $token = $this->cloudFolder->cloudPlatform->api_key ?? null;
            $apiUrl = $this->cloudFolder->cloudPlatform->api_endpoint ?? null;
            return "{$apiUrl}/file-entries/{$this->file_id}?token={$token}";
        }

        // Fallback sur shareable_link
        return $this->shareable_link;
    }

}