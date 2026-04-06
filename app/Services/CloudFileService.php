<?php

namespace App\Services;

use App\Models\CloudFile;
use App\Services\CloudStorage\CloudStorageManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CloudFileService
{
    protected CloudStorageManager $cloudStorage;

    public function __construct(CloudStorageManager $cloudStorage)
    {
        $this->cloudStorage = $cloudStorage;
    }

    /**
     * Upload un fichier et enregistre les métadonnées en base
     * 
     * @param UploadedFile $file
     * @param string $fileableType (ex: 'App\Models\User')
     * @param int $fileableId
     * @param string $fileType ('image', 'video', 'document', 'zip')
     * @param array $platform
     * @param array $options
     * @param int $cloud_folder_id
     * @param bool $isOfficialVideo (indique si c'est une vidéo officielle de la formation, applicable uniquement si $fileType est 'video')
     * @return RedirectResponse|array|CloudFile|null
     */
    public function uploadAndStore(UploadedFile $file, string $fileableType, int $fileableId, string $fileType, array $platform, int $cloud_folder_id, bool $isOfficialVideo, array $options = [],): CloudFile|array|null
    {
        DB::beginTransaction();

        try {

            // 0. Créer un nouveau nom si spécifié
            if (isset($options['custom_name'])) {
                $extension = $file->getClientOriginalExtension();
                $newName = $options['custom_name'] . '.' . $extension;
                
                /**
                 * Crée un fichier temporaire avec un nouveau nom
                 * 
                 * Cette section crée une copie temporaire du fichier uploadé dans le répertoire
                 * temporaire du système d'exploitation (serveur local), puis enveloppe cette
                 * copie dans un nouvel objet UploadedFile.
                 * 
                 * Stockage:
                 * - Le fichier est stocké TEMPORAIREMENT sur votre SERVEUR LOCAL (pas sur Drime)
                 * - Localisation du fichier temporaire:
                 *   * Windows: C:\Users\[username]\AppData\Local\Temp\
                 *   * Linux/Mac: /tmp/
                 * 
                 * - Utilise sys_get_temp_dir() qui retourne le chemin du dossier temp du système
                 * - Le fichier porte le nouveau nom spécifié ($newName)
                 * - L'option 'true' en dernier paramètre indique que c'est un fichier temporaire
                 *   qui sera supprimé automatiquement après utilisation
                 * 
                 * Note: Ce fichier temporaire ne persiste que le temps du traitement actuel.
                 * Pour une sauvegarde permanente, il devrait être déplacé ailleurs (stockage, Drime, etc.)
                 */
                
                // Créer un nouveau fichier temporaire avec le nouveau nom
                $tempPath = sys_get_temp_dir() . '/' . $newName;
                copy($file->getRealPath(), $tempPath);
                $file = new UploadedFile($tempPath, $newName, $file->getMimeType(), null, true);
            }

            // 1. Upload vers la plateforme cloud
            $uploadResult = $this->cloudStorage->driver($platform['name'])->upload($file, $options, $platform);

            if (!$uploadResult['success']) {

                DB::rollBack(); // ← MANQUANT !

                // Décoder les détails de l'erreur
                $errorDetails = null;
                if(isset($uploadResult['error'])) {
                    $errorDetails = json_decode($uploadResult['error'], true);
                    $errorMessage = $errorDetails['message'] ?? 'Error during file upload to cloud platform';
                    Log::error($errorMessage, ['details' => $errorDetails]);
                }else{
                    $errorMessage = 'Error during file upload to cloud platform, no error details provided';
                    Log::error($errorMessage);
                }

                return [
                    'success' => false,
                    'message' => $errorMessage,
                    'cloudFile' => null,
                ];

            }

            // 2. Créer le lien partageable
            $shareableLink = null;
            if ($uploadResult['file_id']) {
                $shareableLink = $this->cloudStorage->driver($platform['name'])->getShareableLink(
                    $uploadResult['file_id'], 
                    ['allow_download' => $options['allow_download'] ?? true],
                    $platform
                );
            }

            // 3. Enregistrer en base de données
            $cloudFile = CloudFile::create([
                'cloud_folder_id' => $cloud_folder_id,
                'is_official_video' => $fileType === 'video' ? $isOfficialVideo : false, // Marquer comme vidéo officielle si c'est une vidéo et que $isOfficialVideo est true
                'fileable_type' => $fileableType,
                'fileable_id' => $fileableId,
                'file_id' => $uploadResult['file_id'],
                'file_name' => $uploadResult['file_name'] ?? $file->getClientOriginalName(),
                'file_type' => $fileType,
                'file_size' => $uploadResult['file_size'] ?? $file->getSize(),
                'mime_type' => $uploadResult['mime_type'] ?? $file->getMimeType(),
                'shareable_link' => $shareableLink,
                'hash' => $uploadResult['hash'] ?? null,
                'metadata' => [
                    'original_name' => $file->getClientOriginalName(),
                    'extension' => $file->getClientOriginalExtension(),
                    'thumbnail' => $uploadResult['thumbnail'] ?? null,
                    'url' => $uploadResult['url'] ?? null,
                    'direct_url' => $uploadResult['direct_url'] ?? null, // ← Ajouter l'URL directe
                    'uploaded_at' => getDateTime()->toDateTimeString(),
                ],
            ]);

            DB::commit();

            Log::info('Fichier téléchargé et stocké avec succès', [
                'file_name' => $cloudFile->file_name,
                'platform' => $platform['name'],
                'file_type' => $fileType,
            ]);

            return [
                'success' => true,
                'message' => 'Fichier téléchargé et stocké avec succès',
                'cloudFile' => $cloudFile,
            ];

        } catch (\Exception $e) {

            DB::rollBack();
            
            Log::error('Échec du téléchargement et du stockage du fichier', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName(),
                'platform' => $platform['name'],
            ]);

            return [
                'success' => false,
                'message' => 'Échec du téléchargement et du stockage du fichier',
                'cloudFile' => null,
            ];
        }
    }

    // /**
    //  * Upload multiple files
    //  * 
    //  * @param array $files
    //  * @param string $fileableType
    //  * @param int $fileableId
    //  * @param string $fileType
    //  * @param string $platform
    //  * @param array $options
    //  * @return array
    //  */
    // public function uploadMultiple(array $files, string $fileableType, int $fileableId, string $fileType, string $platform = 'drime', array $options = []): array {
    //     $uploadedFiles = [];
    //     $errors = [];
    //     foreach ($files as $file) {
    //         if ($file instanceof UploadedFile) {
    //             $cloudFile = $this->uploadAndStore($file, $fileableType, $fileableId, $fileType, $platform, $options);

    //             if ($cloudFile) {
    //                 $uploadedFiles[] = $cloudFile;
    //             } else {
    //                 $errors[] = $file->getClientOriginalName();
    //             }
    //         }
    //     }

    //     return [
    //         'uploaded' => $uploadedFiles,
    //         'errors' => $errors,
    //         'count' => count($uploadedFiles),
    //     ];
    // }

    /**
     * Supprime un fichier cloud et ses métadonnées
     * 
     * @param CloudFile $cloudFile
     * @param bool $deleteForever (optionnel, par défaut true)
     * @return bool
     */
    public function deleteFile(CloudFile $cloudFile, bool $deleteForever): bool
    {
        try {

            // 1. Supprimer de la plateforme cloud
            $deleted = $this->cloudStorage->driver($cloudFile->cloudFolder->cloudPlatform->name)->delete($cloudFile->file_id, $deleteForever, $cloudFile->cloudFolder->cloudPlatform->toArray());

            if (!$deleted) {
                Log::warning('Failed to delete file from cloud platform', [
                    'file_id' => $cloudFile->file_id,
                    'platform' => $cloudFile->cloudFolder->cloudPlatform->name,
                ]);

                return false;

            }

            // 2. Supprimer de la base de données
            $cloudFile->delete();

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to delete cloud file', [
                'error' => $e->getMessage(),
                'file_id' => $cloudFile->file_id,
            ]);

            return false;
        }
    }

    // /**
    //  * Récupère les fichiers d'une entité
    //  * 
    //  * @param string $fileableType
    //  * @param int $fileableId
    //  * @param string|null $fileType
    //  * @return \Illuminate\Database\Eloquent\Collection
    //  */
    // public function getFiles(string $fileableType, int $fileableId, ?string $fileType = null)
    // {
    //     $query = CloudFile::where('fileable_type', $fileableType)
    //         ->where('fileable_id', $fileableId);

    //     if ($fileType) {
    //         $query->where('file_type', $fileType);
    //     }

    //     return $query->get();
    // }

    // /**
    //  * Récupère le premier fichier d'un type spécifique
    //  * 
    //  * @param string $fileableType
    //  * @param int $fileableId
    //  * @param string $fileType
    //  * @return CloudFile|null
    //  */
    // public function getFirstFile(string $fileableType, int $fileableId, string $fileType): ?CloudFile
    // {
    //     return CloudFile::where('fileable_type', $fileableType)->where('fileable_id', $fileableId)->where('file_type', $fileType)->first();
    // }

    // /**
    //  * Met à jour le lien partageable d'un fichier
    //  * 
    //  * @param CloudFile $cloudFile
    //  * @param array $options
    //  * @return bool
    //  */
    // public function updateShareableLink(CloudFile $cloudFile, array $options = []): bool
    // {
    //     try {
    //         $shareableLink = $this->cloudStorage->driver($cloudFile->cloudPlatform->name)->getShareableLink($cloudFile->file_id, $options);

    //         if ($shareableLink) {
    //             $cloudFile->update(['shareable_link' => $shareableLink]);
    //             return true;
    //         }

    //         return false;

    //     } catch (\Exception $e) {
    //         Log::error('Failed to update shareable link', [
    //             'error' => $e->getMessage(),
    //             'file_id' => $cloudFile->file_id,
    //         ]);

    //         return false;
    //     }
    // }

    
    /**
     * Récupère ou crée un dossier sur la plateforme cloud
     * 
     * @param string $folderPath (ex: "aunadi/aunalearn/users/images")
     * @param array $platform (array contenant les informations de la plateforme cloud)
     * @param string|null $parentId (ID du dossier parent sur la plateforme cloud, si applicable)
     * @return array|null (['success' => bool, 'folder_id' => string|null, 'folder_name' => string|null, 'raw_response' => array|null, 'error' => string|null])
     */
    public function getOrCreateFolder(string $folderPath, array $platform, ?string $parentId = null): ?array
    {
        $folders = explode('/', $folderPath);

        foreach ($folders as $folderName) {
            $result = $this->cloudStorage->driver($platform['name'])->createFolder($folderName, $parentId, $platform);
            $parentId = $result['folder_id'] ?? null;
        }
        
        return $result;
    }

    /**
     * Supprime un dossier sur la plateforme cloud
     * 
     * @param string $folderId
     * @param array $platform
     * @param bool $deleteForever (optionnel, par défaut true)
     * @return bool
     */
    public function deleteFolder(string $folderId, array $platform, bool $deleteForever): bool
    {
        return $this->cloudStorage->driver($platform['name'])->deleteFolder($folderId, $deleteForever, $platform);
    }
}

