@extends('frontend/layouts/master')

@section('title', 'Liste des produits - Résultats de recherche')

@section('content')

    @include('frontend/layouts/partials/_breadcrumb', ['title' => 'Liste des produits - Résultats de recherche'])

    @include('frontend/layouts/includes/products/product/_product_list', ['products' => $products, 'productCategories' => $productCategories])

@endsection