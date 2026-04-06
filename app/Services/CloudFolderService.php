<?php

    namespace App\Services;

use App\Models\CloudFolder;
use App\Services\CloudFileService;

    class CloudFolderService
    {
        protected CloudFileService $cloudFileService;

        public function __construct(CloudFileService $cloudFileService)
        {
            $this->cloudFileService = $cloudFileService;
        }

        public function createCloudFolder(array $data): CloudFolder
        {
             $cloudFolder = CloudFolder::create([
                'cloud_platform_id'=> $data['cloud_platform_id'],
                'folder_name' => $data['folder_name'],
                'path' => $data['path'] ?? null,
                'folder_id' => $data['folder_id'] ?? null,
                'metadata' => json_encode($data['metadata'] ?? null),
                'cloud_folder_id' => $data['cloud_folder_id'] ?? null,
                'created_at' => getDateTime(),
                'updated_at' => getDateTime(),
            ]);

            return $cloudFolder;
        }

        public function deleteCloudFolder(CloudFolder $cloudFolder, bool $deleteForever): array
        {
            // ✅ Ajouter une vérification
            $hasFiles = $cloudFolder->cloudFiles()->exists(); // (si la relation existe)
            if ($hasFiles) {
                $result['success'] = false;
                $result['message'] = 'Impossible de supprimer le dossier car il contient des fichiers.';
                return $result;
            }

            $result = [
                'success' => true,
                'message' => 'Dossier supprimé avec succès.'
            ];

            // Vérifier si le dossier à des dossiers enfants associés
            $hasChildFolders = CloudFolder::where('cloud_platform_id', $cloudFolder->cloud_platform_id)->where('cloud_folder_id', $cloudFolder->id)->exists();

            // Si le dossier a des dossiers enfants, ne pas le supprimer
            if ($hasChildFolders) {
                $result['success'] = false;
                $result['message'] = 'Impossible de supprimer le dossier car il contient des sous-dossiers.';
                return $result;
            }

            // Supprimer le dossier sur la plateforme cloud via le service CloudFileService
            $deletionResult = $this->cloudFileService->deleteFolder($cloudFolder->folder_id, $deleteForever, $cloudFolder->cloudPlatform->toArray());

            if(!$deletionResult){
                $result['success'] = false;
                $result['message'] = 'Erreur lors de la suppression du dossier sur la plateforme cloud.';
                return $result;
            }

            // Supprimer les dossiers 
            $cloudFolder->delete();

            return $result;
        }
    }

