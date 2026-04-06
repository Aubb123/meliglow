@extends('backend/layouts/app')

@section('title')
    dashboard - catégories
@endsection()

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            @include('backend/layouts/includes/products/categorie/_backend-pages-categories-index-table')
        </div>
    </div>
    <!-- / Content -->
@endsection()

