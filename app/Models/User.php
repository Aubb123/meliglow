<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Country;
use App\Traits\HasCloudFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasCloudFiles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'token',
        'role_id',
        'countrie_id',
        'lastname',
        'firstname',
        'email',
        'password',
        'path_img',
        'is_active',

        'email_verified_at',
        'sexe',
        'birth_date',
        'phone',

        'balance',

        'bio',
        'facebook_link',
        'twitter_link',
        'instagram_link',
        'linkedin_link',
        'youtube_link',
        'tiktok_link',
        'whatsapp_link',
        'website_link',

        'fedapay_customer_id',

        'remember_token', 
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Fonction pour retourner le sexe en français
    public function getSexeFrAttribute(): string
    {
        // Déclaration de tableau contenant les valeurs possibles
        $result = [
            'man' => 'Homme',
            'woman' => 'Femme',
        ];

        return $result[$this->sexe] ?? 'Non spécifié';
    }

    // Fonction pour retourner l'icone du sexe
    public function getSexeIconAttribute(): string
    {
        $result = [
            'man' => 'fas fa-male',
            'woman' => 'fas fa-female',
        ];

        return $result[$this->sexe] ?? 'null';
    }

    // Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ----
    // Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ----
    // Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ----
    // Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ---- Relations Eloquent ----


    // Relations entre la Table users et roles /////////////////////////////////////////////////////////////////////////////////////////////////
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    // Relations entre la Table users et blogs /////////////////////////////////////////////////////////////////////////////////////////////////
    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }

    // Relations entre la Table users et comments /////////////////////////////////////////////////////////////////////////////////////////////////
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'countrie_id');
    }

    // Helper ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ----
    // Helper ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ----
    // Helper ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ----
    // Helper ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ----


     /**
     * Méthodes helper pour les fichiers cloud
     * (Héritées du trait HasCloudFiles)
     */

    public function getCoverImageUrl(): ?array
    {
        $cloudImage = $this->getFirstCloudImage();

        if ($cloudImage) {
            $platform = $cloudImage->cloudFolder->cloudPlatform;
            
            // Cache l'URL pendant 25 minutes (l'URL Cloudflare expire après 30 min)
            $cacheKey = "cloud_file_url_{$cloudImage->id}";
            
            $url_img = cache()->remember($cacheKey, now()->addMinutes(25), function () use ($cloudImage, $platform) {
                $drimeDriver = app(\App\Services\CloudStorage\Drivers\DrimeDriver::class);
                return $drimeDriver->getFileUrl($cloudImage->file_id, $platform->toArray());
            });

            return [
                'url_img'          => $url_img,
                'cloud_file_token' => $cloudImage->token,
            ];
        }

        return [
            'url_img'          => asset(getEnvFolder() . 'others/all/others/images/default.jpg'),
            'cloud_file_token' => null,
        ];
    }

    public function hasCoverImage(): bool
    {
        return $this->hasCloudFileType('image');
    }










}
