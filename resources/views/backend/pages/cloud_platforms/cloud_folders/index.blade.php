@extends('backend/layouts/app')

@section('title')
    Cloud Platforms - Dossiers
@endsection()

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
   
    @include('backend/layouts/includes/cloud_platforms/_show-header', ['platform' => $platform])

    <div class="row g-4">
        <!-- Contenu principal -->
        <div class="col-12">
            <div class="card">
                @include('backend/layouts/includes/cloud_platforms/cloud_folders/_backend-pages-cloud_folders-index-table', ['cloud_folders' => $cloudFolders, 'platform' => $platform])
            </div>
        </div>

    </div>
</div>
<!-- / Content -->
@endsection()