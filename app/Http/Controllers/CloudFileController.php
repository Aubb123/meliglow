<?php

namespace App\Http\Controllers;

use App\Models\CloudFile;
use App\Models\CloudFolder;
use App\Models\CloudPlatform;
use App\Services\CloudFileService;
use App\Services\CloudFolderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CloudFileController extends Controller
{
    // CloudFileService est injecté dans le constructeur pour être utilisé dans les méthodes du contrôleur
    protected CloudFileService $cloudFileService;
    protected CloudFolderService $cloudFolderService;

    // __construct est utilisé pour injecter le CloudFileService dans le contrôleur, permettant ainsi d'utiliser ses méthodes pour gérer les fichiers cloud dans les différentes actions du backend.
    public function __construct(CloudFileService $cloudFileService)
    {
        $this->cloudFileService = $cloudFileService;
        $this->cloudFolderService = app(CloudFolderService::class);
    }

    public function backend_model_upload(Request $request): RedirectResponse
    {
        // dd($request->all());

        // Validation de la requête pour l'upload de vidéo (à implémenter)
        $validatedData = $request->validate([
            'model_type' => 'required|string|in:App\Models\User,App\Models\ProductCategory,App\Models\Product', // Limiter les types de modèles autorisés
            'model_token' => 'required|string',
            'file_type' => 'required|string|in:images,videos,zips', // Limiter les types de fichiers autorisés (image, vidéo, zip)
            'cloud_platform_token' => 'required|string|exists:cloud_platforms,token',
            'path' => 'required|mimes:png,jpg,jpeg,mp4,zip|max:39936', // Limite à 39MB
        ]);

        // Si le type de fichier est une image, on limite à 2MB et on accepte uniquement les formats png et jpg
        if($validatedData['file_type'] == 'images') {
            // Si le type de fichier est une image, on limite à 2MB et on accepte uniquement les formats png et jpg
            if ($request->hasFile('path')) {
                $file = $request->file('path');
                $mimeType = $file->getMimeType();
                $fileSize = $file->getSize();

                if (!in_array($mimeType, ['image/png', 'image/jpeg', 'image/jpg'])) {
                    return redirect()->back()->with('error', "Le fichier doit être une image au format PNG ou JPG.")->withInput();
                }
                if ($fileSize > 2 * 1024 * 1024) {
                    return redirect()->back()->with('error', "La taille de l'image ne doit pas dépasser 2MB.")->withInput();
                }
            }

        }

        // Récupérer le modèle cible en fonction du type et du token $modelClass = $validatedData['model_type'];
        if(!in_array($validatedData['model_type'], ['App\Models\User', 'App\Models\ProductCategory', 'App\Models\Product'])) {
            return redirect()->back()->with('error', "Type de modèle invalide")->withInput();
        }

        // Récupérer l'instance du modèle cible
        $modelClass = $validatedData['model_type'];
        $model = $modelClass::where('token', $validatedData['model_token'])->first(); // On suppose que tous les modèles ont un champ 'token' pour l'identification
        if(!$model) {
            return redirect()->back()->with('error', "Modèle cible introuvable")->withInput();
        }

        // Récupérer la plateforme cloud sélectionnée
        $cloudPlatform = CloudPlatform::where('token', $request->input('cloud_platform_token'))->firstOrFail();

        // Si $cloudPlatform->name ne contient pas "drime", 
        // retourner une erreur car pour l'instant on ne supporte que Drime pour les vidéos
        if(!str_contains(strtolower($cloudPlatform->name), 'drime')) {
            return redirect()->back()->with('error', "Pour les fichiers zip, seule la plateforme Drime est supportée pour l'instant")->withInput();
        }

        // Vérifier que le fichier est présent si le type est zip   
        if(!$request->hasFile('path')) {
            return redirect()->back()->with('error', "Le fichier est requis")->withInput();
        }

        // Récupérer ou créer le dossier cloud correspondant à ce type de modèle et ce type de média sur la plateforme cloud, 
        // pour organiser les fichiers dans des dossiers spécifiques sur Drime en fonction du type de média et du type de modèle 
        // (ex: dossier "photos" pour les images des utilisateurs, etc.)
        $cloudFolderResult = $this->getCloudFolder($validatedData, $cloudPlatform, $model);
        if (!$cloudFolderResult['success']) {
            return redirect()->back()->with('error', $cloudFolderResult['message'])->withInput();
        }

        // Récupérer les détails du dossier cloud et le nom personnalisé pour le fichier à uploader, qui ont été déterminés dans la méthode getCloudFolder
        $cloudFolder = $cloudFolderResult['cloudFolder'];
        $custom_name = $cloudFolderResult['custom_name'];

        // Vérifier que le dossier cloud existe pour ce type de modèle et ce type de média
        if(!$cloudFolder) {
            return redirect()->back()->with('error', "Dossier cloud introuvable pour ce type de modèle et ce type de média")->withInput();
        }   
        // Vérifier si le custom_name a été généré dans la méthode getCloudFolder, qui est basé sur le modèle et son token pour garantir l'unicité du nom du fichier sur Drime
        if(!$custom_name) {
            return redirect()->back()->with('error', "Erreur lors de la génération du nom personnalisé pour le fichier")->withInput();
        }

        if($validatedData['model_type'] !== 'App\Models\Product' && $validatedData['file_type'] === 'images') {
            // Dernière vérification avant l'upload : s'assurer que le modèle cible n'a pas déjà une vidéo (fichier cloud de type 'video' associé à ce modèle),
            // car pour l'instant on limite à une seule vidéo par modèle. Si une vidéo existe déjà, retourner une erreur.
            $existingCloudFile = CloudFile::where('fileable_type', $validatedData['model_type'])->where('fileable_id', $model->id)->where('file_type', $validatedData['file_type'])->first();
            // Si $existingCloudFile existe, cela signifie que le modèle cible a déjà un zip, donc on retourne une erreur pour éviter d'en uploader un nouveau sans supprimer l'ancien au préalable
            if($existingCloudFile) {
                return redirect()->back()->with('error', "Ce modèle a déjà un fichier " . $validatedData['file_type'] . " associé. Veuillez supprimer le fichier existant avant d'en uploader un nouveau.")->withInput();
            }
        }

        // ============================================
        // UPLOAD DU ZIP VERS DRIME
        // ============================================
        if ($request->hasFile('path')) {
            $result = $this->cloudFileService->uploadAndStore(
                file: $request->file('path'),
                fileableType: $validatedData['model_type'],
                fileableId: $model->id,
                fileType: $validatedData['file_type'],
                platform: $cloudPlatform->toArray(),
                cloud_folder_id: $cloudFolder->id,
                isOfficialVideo: false, // N'est pas une vidéo officielle, ce champ est uniquement pertinent pour les vidéos
                options: [
                    'custom_name' => $custom_name, // Exemple de nom personnalisé : "123_4d78e7f1f2_zip_789456123"
                    'folder_id' => $cloudFolder->folder_id, // ID du dossier Drime pour ce type de média et ce type de modèle
                    'allow_download' => false, // Permettre le téléchargement du zip
                    'relativePath' => null, // Pas de chemin relatif pour les zips, ils sont tous dans le même dossier
                ],
            );
        }

        if(isset($result['success']) && $result['success'] === false) {
            return redirect()->back()->with('error', $result['message'])->withInput();
        }elseif(isset($result['success']) && $result['success'] === true) {
            return redirect()->back()->with('success', $result['message']);
        }else{
            return redirect()->back()->with('error', "Résultat inattendu lors de l'upload du fichier")->withInput();
        }
    }
    
    public function backend_model_delete(Request $request): RedirectResponse
    {
        // Validation de la requête
        $validatedData = $request->validate([
            'file_type' => 'required|string|in:images,videos,zips', // Limiter les types de fichiers autorisés (image, vidéo, zip)
            'model_token' => 'required|string',
            'model_type' => 'required|string|in:App\Models\User,App\Models\ProductCategory,App\Models\Product',
            'cloud_file_token' => 'required|string|exists:cloud_files,token',
            'delete_forever' => ['required', 'boolean', 'in:0,1'],
        ]);

        if($validatedData['delete_forever'] === '1') {
            $validatedData['delete_forever'] = true;
        } else {
            $validatedData['delete_forever'] = false;
        }

        // Récupérer l'instance du modèle cible
        $modelClass = $validatedData['model_type'];
        // Récupérer le (user, etc.) en fonction du token
        $model = $modelClass::where('token', $validatedData['model_token'])->first();
        if(!$model) {
            return redirect()->back()->with('error', "Modèle cible introuvable")->withInput();
        }

        // Récupérer le fichier cloud associé à ce modèle et de ce type
        $cloudFile = CloudFile::where('token', $validatedData['cloud_file_token'])->where('file_type', $validatedData['file_type'])->first();
        if(!$cloudFile) {
            return redirect()->back()->with('error', "Aucun fichier trouvé pour ce modèle et ce type")->withInput();
        }
        
        // Vérifier que le fichier cloud appartient bien au modèle cible
        if($cloudFile->fileable_type !== $validatedData['model_type'] || $cloudFile->fileable_id !== $model->id) {
            return redirect()->back()->with('error', "Le fichier cloud ne correspond pas au modèle cible")->withInput();
        }

        // Appeler la méthode de suppression du fichier cloud dans le service
        $deletionResult = $this->cloudFileService->deleteFile($cloudFile, $validatedData['delete_forever']);

        if ($deletionResult) {
            return redirect()->back()->with('success', 'Fichier supprimée avec succès.');
        }else{
            return redirect()->back()->with('error', "Erreur lors de la suppression du fichier cloud");
        }

    }

    /*
    *
    *
    *
    *
    *
    *
    *
    *
    *
    *
    *
    */

    private function ensureCloudFolderExists(CloudPlatform $cloudPlatform, string $path, string $finalFolderName): CloudFolder|Array|null
    {
        $segments = explode('/', $path);

        $parentFolder   = null;
        $parentFolderId = null;
        $currentPath    = null;

        // Processus de cration des dossiers parents un par un : on parcourt les segments du chemin, et pour chaque segment, on vérifie s'il existe 
        // déjà un dossier cloud avec ce nom et ce chemin sur la plateforme cloud.
        // $segments = ['moniras', 'meli\'Glow', 'others', 'all', 'users', 'images']
        foreach($segments as $segment) {

            // On cherche le dossier avec le chemin PARENT (currentPath avant ajout du segment)
            $existingFolder = $cloudPlatform->cloudFolders()->where('folder_name', $segment)
                ->where('path', $currentPath) // $currentPath = chemin du parent
                ->first();

            if($existingFolder) {
                $parentFolder   = $existingFolder;
                $parentFolderId = $existingFolder->folder_id;
                // Mettre à jour currentPath APRÈS avoir trouvé le dossier
                $currentPath = $currentPath ? $currentPath . '/' . $segment : $segment;
                continue;
            }

            $result = $this->cloudFileService->getOrCreateFolder(
                $segment,
                $cloudPlatform->toArray(),
                $parentFolderId,
            );

            // Décoder les détails de l'erreur si la création du dossier a échoué, pour afficher un message d'erreur plus précis
            $errorDetails = null;
            if(isset($result['error'])) {
                $errorDetails = json_decode($result['error'], true);
                $message = 'Dossier ' . $segment . ' : ' . ($errorDetails['errors']['name'] ?? "Erreur lors de la création du dossier '$segment' sur la plateforme cloud");
                Log::error($message . " : " . ($result['error'] ?? 'Résultat null'));
            } else {
                $message = "Erreur lors de la création du dossier '$segment' sur la plateforme cloud";
                Log::error($message . " : Résultat non réussi");
            }

            if(!$result || $result['success'] === false) {
                return [
                    'success' => false,
                    'message' => $message,
                    'cloudFolder' => null,
                ];
            }
            
            $newFolder = $this->cloudFolderService->createCloudFolder([
                'cloud_platform_id' => $cloudPlatform->id,
                'folder_name'       => $segment,
                'path'              => $currentPath, // chemin du PARENT au moment de la création
                'folder_id'         => $result['folder_id'] ?? null,
                'metadata'          => $result ?? null,
                'cloud_folder_id'   => $parentFolder?->id ?? null,
            ]);

            // Mettre à jour currentPath APRÈS la création
            $currentPath    = $currentPath ? $currentPath . '/' . $segment : $segment;
            $parentFolder   = $newFolder;
            $parentFolderId = $newFolder->folder_id;
        }

        // Dossier final "photos"
        $result = $this->cloudFileService->getOrCreateFolder(
            $finalFolderName,
            $cloudPlatform->toArray(),
            $parentFolderId,
        );

        if(!$result || $result['success'] === false) {
            Log::error("Erreur lors de la création du dossier '$finalFolderName' : " . ($result['error'] ?? 'Résultat null'));

            $errorDetails = null;
            if(isset($result['error'])) {
                $errorDetails = json_decode($result['error'], true);
                $message = 'Dossier ' . $finalFolderName . ' : ' . ($errorDetails['errors']['name'] ?? "Erreur lors de la création du dossier '$finalFolderName' sur la plateforme cloud");
                Log::error($message . " : " . ($result['error'] ?? 'Résultat null'));
            } else {
                $message = "Erreur lors de la création du dossier '$finalFolderName' sur la plateforme cloud";
                Log::error($message . " : Résultat non réussi");
            }

            return [
                'success' => false,
                'message' => $message,
                'cloudFolder' => null,
            ];
        }

        $cloudFolder = $this->cloudFolderService->createCloudFolder([
            'folder_name'       => $finalFolderName,
            'cloud_platform_id' => $cloudPlatform->id,
            'path'              => $currentPath, // = "moniras/meli'Glow/others/all/users/images"
            'folder_id'         => $result['folder_id'] ?? null,
            'metadata'          => $result ?? null,
            'cloud_folder_id'   => $parentFolder?->id ?? null,
        ]);

        return [
            'success' => true,
            'message' => "Dossier '$finalFolderName' créé avec succès sur la plateforme cloud",
            'cloudFolder' => $cloudFolder,
        ];

    }

    private function getCloudFolder($validatedData, $cloudPlatform, $model): Array
    {
        // Déterminer le chemin et le nom du dossier final en fonction du type de modèle et du type de média
        $finalFolderName = null;
        $path = null;

         // Récupérer ou créer le dossier cloud correspondant à ce type de modèle et ce type de média sur la plateforme cloud,
        if($validatedData['model_type'] == 'App\Models\User' || $validatedData['model_type'] == 'App\Models\ProductCategory' || $validatedData['model_type'] == 'App\Models\Product') {

            if($validatedData['file_type'] == 'images') {

                // Pour les images des utilisateurs, le dossier final sera "photos" dans "moniras/meli'Glow/others/all/users/images"
                if($validatedData['model_type'] == 'App\Models\User') {
                    $finalFolderName = 'photos';
                    $path = "moniras/meli'Glow/others/all/users/images";
                    
                    // Traitement des noms de fichiers pour éviter les conflits sur Drime : on peut ajouter un préfixe unique basé sur le modèle et son token, ainsi qu'un timestamp, 
                    // pour garantir que le nom du fichier est unique sur Drime, même si plusieurs modèles  ont des fichiers avec le même nom d'origine.
                    $custom_name = 'userId-' . $model->id . '_' . 'userToken-' . $model->token . '_' . 'time-' . time(); // Exemple de nom personnalisé : "userId-123_userToken-4d78e7f1f2_time-789456123"
                }
                // Pour les images des catégories de produits, le dossier final sera "images" dans "moniras/meli'Glow/others/all/products/categorie"
                if($validatedData['model_type'] == 'App\Models\ProductCategory') {
                    $finalFolderName = 'images';
                    $path = "moniras/meli'Glow/others/all/products/categorie";

                    // Traitement des noms de fichiers pour éviter les conflits sur Drime : on peut ajouter un préfixe unique basé sur le modèle et son token, ainsi qu'un timestamp, 
                    // pour garantir que le nom du fichier est unique sur Drime, même si plusieurs modèles  ont des fichiers avec le même nom d'origine.
                    $custom_name = 'productCategoryId-' . $model->id . '_' . 'productCategoryToken-' . $model->token . '_' . 'time-' . time(); 
                }
                // Pour les images des produits, le dossier final sera "images" dans "moniras/meli'Glow/others/all/products/product"
                if($validatedData['model_type'] == 'App\Models\Product') {
                    $finalFolderName = 'images';
                    $path = "moniras/meli'Glow/others/all/products/product";

                    // Traitement des noms de fichiers pour éviter les conflits sur Drime : on peut ajouter un préfixe unique basé sur le modèle et son token, ainsi qu'un timestamp, 
                    // pour garantir que le nom du fichier est unique sur Drime, même si plusieurs modèles  ont des fichiers avec le même nom d'origine.
                    $custom_name = 'productId-' . $model->id . '_' . 'productToken-' . $model->token . '_' . 'time-' . time(); 
                }

                // Déterminer le chemin et le nom du dossier final en fonction du type de modèle et du type de média
                $cloudFolder = $cloudPlatform->cloudFolders()->where('folder_name', $finalFolderName)->where('path', $path)->first();

                if($cloudFolder) {

                    // Si le dossier existe déjà, on retourne les détails du dossier cloud pour l'utiliser lors de l'upload du fichier vers Drime, 
                    // afin de spécifier le dossier de destination sur Drime pour ce type de média et ce type de modèle
                    $result = [
                        'success' => true,
                        'message' => "Dossier '$finalFolderName' trouvé avec succès sur la plateforme cloud",
                        'cloudFolder' => $cloudFolder,
                    ];
                    
                }else{    
                    // Si le dossier n'existe pas, on le crée (ainsi que tous les dossiers parents nécessaires) grâce à la méthode ensureCloudFolderExists qui va vérifier l'existence de chaque dossier parent un par un, 
                    // et les créer si nécessaire, avant de créer le dossier final "photos"
                    $result = $this->ensureCloudFolderExists($cloudPlatform, $path, $finalFolderName);
                }
                
            }
                
            if($validatedData['file_type'] == 'videos') {
                dd('Vidéo upload non implémenté pour les utilisateurs pour l\'instant');
            }

            if($validatedData['file_type'] == 'zip') {
                dd('Upload de zip non implémenté pour les utilisateurs pour l\'instant');
            }

            // Si le dossier cloud existe déjà, ou après l'avoir créé, on retourne les détails du dossier cloud pour l'utiliser lors de l'upload du fichier vers Drime, 
            // afin de spécifier le dossier de destination sur Drime pour ce type de média et ce type de modèle
            if(isset($result['success']) && $result['success'] === false) {
                return [
                    'success' => $result['success'],
                    'message' => $result['message'],
                    'cloudFolder' => $result['cloudFolder'] ?? null,
                    'custom_name' => $custom_name,
                ];
            }elseif(isset($result['success']) && $result['success'] === true) {
                return [
                    'success' => $result['success'],
                    'message' => $result['message'],
                    'cloudFolder' => $result['cloudFolder'] ?? null,
                    'custom_name' => $custom_name,
                ];
            }else{
                return [
                    'success' => false,
                    'message' => "Résultat inattendu lors de la vérification/création du dossier cloud",
                    'cloudFolder' => null,
                    'custom_name' => $custom_name,
                ];
            }

        }else{
            return [
                'success' => false,
                'message' => "Aucun dossier cloud défini pour ce type de modèle et ce type de média",
                'cloudFolder' => null,
                'custom_name' => null,
            ];
        }
    }

}
