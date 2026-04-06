@extends('backend/layouts/app')

@section('title')
    dashboard/contacts/index
@endsection()

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            @include('backend/layouts/includes/contacts/backend-pages-contacts-index-table')
        </div>
    </div>
    <!-- / Content -->
@endsection()

