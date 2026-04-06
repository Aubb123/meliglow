<?php

namespace App\Services\CloudStorage\Drivers;

use App\Services\CloudStorage\Contracts\CloudStorageInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DrimeDriver implements CloudStorageInterface
{
    /**
     * Upload un fichier vers Drime
     */
    public function upload(UploadedFile $file, array $options = [], ?array $platform): array
    {
        // ← AJOUTE CES 4 LIGNES
        set_time_limit(600); // 600 secondes (10 minutes)
        ini_set('max_execution_time', 600); // 600 secondes (10 minutes)
        ini_set('upload_max_filesize', '500M'); // 500 Mo (max pour les fichiers uploadés)
        ini_set('post_max_size', '500M'); // 500 Mo (max pour les données POST, doit être >= upload_max_filesize)
        ini_set('memory_limit', '512M'); // 512 Mo (doit être suffisant pour gérer les fichiers de 500 Mo)

        try {
            
            // Timeouts  600 secondes (10 min)
            $response = Http::withToken($platform['api_key'])->timeout(600)->attach('file', file_get_contents($file->getRealPath()), $file->getClientOriginalName())->post("{$platform['api_endpoint']}/uploads", [
                'parentId' => $options['folder_id'], // ID du dossier parent, ou null pour la racine
                'relativePath' => $options['relativePath'], // Chemin relatif pour les dossiers (ex: "folder1/subfolder2/filename.jpg")
            ]);

            if ($response->failed()) {
                Log::error('Drime upload failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                // throw new \Exception('Failed to upload file to Drime: ' . $response->body());
                return [
                    'success' => false,
                    'error'   => 'Échec de l\'upload sur Drime ' . $response->body(),
                ];
            }

            $data = $response->json();
            
            // Extraire les informations du FileEntry retourné
            $fileEntry = $data['fileEntry'] ?? $data;

            // Construire l'URL directe du fichier
            $directUrl = null;
            if (isset($fileEntry['id'])) {
                // URL directe pour affichage : https://app.drime.cloud/api/v1/file-entries/{id}
                // $directUrl = "{$platform['api_endpoint']}/file-entries/{$fileEntry['id']}?token={$platform['api_key']}";

                $directUrl = "{$platform['api_endpoint']}/file-entries/{$fileEntry['id']}";

            }
            
            return [
                'success' => true,
                'file_id' => $fileEntry['id'],
                'file_name' => $fileEntry['name'],
                'file_size' => $fileEntry['file_size'] ?? 0,
                'mime_type' => $fileEntry['mime'] ?? $file->getMimeType(),
                'hash' => $fileEntry['hash'] ?? null,
                'url' => $fileEntry['url'] ?? $directUrl, // URL pour téléchargement
                'direct_url' => $directUrl, // URL directe pour affichage
                'thumbnail' => $fileEntry['thumbnail'] ?? null,
                'type' => $fileEntry['type'] ?? 'file',
                'raw_response' => $fileEntry,
            ];

        } catch (\Exception $e) {
            Log::error('Drime upload exception', [
                'message' => $e->getMessage(),
                'file' => $file->getClientOriginalName()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Supprime un fichier de Drime
     */
    public function delete(string $fileId, bool $deleteForever, ?array $platform): bool
    {
        try {
            
            $response = Http::withToken($platform['api_key'])->post("{$platform['api_endpoint']}/file-entries/delete", [
                'entryIds' => [$fileId],
                'deleteForever' => $deleteForever, // Mettre à true pour suppression définitive
            ]);

            return $response->successful();

        } catch (\Exception $e) {
            Log::error('Drime delete exception', [
                'message' => $e->getMessage(),
                'file_id' => $fileId
            ]);
            return false;
        }
    }

    /**
     * Génère un lien partageable pour un fichier
     */
    public function getShareableLink(string $fileId, array $options = [], ?array $platform = null): ?string
    {

        try {
            
            // D'abord, essayer de récupérer le lien existant
            $existingLink = $this->getExistingShareableLink($fileId, $platform);
            if ($existingLink) {
                return $existingLink;
            }

            // Sinon, créer un nouveau lien
            $response = Http::withToken($platform['api_key'])->post("{$platform['api_endpoint']}/file-entries/{$fileId}/shareable-link", [
                'password' => $options['password'] ?? null,
                'expires_at' => $options['expires_at'] ?? null,
                'allow_edit' => $options['allow_edit'] ?? false,
                'allow_download' => $options['allow_download'] ?? true, // Par défaut, autoriser le téléchargement
            ]);

            if ($response->failed()) {
                Log::error('Drime shareable link creation failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return null;
            }

            $data = $response->json();
            $link = $data['link'] ?? null;

            if ($link && isset($link['hash'])) {
                // Construire l'URL complète du lien partageable
                return "https://app.drime.cloud/s/{$link['hash']}";
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Drime shareable link exception', [
                'message' => $e->getMessage(),
                'file_id' => $fileId
            ]);
            return null;
        }
    }

    /**
     * Récupère le lien partageable existant
     */
    protected function getExistingShareableLink(string $fileId, ?array $platform = null): ?string
    {
        try {

            $response = Http::withToken($platform['api_key'])->get("{$platform['api_endpoint']}/file-entries/{$fileId}/shareable-link");

            if ($response->successful()) {
                $data = $response->json();
                $link = $data['link'] ?? null;
                
                if ($link && isset($link['hash'])) {
                    return "https://app.drime.cloud/s/{$link['hash']}";
                }
            }
            
            return null;

        } catch (\Exception $e) {
            
            Log::error('Drime get existing shareable link exception', [
                'message' => $e->getMessage(),
                'file_id' => $fileId
            ]);

            return null;
        }
    }

    // /**
    //  * Liste les fichiers
    //  */
    // public function listFiles(array $filters = []): array
    // {
    //     try {

    //         $response = Http::withToken($this->token)->get("{$this->apiUrl}/drive/file-entries", $filters);

    //         if ($response->failed()) {
    //             return [];
    //         }

    //         return $response->json('data', []);
    //     } catch (\Exception $e) {
    //         Log::error('Drime list files exception', [
    //             'message' => $e->getMessage()
    //         ]);
    //         return [];
    //     }
    // }

    /**
     * Crée un dossier
     */
    public function createFolder(string $name, ?string $parentId = null, ?array $platform): array
    {
        try {

            $response = Http::withToken($platform['api_key'])->post("{$platform['api_endpoint']}/folders", [
                'name' => $name,
                'parentId' => $parentId,
            ]);

            if ($response->failed()) {
                return [
                    'success' => false,
                    'error' => $response->body(),
                ];
            }

            $folder = $response->json('folder', []);

            return [
                'success' => true,
                'folder_id' => $folder['id'] ?? null,
                'folder_name' => $folder['name'] ?? $name,
                'raw_response' => $folder,
            ];

        } catch (\Exception $e) {
            Log::error('Drime create folder exception', [
                'message' => $e->getMessage(),
                'folder_name' => $name
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
    * Supprime un dossier
    */
    public function deleteFolder(string $folderId, bool $deleteForever, ?array $platform): bool
    {
        try {

            $response = Http::withToken($platform['api_key'])->post("{$platform['api_endpoint']}/file-entries/delete", [
                'entryIds' => [$folderId],
                'deleteForever' => $deleteForever,
            ]);

            return $response->successful();
            
        } catch (\Exception $e) {
            return false;
        }
    }

    // /**
    //  * Récupère les informations d'un fichier
    //  */
    // public function getFileInfo(string $fileId): ?array
    // {
    //     try {
    //         // Drime n'a pas d'endpoint spécifique pour un fichier unique
    //         // On utilise la liste avec un filtre
    //         $files = $this->listFiles([]);
            
    //         foreach ($files as $file) {
    //             if (isset($file['id']) && $file['id'] == $fileId) {
    //                 return $file;
    //             }
    //         }

    //         return null;
    //     } catch (\Exception $e) {
    //         Log::error('Drime get file info exception', [
    //             'message' => $e->getMessage(),
    //             'file_id' => $fileId
    //         ]);
    //         return null;
    //     }
    // }

    public function getFileUrl(string $fileId, array $platform): ?string
    {
        try {

            $response = Http::withToken($platform['api_key'])->get("{$platform['api_endpoint']}/file-entries/{$fileId}");

            // L'URL finale après redirection est dans transferStats
            $transferStats = $response->handlerStats();
            $finalUrl = $transferStats['url'] ?? null;

            return $finalUrl;

        } catch (\Exception $e) {
            Log::error('Drime getFileUrl exception', ['message' => $e->getMessage()]);
            return null;
        }
    }
}


