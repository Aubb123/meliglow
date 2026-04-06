@extends('backend/layouts/app')

@section('title')
    dashboard/users/index
@endsection()

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            @include('backend/layouts/includes/users/backend-pages-users-index-table')
        </div>
    </div>
    <!-- / Content -->
@endsection()

