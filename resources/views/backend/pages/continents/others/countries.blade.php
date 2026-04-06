@extends('backend/layouts/app')

@section('title')
    Liste des pays du continent {{ $continent->name }}
@endsection()

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- En-tête de page -->
        @include('backend/layouts/includes/continents/backend-pages-continents-show-mini-topbar', ['continent' => $continent])

        <div class="row g-4">
            <!-- Contenu principal -->
            <div class="col-xl-8 col-lg-7">
                <!-- Carte principale du continent -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        @include('backend/layouts/includes/countries/backend-pages-countries-index-table')
                    </div>
                </div>
            </div>

            <!-- Sidebar d'informations -->
            <div class="col-xl-4 col-lg-5">
                @include('backend/layouts/includes/continents/backend-pages-continents-show-sidebar-informations', ['continent' => $continent])
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection()