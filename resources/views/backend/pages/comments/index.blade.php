@extends('backend/layouts/app')

@section('title')
    dashboard/comments/index
@endsection()

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            @include('backend/layouts/includes/comments/backend-pages-comments-index-table')
        </div>
    </div>
    <!-- / Content -->
@endsection()

