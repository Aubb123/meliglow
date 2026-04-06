@extends('backend/layouts/app')

@section('title')
    dashboard/continents/show
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
                        <!-- En-tête -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h2 class="fw-bold text-dark mb-0">{{ $continent->name }}</h2>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fs-5">
                                    {{ $continent->code }}
                                </span>
                            </div>
                            
                            <!-- Statut d'activation -->
                            <div class="mb-3">
                                @if($continent->is_active)
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Continent actif
                                    </span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">
                                        <i class="fas fa-times-circle me-1"></i>
                                        Continent inactif
                                    </span>
                                @endif
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill ms-2">
                                    <i class="fas fa-sort me-1"></i>
                                    Ordre: {{ $continent->sort_order }}
                                </span>
                            </div>
                        </div>

                        <!-- Image principale -->
                        @if($continent->path_img)
                            <div class="mb-4">
                                <div class="position-relative">
                                    <img src="{{ asset(getEnvFolder() . $continent->path_img) }}" alt="{{ $continent->name }}" class="img-fluid rounded-3 shadow-sm w-100" style="max-height: 500px; object-fit: cover;">
                                </div>
                            </div>
                        @endif

                        <!-- Description -->
                        @if($continent->description)
                            <div class="mb-4">
                                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                                    <i class="fas fa-align-left me-2 text-primary"></i>
                                    Description
                                </h6>
                                <div class="bg-light rounded-3 p-4">
                                    <p class="mb-0 text-muted">{{ $continent->description }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Informations géographiques et démographiques -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                                <i class="fas fa-globe me-2 text-primary"></i>
                                Informations géographiques et démographiques
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="bg-info bg-opacity-10 rounded-3 p-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="avatar avatar-sm me-3">
                                                <div class="avatar-initial bg-info text-white rounded">
                                                    <i class="fas fa-users"></i>
                                                </div>
                                            </div>
                                            <h6 class="mb-0 text-muted">Population</h6>
                                        </div>
                                        <h4 class="mb-0 fw-bold text-info">
                                            {{ $continent->population ? number_format($continent->population, 0, ',', ' ') : 'Non renseigné' }}
                                        </h4>
                                        @if($continent->population)
                                            <small class="text-muted">habitants</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-success bg-opacity-10 rounded-3 p-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="avatar avatar-sm me-3">
                                                <div class="avatar-initial bg-success text-white rounded">
                                                    <i class="fas fa-map"></i>
                                                </div>
                                            </div>
                                            <h6 class="mb-0 text-muted">Superficie</h6>
                                        </div>
                                        <h4 class="mb-0 fw-bold text-success">
                                            {{ $continent->area ? number_format($continent->area, 2, ',', ' ') : 'Non renseigné' }}
                                        </h4>
                                        @if($continent->area)
                                            <small class="text-muted">km²</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Calcul de densité si données disponibles -->
                        @if($continent->population && $continent->area && $continent->area > 0)
                            <div class="alert alert-info d-flex align-items-center" role="alert">
                                <i class="fas fa-calculator me-2"></i>
                                <div>
                                    <strong>Densité de population :</strong> 
                                    {{ number_format($continent->population / $continent->area, 2, ',', ' ') }} habitants/km²
                                </div>
                            </div>
                        @endif

                        <!-- Actions rapides -->
                        <div class="border-top pt-4">
                            <div class="row g-3">
                                <div class="col-sm-6 col-lg-4">
                                    <div class="d-grid">
                                        <a href="{{ route('backend.continents.edit', $continent->token) }}" 
                                        class="btn btn-outline-primary d-flex align-items-center justify-content-center">
                                            <i class="fas fa-edit me-2"></i>
                                            Modifier
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="d-grid">
                                        <a href="{{ route('backend.continents.index') }}" 
                                        class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                            <i class="fas fa-list me-2"></i>
                                            Liste
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="d-grid">
                                        <button type="button" 
                                                class="btn btn-outline-danger d-flex align-items-center justify-content-center"
                                                onclick="confirmDelete('{{$continent->token}}', 'Êtes-vous sûr de vouloir supprimer ce continent ?')">
                                            <i class="fas fa-trash me-2"></i>
                                            Supprimer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
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