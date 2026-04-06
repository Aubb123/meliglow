@extends('backend/layouts/app')

@section('title') Roles - Liste @endsection()

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            @include('backend/layouts/includes/roles/backend-pages-roles-index-table')
        </div>
    </div>
    <!-- / Content -->
@endsection()

