<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductCategoryController extends Controller
{

    // Function backend ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// Function backend ////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// Function backend ///////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// Function backend ///////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// Function backend ///////////////////////////////

    /**
     * Lister toutes les catégories
     */
    public function backend_product_categories_index(): View
    {
        $categories = ProductCategory::withCount('products')->orderBy('id')->get();

        return view('backend/pages/products/categorie/index', compact('categories'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function backend_product_categories_create(): View
    {
        return view('backend/pages/products/categorie/create');
    }

    /**
     * Enregistrer une nouvelle catégorie
     */
    public function backend_product_categories_store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:product_categories,name',
            'description' => 'nullable|string',
        ]);

        $category = ProductCategory::create([
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'created_at'  => getDateTime(),
            'updated_at'  => getDateTime(),
        ]);

        return redirect()->route('backend.product_categories.show', ['token' => $category->token])->with('success', 'Catégorie créée avec succès.');
    }

    /**
     * Afficher le détail d'une catégorie
     */
    public function backend_product_categories_show(string $token)
    {
        $category = ProductCategory::where('token', $token)->withCount('products')->firstOrFail();
        $products = $category->products()->orderBy('id', 'asc')->get();

        return view('backend/pages/products/categorie/show', compact('category', 'products'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function backend_product_categories_edit(string $token)
    {
        $category = ProductCategory::where('token', $token)->firstOrFail();

        return view('backend/pages/products/categorie/edit', compact('category'));
    }

    /**
     * Mettre à jour une catégorie
     */
    public function backend_product_categories_update(Request $request, string $token)
    {
        $category = ProductCategory::where('token', $token)->firstOrFail();

        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:product_categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'updated_at'  => getDateTime(),
        ]);

        return redirect()->route('backend.product_categories.show', ['token' => $category->token])->with('success', 'Catégorie mise à jour avec succès.');
    }

    /**
     * Supprimer une catégorie (Admin & Développeur uniquement)
     */
    public function backend_product_categories_destroy(string $token)
    {
        $category = ProductCategory::where('token', $token)->firstOrFail();

        // Vérifier si la catégorie contient des produits
        if ($category->products()->count() > 0) {
            return redirect()->route('backend.product_categories.index')->with('error', 'Impossible de supprimer cette catégorie car elle contient des produits.');
        }

        destroy_function($category);

        return redirect()->route('backend.product_categories.index')->with('success', 'Catégorie supprimée avec succès.');
    }

    /**
     * Lister les produits d'une catégorie
     */
    public function backend_product_categories_products(string $token)
    {
        $category = ProductCategory::where('token', $token)->firstOrFail();

        $products = $category->products()->orderBy('id', 'desc')->get();

        return view('backend/pages/products/categorie/products', compact('category', 'products'));
    }

    // Function frontend ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// Function frontend ////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// Function frontend ///////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// Function frontend ///////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// Function frontend ///////////////////////////////

    public function frontend_product_categories_show(string $token): View
    {
        $categ = ProductCategory::where('token', $token)->firstOrFail();

        $products = $categ->products()->where('is_visible', true)->orderBy('id', 'desc')->paginate(15);

        // Récupérer les catégories qui ont au moins un produit visible
        $productCategories = ProductCategory::whereHas('products', function ($query) {
            $query->where('is_visible', true);
        })->get();

        return view('frontend/pages/products/categorie/show', compact('categ', 'products', 'productCategories'));
    }

}

