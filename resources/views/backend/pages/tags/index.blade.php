@extends('backend/layouts/app')

@section('title')
    dashboard/tags/index
@endsection()

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            @include('backend/layouts/includes/tags/backend-pages-tags-index-table')
        </div>
    </div>
    <!-- / Content -->
@endsection()

