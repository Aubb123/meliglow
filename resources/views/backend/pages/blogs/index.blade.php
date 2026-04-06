@extends('backend/layouts/app')

@section('title')
    dashboard/blogs/index
@endsection()

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            @include('backend/layouts/includes/blogs/backend-pages-blogs-index-table')
        </div>
    </div>
    <!-- / Content -->
@endsection()

