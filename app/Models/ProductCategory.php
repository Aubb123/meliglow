<?php

namespace App\Models;

use App\Models\Product;
use App\Traits\HasCloudFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    /** @use HasFactory<\Database\Factories\ProductCategoryFactory> */
    use HasFactory, HasCloudFiles;

    protected $fillable = [
        'name',
        'description',
        'created_at',
        'updated_at',
    ];


    /**
     * Boot method pour générer automatiquement le token
     */
    protected static function boot(): void
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
     * Relation avec les produits
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'product_categorie_id');   
    }

    public function products_count()
    {
        return $this->products()->count();
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
        return $this->hasCloudFileType('images');
    }

}
