<?php

namespace App\Helpers\Web\Backend;

use App\Http\Controllers\CloudPlatformController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BackendHelper
{
    public static function destroy_function($entity) {
        // Pour les images
        if ($entity->path_img && !Str::contains($entity->path_img, 'default')) {
            Storage::disk('public')->delete($entity->path_img);
        }

        // Pour les vidéos
        if ($entity->path_vdo && !Str::contains($entity->path_vdo, 'default')) {
            Storage::disk('public')->delete($entity->path_vdo);
        }

        // Pour les fichiers cloud
        if ($entity->cloudFiles) {
            foreach ($entity->cloudFiles as $cloudFile) {
                
                // dd('CloudFile à supprimer'); // Debug pour vérifier les fichiers cloud associés à l'entité

                return redirect()->back()->with('error', 'Impossible de supprimer l\'entité car elle a des fichiers cloud associés. Veuillez d\'abord supprimer les fichiers cloud associés.');

            }
        }

        //Supprimer les données de la base de donnée
        $entity->delete();
    }

    public static function getCloudPlatforms() {
        $cloudPlatforms = CloudPlatformController::getCloudPlatforms();
        return $cloudPlatforms;
    }
}