@extends('backend/layouts/app')

@section('title')
    Continent List
@endsection()

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            @include('backend/layouts/includes/continents/backend-pages-continents-index-table')
        </div>
    </div>
    <!-- / Content -->
@endsection()

