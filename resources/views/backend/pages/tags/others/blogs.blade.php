@extends('backend/layouts/app')

@section('title')
    dashboard/blogs/index
@endsection()

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="nav-align-top">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="card academy-content shadow-none border">
                        <div class="pt-3">
                            <div class="container">
                                <h5><b>Tag:</b> <span class="text-primary">{{$tag->name}}</span></h5>
                            </div>
                        </div>      
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            @include('backend/layouts/includes/blogs/backend-pages-blogs-index-table')
        </div>
    </div>
    <!-- / Content -->
@endsection()

