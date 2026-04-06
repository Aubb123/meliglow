<?php

namespace App\Providers;

use App\Services\CloudStorage\CloudStorageManager;
use Illuminate\Support\ServiceProvider;

class CloudStorageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CloudStorageManager::class, function ($app) {
            return new CloudStorageManager();
        });

        // Alias pour faciliter l'injection de dépendances
        $this->app->alias(CloudStorageManager::class, 'cloud.storage');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}