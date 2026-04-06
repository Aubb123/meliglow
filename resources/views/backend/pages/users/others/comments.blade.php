@extends('backend/layouts/app')

@section('title')
dashboard/users/comments
@endsection()

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-3 col-lg-4 col-md-4 order-1 order-md-0">
            <!-- Activity Timeline -->
            @include('backend/layouts/includes/users/backend-pages-users-show-aside')
            <!-- /Activity Timeline -->
        </div>
        <!--/ User Sidebar -->

        <!-- User Content -->
        <div class="col-xl-9 col-lg-8 col-md-8 order-0 order-md-1">
            <!-- User Card -->
            <div class="card mb-6">
                @include('backend/layouts/includes/comments/backend-pages-comments-index-table')
            </div>
            <!-- /User Card -->
        </div>
        <!--/ User Content -->
    </div>
</div>
<!-- / Content -->
@endsection()