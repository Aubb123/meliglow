<?php

namespace App\Http\Controllers;

use App\Models\CloudPlatform;
use Illuminate\View\View;

class CloudPlatformController extends Controller
{

    public function backend_cloud_platforms_index(): View
    {
        $cloudPlatforms = CloudPlatform::get();

        return view('backend/pages/cloud_platforms/index', compact('cloudPlatforms'));
    }

    public function backend_cloud_platforms_show($token): View
    {
        $platform = CloudPlatform::where('token', $token)->firstOrFail();

        return view('backend/pages/cloud_platforms/show', compact('platform'));
    }

    public function backend_cloud_platforms_cloud_folders($token): View
    {
        // Récupérer la plateforme cloud à partir du token
        $platform = CloudPlatform::where('token', $token)->firstOrFail();

        // Récupérer les dossiers cloud associés à la plateforme cloud, en filtrant pour n'obtenir que les dossiers racines (ceux qui n'ont pas de cloud_folder_id)
        // $cloudFolders = $platform->cloudFolders()->whereNull('cloud_folder_id')->get();
        $cloudFolders = $platform->cloudFolders()->get();

        return view('backend/pages/cloud_platforms/cloud_folders/index', compact('platform', 'cloudFolders'));
    }

    // Fonction Helper ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// Fonction Helper ////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// Fonction Helper ///////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// Fonction Helper ///////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// Fonction Helper ///////////////////////////////

    // Fonction pour récupérer $cloudPlatforms
    public static function getCloudPlatforms()
    {
        $cloudPlatforms = CloudPlatform::where('status', 'active')->get();
        return $cloudPlatforms;
    }
}
