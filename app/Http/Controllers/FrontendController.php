<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\View\View;

class FrontendController extends Controller
{
    public function frontend_index(): View
    {
        // Récupérer les catégories ayant des produits associés, en les triant de manière aléatoire et en limitant à 5
        $product_categories = ProductCategory::whereHas('products') // Assure que la catégorie a des produits associés
            ->inRandomOrder() // Trier de manière aléatoire
            ->limit(5) // Limiter à 5 catégories
            ->get();

        // Récupérer les produits par ordre de création (les plus récents en premier) et paginer les résultats (20 par page)
        $products = Product::where('is_visible', true)->orderBy('id', 'desc')->paginate(16);

        // Récupérer les produits mis en avant (featured) par ordre de création (les plus récents en premier) et limiter à 8
        $featured_products = Product::where('is_visible', true)->where('is_featured', true)->orderBy('id', 'desc')->limit(4)->get();

        // Retourner la vue avec les données
        return view('frontend/pages/welcome', compact('product_categories', 'products', 'featured_products'));
    }

    public function frontend_about(): View
    {
        return view('frontend/pages/about');
    }

    public function frontend_contact(): View
    {
        return view('frontend/pages/contact');
    }

    // Terms & Condition
    public function frontend_terms(): View
    {
        return view('frontend/pages/terms');
    }

    // Privacy Policy
    public function frontend_privacy(): View
    {
        return view('frontend/pages/privacy');
    }


}