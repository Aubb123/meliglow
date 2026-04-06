<?php

namespace App\Traits;

use App\Models\CloudFile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasCloudFiles
{
    /**
     * Relation polymorphique vers les fichiers cloud
     */
    public function cloudFiles(): MorphMany
    {
        return $this->morphMany(CloudFile::class, 'fileable');
    }

    /**
     * Récupère tous les fichiers d'un type spécifique
     */
    public function getCloudFilesByType(string $type): Collection
    {
        return $this->cloudFiles()->where('file_type', $type)->get();
    }

    /**
     * Récupère le premier fichier d'un type spécifique
     */
    public function getFirstCloudFileByType(string $type): ?CloudFile
    {
        return $this->cloudFiles()->where('file_type', $type)->first();
    }

    /**
     * Récupère toutes les images
     */
    public function getCloudImages(): Collection
    {
        return $this->getCloudFilesByType('images');
    }

    /**
     * Récupère la première image
     */
    public function getFirstCloudImage(): ?CloudFile
    {
        return $this->getFirstCloudFileByType('images');
    }

    /**
     * Récupère toutes les vidéos
     */
    public function getCloudVideos(): Collection
    {
        return $this->getCloudFilesByType('videos');
    }

    /**
     * Récupère la première vidéo
     */
    public function getFirstCloudVideo(): ?CloudFile
    {
        return $this->getFirstCloudFileByType('videos');
    }

    /**
     * Vérifie si le modèle a des fichiers cloud
     */
    public function hasCloudFiles(): bool
    {
        return $this->cloudFiles()->exists();
    }

    /**
     * Vérifie si le modèle a des fichiers d'un type spécifique
     */
    public function hasCloudFileType(string $type): bool
    {
        return $this->cloudFiles()->where('file_type', $type)->exists();
    }

    /**
     * Compte les fichiers cloud
     */
    public function countCloudFiles(): int
    {
        return $this->cloudFiles()->count();
    }

    /**
     * Supprime tous les fichiers cloud associés
     */
    public function deleteAllCloudFiles(): bool
    {
        try {
            $allDeleted = true;

            $this->cloudFiles()->each(function ($cloudFile) use ($deleteForever, &$allDeleted) {
                $deleted = app(\App\Services\CloudFileService::class)->deleteFile($cloudFile, $deleteForever);
                if (!$deleted) {
                    $allDeleted = false;
                    \Log::warning('Failed to delete cloud file', ['file_id' => $cloudFile->id]);
                }
            });

            return $allDeleted;
        } catch (\Exception $e) {
            // Failed to delete all cloud files == (fr) Échec de la suppression de tous les fichiers cloud
            \Log::error('Failed to delete all cloud files', [
                'model' => get_class($this),
                'id' => $this->id,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
        
    /**
     * Récupère la vidéo officielle de la formation, si elle existe
     */ 
    public function getOfficialCloudVideo(): ?CloudFile
    {
        return $this->cloudFiles()->where('file_type', 'videos')->where('is_official_video', true)->first();
    }

    /**
     * Vérifie si le modèle a une vidéo officielle
     */
    public function hasOfficialCloudVideo(): bool
    {
        return $this->getOfficialCloudVideo() !== null;
    }

}
