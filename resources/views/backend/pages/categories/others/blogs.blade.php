@extends('backend/layouts/app')

@section('title')
dashboard/roles/blogs
@endsection()

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12 col-lg-12 mb-3">

            @include('backend/layouts/includes/categories/backend-pages-categories-show-navbar')

            <div class="col-lg-12">
                <div class="card">
                    @include('backend/layouts/includes/blogs/backend-pages-blogs-index-table')
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection()