 @extends('backend/layouts/app')

@section('title')
    dashboard-pays
@endsection()

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            @include('backend/layouts/includes/countries/backend-pages-countries-index-table')
        </div>
    </div>
    <!-- / Content -->
@endsection()

