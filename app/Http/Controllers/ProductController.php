<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Lister tous les produits
     */
    public function backend_products_index(): View
    {
        $products = Product::orderBy('id', 'asc')->get();

        return view('backend/pages/products/product/index', compact('products'));
    }

    /**
     * Afficher le détail d'un produit
     */
    public function backend_products_show(string $token): View
    {
        $product = Product::where('token', $token)->firstOrFail();

        // Vérifier si l'utilisateur est authentifié
        // if (auth()->check()) {
        //     // Utiliser le token utilisateur au lieu du name (plus fiable et unique)
        //     $key = 'user_' . auth()->user()->token . '_product_viewed_' . $product->token;

        //     // Vérifier si ce produit a déjà été vu par cet utilisateur
        //     if (!session()->has($key)) {
        //         // Incrémenter le compteur de vues
        //         $product->increment('views');
        //         // Marquer ce produit comme vu dans la session
        //         session([$key => true]);
        //     }

        // } else {
        //     // Cas des invités (non authentifiés)
        //     // On utilise l'adresse IP pour limiter les incréments multiples
        //     $key = 'guest_' . request()->ip() . '_product_viewed_' . $product->token;

        //     if (!session()->has($key)) {
        //         $product->increment('views');
        //         session([$key => true]);
        //     }
        // }

        return view('backend/pages/products/product/show', compact('product'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function backend_products_create($categorie_token): View
    {
    
        // Récupérer la catégorie par son token
        $category = ProductCategory::where('token', $categorie_token)->firstOrFail();

        return view('backend/pages/products/product/create', compact('category'));
    }

    /**
     * Enregistrer un nouveau produit
     */
    public function backend_products_store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_categorie_token' => 'required|exists:product_categories,token',
            'name'                 => 'required|string|max:255',
            'description'          => 'required|string',
            'purchase_price'       => 'required|numeric|min:0',
            'sale_price'           => 'required|numeric|min:0|gte:purchase_price',
            'promotional_price'    => 'nullable|numeric|min:0|lt:sale_price',
            'stock'                => 'required|integer|min:0',
            'is_visible'           => 'boolean',
        ]);

        // Récupérer la catégorie par son token
        $category = ProductCategory::where('token', $validated['product_categorie_token'])->firstOrFail();

        $product = Product::create([
            'user_id'              => $request->user()->id,
            'product_categorie_id' => $category->id,
            'name'                 => $validated['name'],
            'description'          => $validated['description'],
            'purchase_price'       => $validated['purchase_price'],
            'sale_price'           => $validated['sale_price'],
            'promotional_price'    => $validated['promotional_price'] ?? null,
            'stock'                => $validated['stock'],
            'is_visible'           => $request->boolean('is_visible'),
            'created_at'          => getDateTime(),
            'updated_at'          => getDateTime(),
        ]);

        return redirect()->route('backend.products.show', ['token' => $product->token])->with('success', 'Produit créé avec succès.');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function backend_products_edit(string $token): View
    {
        $product = Product::where('token', $token)->firstOrFail();
        $category = $product->category; // Récupérer la catégorie associée au produit

        return view('backend/pages/products/product/edit', compact('product', 'category'));
    }

    /**
     * Mettre à jour un produit
     */
    public function backend_products_update(Request $request, string $token)
    {
        $product = Product::where('token', $token)->firstOrFail();

        $validated = $request->validate([
            'name'                 => 'required|string|max:255',
            'description'          => 'required|string',
            'purchase_price'       => 'required|numeric|min:0',
            'sale_price'           => 'required|numeric|min:0|gte:purchase_price',
            'promotional_price'    => 'nullable|numeric|min:0|lt:sale_price',
            'stock'                => 'required|integer|min:0',
            'is_visible'           => 'boolean',
        ]);

        $product->update([
            'name'                 => $validated['name'],
            'description'          => $validated['description'],
            'purchase_price'       => $validated['purchase_price'],
            'sale_price'           => $validated['sale_price'],
            'promotional_price'    => $validated['promotional_price'] ?? null,
            'stock'                => $validated['stock'],
            'is_visible'           => $request->boolean('is_visible'),
            'updated_at'          => getDateTime(),
        ]);

        return redirect()->route('backend.products.show', ['token' => $product->token])->with('success', 'Produit mis à jour avec succès.');
    }

    /**
     * Supprimer un produit (Admin & Développeur uniquement)
     */
    public function backend_products_destroy(string $token)
    {
        $product = Product::where('token', $token)->firstOrFail();

        if($product->is_visible) {
            return redirect()->route('backend.products.show', ['token' => $product->token])->with('error', 'Vous ne pouvez pas supprimer un produit publié. Veuillez d\'abord le mettre en brouillon.');
        }

        destroy_function($product);

        return redirect()->route('backend.products.index')->with('success', 'Produit supprimé avec succès.');
    }

    public function backend_products_featured(string $token): RedirectResponse
    {
        $product = Product::where('token', $token)->firstOrFail();

        // Compter le nombre de produits actuellement mis en avant
        $featuredCount = Product::where('is_featured', true)->count();

        // Si le produit n'est pas encore mis en avant et que la limite de 4 produits est atteinte, afficher une erreur
        if (!$product->is_featured && $featuredCount >= 4) {
            return redirect()->route('backend.products.show', ['token' => $product->token])->with('error', 'Vous ne pouvez pas mettre en avant plus de 4 produits. Veuillez d\'abord retirer un produit de la mise en avant.');
        }

        // Toggle le statut "En avant" du produit
        $product->is_featured = !$product->is_featured; // Toggle la valeur
        $product->updated_at = getDateTime(); // Mettre à jour la date de modification
        $product->save();

        return redirect()->route('backend.products.show', ['token' => $product->token])->with('success', 'Le statut "En avant" du produit a été mis à jour avec succès.');
    }

    // Function frontend ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// Function frontend ////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// Function frontend ///////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// Function frontend ///////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// Function frontend ///////////////////////////////

    public function frontend_products_index(): View
    {
        // Récupérer uniquement les produits visibles, triés du plus récent au plus ancien, avec pagination
        $products = Product::where('is_visible', true)->orderBy('id', 'desc')->paginate(15);

        // Récupérer les catégories qui ont au moins un produit visible
        $productCategories = ProductCategory::whereHas('products', function ($query) {
            $query->where('is_visible', true);
        })->get();

        return view('frontend/pages/products/product/index', compact('products', 'productCategories'));
    }

    public function frontend_products_show(string $token): View|RedirectResponse
    {
        $product = Product::where('token', $token)->firstOrFail();

            // Vérifier si le produit est visible
            if (!$product->is_visible) {
                return abort(404);
            }
    
            // Vérifier si l'utilisateur est authentifié
            if (auth()->check()) {
                // Utiliser le token utilisateur au lieu du name (plus fiable et unique)
                $key = 'user_' . auth()->user()->token . '_product_viewed_' . $product->token;

                // Vérifier si ce produit a déjà été vu par cet utilisateur
                if (!session()->has($key)) {
                    // Incrémenter le compteur de vues
                    $product->increment('views');
                    // Marquer ce produit comme vu dans la session
                    session([$key => true]);
                }

            } else {
                // Cas des invités (non authentifiés)
                // On utilise l'adresse IP pour limiter les incréments multiples
                $key = 'guest_' . request()->ip() . '_product_viewed_' . $product->token;

                if (!session()->has($key)) {
                    $product->increment('views');
                    session([$key => true]);
                }
            }

            // Réucpérer les produits similaires (même catégorie, visibles, sauf le produit actuel)
            $similarProducts = Product::where('product_categorie_id', $product->product_categorie_id)
                ->where('is_visible', true)
                ->where('id', '!=', $product->id)
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get();    
            
        // Afficher la page de détail du produit
        return view('frontend/pages/products/product/show', compact('product', 'similarProducts'));
    }

    public function frontend_products_search(Request $request): View|RedirectResponse
    {
        $query = $request->input('query');

        if (!$query) {
            return redirect()->back()->with('error', 'Veuillez entrer une requête de recherche.');
        }

        // Rechercher les produits visibles dont le nom ou la description correspond à la requête de recherche
        $products = Product::where('is_visible', true)->where(function ($q) use ($query) {
            $q->where('name', 'like', '%' . $query . '%')->orWhere('description', 'like', '%' . $query . '%');
        })->orderBy('id', 'desc')->paginate(15);

        // Récupérer les catégories qui ont au moins un produit visible
        $productCategories = ProductCategory::whereHas('products', function ($query) {
            $query->where('is_visible', true);
        })->get();

        return view('frontend/pages/products/product/search_results', compact('products', 'query', 'productCategories'));
    }


}
