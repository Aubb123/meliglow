<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class CategorieController extends Controller
{
    // Fonction backend ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// Fonction backend ////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// Fonction backend ///////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// Fonction backend ///////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// Fonction backend ///////////////////////////////

    public function backend_categories_index(): View
    {
        $categories = Categorie::get();
        return view('backend/pages/categories/index', compact('categories'));
    }

    public function backend_categories_create(): View
    {
        return view('backend/pages/categories/create');
    }

    public function backend_categories_store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'min:2', 'max:100', 'unique:categories,name'],
            'description' => ['required', 'string', 'min:5'],
            'path_img' => ['required', 'image', 'mimes:png,jpg', 'max:5000'],
        ]);

        if($request->hasFile('path_img')) {

            // Générer un nom de fichier unique basé sur la date et l'heure
            $path_img = Str::random(50);
            $fileName = "image_du_" . getDateTime()->format('d_M_Y-H_i_s') . "_" . $path_img . "." . $validatedData['path_img']->getClientOriginalExtension();

            // Stocker le fichier avec le nouveau nom dans le dossier spécifié
            $filepath_img = Storage::disk('public')->putFileAs('others/all/categories/images', $validatedData['path_img'], $fileName);

        }else{
            return redirect()->back()->with('error', "Erreur, Image requis");
        }

        $token = Str::random(10);
        while(Categorie::where('token', $token)->exists()) {
            $token = Str::random(10);
        }

        $categorie = Categorie::create([  
            'name' => $validatedData['name'],
            'token' => $token,
            'path_img' => $filepath_img, 
            'description' => $validatedData['description'], 
            'created_at' => getDateTime(), 
            'updated_at' => getDateTime(), 
        ]);

        return redirect()->route('backend.categories.show', $categorie->token)->with('success', 'Catégorie créer avec succès');
    }

    public function backend_categories_show($token): View
    {  
        $categorie = Categorie::where('token', $token)->firstOrFail();
        
        return view('backend/pages/categories/show', compact('categorie'));
    }

    public function backend_categories_edit($token): View
    {  
        $categorie = Categorie::where('token', $token)->firstOrFail();
        return view('backend/pages/categories/edit', compact('categorie'));
    }

    public function backend_categories_update(Request $request, $token): RedirectResponse
    {   
        $categorie = Categorie::where('token', $token)->firstOrFail();

            $validatedData = $request->validate([
                'name' => ['required', 'min:2', 'max:100', 'unique:categories,name,'.$categorie->id],
                'description' => ['required', 'string'],
                'path_img' => ['nullable', 'image', 'mimes:png,jpg', 'max:5000'],
            ]);

            if($request->hasFile('path_img')) {
                // Générer un nom de fichier unique basé sur la date et l'heure
                $path_img = Str::random(50);
                $fileName = "image_du_" . getDateTime()->format('d_M_Y-H_i_s') . "_" . $path_img . "." . $validatedData['path_img']->getClientOriginalExtension();

                // Stocker le fichier avec le nouveau nom dans le dossier spécifié
                $filepath_img = Storage::disk('public')->putFileAs('others/all/categories/images', $validatedData['path_img'], $fileName);

                // Suppression de l'ancienne image
                if ($categorie->path_img && $categorie->path_img !== 'others/all/categories/images/default.jpg') {
                    Storage::disk('public')->delete($categorie->path_img);
                }
            }else{
                $filepath_img = $categorie->path_img;
            }

            Categorie::where('id', $categorie->id)->where('token', $token)->update([  
                'name' => $validatedData['name'],
                'path_img' => $filepath_img,  
                'description' => $validatedData['description'], 
                'updated_at' => getDateTime(), 
            ]);

        return redirect()->route('backend.categories.show', $categorie->token)->with('success', 'Catégorie mise à jour avec succès');
    }

    public function backend_categories_destroy($token): RedirectResponse 
    {
        // Recherche de la catégorie à supprimer en utilisant le token
        $categorie = Categorie::where('token', $token)->first();

        if($categorie){
            // Si aucun blog et formation n'est liée à la catégorie
            if($categorie->blogs->count() == 0){
               //Suppression
                destroy_function($categorie, 'Catégories');

                return redirect()->route('backend.categories.index')->with('success', "Catégorie supprimer avec succès");
            }else{
                return redirect()->back()->with('warning', "Veuillez supprimer les blogs liées à cette catégorie avant de procéder à la suppression de la catégorie");
            }
        }else{
            return redirect()->back()->with('error', 'Catégorie non trouvée.');
        }
        
    }

    // ...
    
    public function backend_categories_blogs($token): View
    {  
        $categorie = Categorie::where('token', $token)->firstOrFail();
        $blogs = $categorie->blogs;

        return view('backend/pages/categories/others/blogs', compact('categorie', 'blogs'));
    }

}
