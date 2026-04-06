<?php

namespace App\Services\CloudStorage;

use App\Services\CloudStorage\Contracts\CloudStorageInterface;
use App\Services\CloudStorage\Drivers\DrimeDriver;
use App\Services\CloudStorage\Drivers\VdocipherDriver;
use Illuminate\Http\UploadedFile;

class CloudStorageManager
{
    protected array $drivers = [];
    protected string $defaultDriver = 'drime';

    public function __construct()
    {
        // Enregistrer les drivers disponibles
        $this->registerDriver('drime', new DrimeDriver());
        $this->registerDriver('vdocipher',  new VdocipherDriver());
        // Plus tard : $this->registerDriver('mega', new MegaDriver());
    }

    /**
     * Enregistre un driver
     */
    public function registerDriver(string $name, CloudStorageInterface $driver): void
    {
        $this->drivers[$name] = $driver;
    }

    /**
     * Récupère un driver par son nom
     */
    public function driver(?string $name = null): CloudStorageInterface
    {
        $name = $name ?? $this->defaultDriver;

        // Vérifie que le driver existe
        if (!isset($this->drivers[$name])) {
            throw new \InvalidArgumentException("Driver [{$name}] not found."); // Vous pouvez aussi créer une exception personnalisée pour les drivers non trouvés
        }

        return $this->drivers[$name];
    }

    /**
     * Définit le driver par défaut
     */
    public function setDefaultDriver(string $name): void
    {
        $this->defaultDriver = $name;
    }

    /**
     * Raccourci pour upload avec le driver par défaut
     */
    public function upload(UploadedFile $file, array $options = [], ?array $platform = null): array
    {
        return $this->driver()->upload($file, $options, $platform);
    }

    /**
     * Raccourci pour delete avec le driver par défaut
     */
    public function delete(string $fileId, bool $deleteForever, ?array $platform = null): bool
    {
        return $this->driver()->delete($fileId, $deleteForever, $platform);
    }

    /**
     * Raccourci pour getShareableLink avec le driver par défaut
     */
    public function getShareableLink(string $fileId, array $options = [], ?array $platform = null): ?string
    {
        return $this->driver()->getShareableLink($fileId, $options, $platform);
    }

    // /**
    //  * Raccourci pour listFiles avec le driver par défaut
    //  */
    // public function listFiles(array $filters = []): array
    // {
    //     return $this->driver()->listFiles($filters);
    // }

    /**
     * Raccourci pour createFolder avec le driver par défaut
     */
    public function createFolder(string $name, ?string $parentId = null, ?array $platform = null): array
    {
        return $this->driver()->createFolder($name, $parentId, $platform);
    }

    /**
     * Raccourci pour deleteFolder avec le driver par défaut
     */
    public function deleteFolder(string $folderId, bool $deleteForever = true, ?array $platform = null): bool
    {
        return $this->driver()->deleteFolder($folderId, $deleteForever, $platform);
    }

    // /**
    //  * Raccourci pour getFileInfo avec le driver par défaut
    //  */
    // public function getFileInfo(string $fileId): ?array
    // {
    //     return $this->driver()->getFileInfo($fileId);
    // }


    /**
     * Raccourci pour getFileUrl — fonctionne pour Drime et Vdocipher
     */
    public function getFileUrl(string $fileId, array $platform): ?string
    {
        $driver = $this->driver($platform['name']);
 
        if (method_exists($driver, 'getFileUrl')) {
            return $driver->getFileUrl($fileId, $platform);
        }
 
        return null;
    }
 
    /**
     * Raccourci spécifique Vdocipher — génère OTP + playbackInfo
     * Utile pour intégrer le player Vdocipher en iframe
     */
    public function generateVdocipherOtp(string $videoId, array $platform, array $options = []): ?array
    {
        $driver = $this->driver('vdocipher');
 
        if ($driver instanceof VdocipherDriver) {
            return $driver->generateOtp($videoId, $platform, $options);
        }
 
        return null;
    }
}