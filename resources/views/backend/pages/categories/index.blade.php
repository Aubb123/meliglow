@extends('backend/layouts/app')

@section('title')
    dashboard/categories/index
@endsection()

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            @include('backend/layouts/includes/categories/backend-pages-categories-index-table')
        </div>
    </div>
    <!-- / Content -->
@endsection()

