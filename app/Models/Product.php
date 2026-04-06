<?php

namespace App\Models;

use App\Models\ProductCategory;
use App\Traits\HasCloudFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, HasCloudFiles;

    protected $fillable = [
        'token',
        'user_id',
        'product_categorie_id',
        'name',
        'description',
        'purchase_price',
        'sale_price',
        'promotional_price',
        'stock',
        'is_visible',
        'views',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_visible'        => 'boolean',
        'purchase_price'    => 'decimal:2',
        'sale_price'        => 'decimal:2',
        'promotional_price' => 'decimal:2',
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
     * Relation : un produit appartient à une catégorie
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_categorie_id');
    }

    /**
     * Relation : un produit appartient à un utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Quelques fonctions ---- Quelques fonctions ---- Quelques fonctions ---- Quelques fonctions ----
    // Quelques fonctions ---- Quelques fonctions ---- Quelques fonctions ---- Quelques fonctions ----
    // Quelques fonctions ---- Quelques fonctions ---- Quelques fonctions ---- Quelques fonctions ----
    // Quelques fonctions ---- Quelques fonctions ---- Quelques fonctions ---- Quelques fonctions ----

    /**
     * Accessor : retourne le prix effectif (promotionnel ou normal)
     */
    public function getEffectivePriceAttribute(): float
    {
        return $this->promotional_price ?? $this->sale_price;
    }

    /**
     * Scope : uniquement les produits visibles/publiés
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Scope : uniquement les produits en stock
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    
    // Helper ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ----
    // Helper ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ----
    // Helper ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ----
    // Helper ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ---- ---- Helper ---- Helper ---- Helper ----


     /**
     * Méthodes helper pour les fichiers cloud
     * (Héritées du trait HasCloudFiles)
     */

    // public function getCoverImageUrl(): ?array
    // {
    //     $cloudImage = $this->getFirstCloudImage();

    //     if ($cloudImage) {
    //         $platform = $cloudImage->cloudFolder->cloudPlatform;
            
    //         // Cache l'URL pendant 25 minutes (l'URL Cloudflare expire après 30 min)
    //         $cacheKey = "cloud_file_url_{$cloudImage->id}";
            
    //         $url_img = cache()->remember($cacheKey, now()->addMinutes(25), function () use ($cloudImage, $platform) {
    //             $drimeDriver = app(\App\Services\CloudStorage\Drivers\DrimeDriver::class);
    //             return $drimeDriver->getFileUrl($cloudImage->file_id, $platform->toArray());
    //         });

    //         return [
    //             'url_img'          => $url_img,
    //             'cloud_file_token' => $cloudImage->token,
    //         ];
    //     }

    //     return [
    //         'url_img'          => asset(getEnvFolder() . 'others/all/others/images/default.jpg'),
    //         'cloud_file_token' => null,
    //     ];
    // }

    public function getImages()
    {
        $cloudImages = $this->getCloudFilesByType('images');

        // Si aucune image n'est trouvée, retourner une collection avec une image par défaut
        if($cloudImages->isEmpty()) {
            return collect([
                [
                    'data' => [
                        'url_img'          => asset(getEnvFolder() . 'others/all/others/images/default.jpg'),
                        'cloud_file_token' => null,
                    ]
                ]
            ]);
        }

        $data = [];

        foreach($cloudImages as $cloudImage) {
            $platform = $cloudImage->cloudFolder->cloudPlatform;
            
            // Cache l'URL pendant 25 minutes (l'URL Cloudflare expire après 30 min)
            $cacheKey = "cloud_file_url_{$cloudImage->id}";
            
            $url_img = cache()->remember($cacheKey, now()->addMinutes(25), function () use ($cloudImage, $platform) {
                $drimeDriver = app(\App\Services\CloudStorage\Drivers\DrimeDriver::class);
                return $drimeDriver->getFileUrl($cloudImage->file_id, $platform->toArray());
            });

            $data[] = [
                'url_img'          => $url_img,
                'cloud_file_token' => $cloudImage->token,
            ];

        }

        return [
            'data' => $data
        ];
    }

    public function hasCoverImage(): bool
    {
        return $this->hasCloudFileType('images');
    }

}