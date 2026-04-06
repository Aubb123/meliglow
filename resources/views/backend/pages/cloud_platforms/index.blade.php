@extends('backend/layouts/app')

@section('title')
    Cloud Platforms - Index
@endsection()

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            @include('backend/layouts/includes/cloud_platforms/_backend-pages-cloud_platforms-index-table')
        </div>
    </div>
    <!-- / Content -->
@endsection()

