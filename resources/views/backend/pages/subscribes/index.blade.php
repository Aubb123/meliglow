@extends('backend/layouts/app')

@section('title')
    dashboard/subscribes/index
@endsection()

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            @include('backend/layouts/includes/subscribes/backend-pages-subscribes-index-table')
        </div>
    </div>
    <!-- / Content -->
@endsection()

