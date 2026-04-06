@extends('backend/layouts/app')

@section('title')
    dashboard - produits
@endsection()

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            @include('backend/layouts/includes/products/product/_backend-pages-products-index-table', ['products' => $products])
        </div>
    </div>
    <!-- / Content -->
@endsection()

