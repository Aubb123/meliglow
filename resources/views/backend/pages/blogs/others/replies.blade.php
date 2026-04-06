@extends('backend/layouts/app')

@section('title')
    dashboard/blogs/replies
@endsection()

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12 col-lg-12 mb-3">

            @include('backend/layouts/includes/blogs/backend-pages-blogs-show-navbar')

            <div class="col-lg-12">
                <div class="card">
                    @include('backend/layouts/includes/replies/backend-pages-replies-index-table')
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection()