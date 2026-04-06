@extends('frontend/layouts/master')

@section('title', 'Catégorie: ' . $categ->name)

@section('content')

    @include('frontend/layouts/partials/_breadcrumb', ['title' => 'Catégorie: ' . $categ->name])

    @include('frontend/layouts/includes/products/product/_product_list', ['products' => $products, 'productCategories' => $productCategories])

@endsection