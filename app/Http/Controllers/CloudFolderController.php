<?php

namespace App\Http\Controllers;

use App\Models\CloudFolder;
use App\Models\CloudPlatform;
use App\Services\CloudFileService;
use App\Services\CloudFolderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CloudFolderController extends Controller
{
    // CloudFolderService est injecté dans le constructeur pour être utilisé dans les méthodes du contrôleur
    protected CloudFolderService $cloudFolderService;
    protected CloudFileService $cloudFileService;

    // __construct est utilisé pour injecter le CloudFolderService dans le contrôleur, permettant ainsi d'utiliser ses méthodes pour gérer les dossiers cloud dans les différentes actions du backend.
    public function __construct(CloudFolderService $cloudFolderService, CloudFileService $cloudFileService)
    {
        $this->cloudFolderService = $cloudFolderService;
        $this->cloudFileService = $cloudFileService;
    }

    public function backend_cloud_folders_create($cloudPlatformToken): View
    {
        // Récupérer la plateforme cloud à partir du token
        $platform = CloudPlatform::where('token', $cloudPlatformToken)->firstOrFail();
        
        return view('backend/pages/cloud_platforms/cloud_folders/create', compact('platform'));
    }

    public function backend_cloud_folders_store(Request $request, $cloudPlatformToken): RedirectResponse
    {
        // Récupérer la plateforme cloud via son token
        $platform = CloudPlatform::where('token', $cloudPlatformToken)->firstOrFail();

        // Validation
        $validatedData = $request->validate([
            // minuscules, chiffres, tirets et underscores, sans espace,
            'folder_name' => ['required','string','max:25','regex:/^[a-z0-9_\-]+$/'],
            'cloud_folder_token' => ['nullable', 'string', 'max:255', 'exists:cloud_folders,token'],
        ], [
            'folder_name.regex'    => 'Le nom du dossier doit être en minuscule, sans espace, et ne contenir que des lettres, chiffres, tirets ou underscores.',
        ]);

        // $path est construit en remontant la hiérarchie des dossiers parents jusqu'à la racine, en concaténant les noms de dossiers pour former le chemin complet du dossier à créer. 
        // Si le dossier n'a pas de parent, le chemin sera simplement null ou vide.
        $path = null;

        // Si un token de dossier parent est fourni
        if(isset($validatedData['cloud_folder_token'])) {

            // Récupérer le dossier parent à partir du token pour construire le chemin du dossier à créer sur la plateforme cloud. 
            // Cela permet de s'assurer que le dossier est créé au bon endroit dans la hiérarchie des dossiers sur la plateforme cloud, 
            // même si le token du dossier parent est optionnel pour la création du dossier dans la base de données.
            $cloudFolder = CloudFolder::where('token', $validatedData['cloud_folder_token'])->first();

            // Si un token de dossier parent est fourni, récupérer le dossier parent et construire le chemin
            if ($cloudFolder) {
                $path = $cloudFolder->folder_name; // Commence par le nom du dossier parent
            }

            // Remonter la hiérarchie des dossiers parents pour construire le chemin complet
            while ($cloudFolder) {
                $parentFolder = $cloudFolder->parentFolder;
                if (!$parentFolder) {
                    break; // Si on atteint un dossier racine, on arrête la boucle
                }
                $path = $parentFolder->folder_name . '/' . $path;
                $cloudFolder = $parentFolder;
            }
        }

        // Récupérer le dossier parent à partir du token (si fourni) de nouveau pour l'associer au dossier à créer dans la base de données, 
        // même si on a déjà construit le chemin pour la création du dossier sur la plateforme cloud. Cela permet d'avoir une référence claire du dossier parent dans la base de données, 
        // indépendamment de la construction du chemin pour la plateforme cloud.
        $cloudFolder = CloudFolder::where('token', $validatedData['cloud_folder_token'])->first();
        
        if($cloudFolder){
            $folder_id = $cloudFolder->folder_id; // ID du dossier parent sur la plateforme cloud
        }else{
            $folder_id = null; // Pas de dossier parent
        }

        // dd($platform->toArray());

        // Créer le dossier sur le cloud via le service $cloudFileService 
        $result = $this->cloudFileService->getOrCreateFolder($validatedData['folder_name'], $platform->toArray(), $folder_id ?? null);

        // Si la création du dossier sur la plateforme cloud a échoué, rediriger avec une erreur
        if(!$result) {
            return redirect()->back()->with('error', "Erreur lors de la création du dossier sur la plateforme cloud");
        }

        // Si la création du dossier sur la plateforme cloud n'a pas réussi (ex: le dossier existe déjà), rediriger avec une erreur
        if($result['success'] === false) {
            $errorDetails = json_decode($result['error'], true);

            if($errorDetails === null){
                return redirect()->back()->with('error', $result['error']);
            }

            return redirect()->back()->with('error', $errorDetails['errors']['name']);
        }

        // Préparer les données pour la création du dossier cloud
        $validatedData['cloud_platform_id'] = $platform->id;
        $validatedData['path'] = $path ?? null; // Chemin du dossier parent s'il existe, sinon null
        $validatedData['folder_id'] = $result['folder_id'] ?? null; // ID du dossier sur la plateforme cloud
        $validatedData['metadata'] = $result ?? null; // Stocker les métadonnées brutes de la réponse de la plateforme cloud (optionnel)
        $validatedData['cloud_folder_id'] = isset($cloudFolder) ? $cloudFolder->id : null; // Token du dossier parent (optionnel)

        // Création du dossier
        $folder = $this->cloudFolderService->createCloudFolder($validatedData);

        return redirect()->route('backend.cloud_folders.show', ['token' => $folder->token])->with('success', 'Dossier "' . $validatedData['folder_name'] . '" créé avec succès.');
    }

    public function backend_cloud_folders_show($token)
    {
        // Récupérer le dossier cloud à partir du token
        $folder = CloudFolder::where('token', $token)->firstOrFail();

        // Récupérer les sous-dossiers du dossier actuel pour les afficher dans la vue
        $cloudFolders = CloudFolder::where('cloud_folder_id', $folder->id)->get();

        $platform = $folder->cloudPlatform; // Récupérer la plateforme cloud associée au dossier

        return view('backend/pages/cloud_platforms/cloud_folders/show', compact('folder', 'cloudFolders', 'platform'));
    }

    public function backend_cloud_folders_destroy($token, Request $request): RedirectResponse
    {
        // Récupérer le dossier cloud à partir du token
        $cloudFolder = CloudFolder::where('token', $token)->firstOrFail();

        // Validation
        $validatedData = $request->validate([
            'delete_forever' => ['required', 'boolean', 'in:0,1'],
        ]);

        if($validatedData['delete_forever'] === '1') {
            $validatedData['delete_forever'] = true;
        } else {
            $validatedData['delete_forever'] = false;
        }

        // Appeler la méthode de suppression du dossier cloud dans le service
        $deletionResult = $this->cloudFolderService->deleteCloudFolder($cloudFolder, $validatedData['delete_forever']);

        if ($deletionResult['success']) {
            return redirect()->route('backend.cloud_platforms.show', ['token' => $cloudFolder->cloudPlatform->token])->with('success', $deletionResult['message']);
        } else {
            return redirect()->back()->with('error', $deletionResult['message']);
        }
    }


}
