@extends('backend/layouts/app')

@section('title')
    Cloud Platforms - Show
@endsection()

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
   
    @include('backend/layouts/includes/cloud_platforms/_show-header', ['platform' => $platform])

    <div class="row g-4">
        <!-- Contenu principal -->
        <div class="col-xl-8 col-lg-7">
            <!-- Détails de la plateforme -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <!-- En-tête -->
                    <div class="mb-4">
                        <h2 class="fw-bold text-dark mb-3">{{ $platform->name }}</h2>

                        <!-- Statut -->
                        <div class="mb-3">
                            @if($platform->status === 'active')
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Plateforme active
                                </span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">
                                    <i class="fas fa-times-circle me-1"></i>
                                    Plateforme inactive
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    @if($platform->description)
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                                <i class="fas fa-align-left me-2 text-primary"></i>
                                Description
                            </h6>
                            <div class="bg-light rounded-3 p-4">
                                <p class="mb-0">{{ $platform->description }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Informations API -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <i class="fas fa-plug me-2 text-primary"></i>
                            Informations API
                        </h6>
                        <div class="bg-light rounded-3 p-4">
                            <div class="row g-3">
                                <!-- API Endpoint -->
                                <div class="col-12">
                                    <label class="form-label small text-muted mb-1">API Endpoint</label>
                                    <p class="mb-0 fw-semibold">
                                        @if($platform->api_endpoint)
                                            <a href="{{ $platform->api_endpoint }}" target="_blank" class="text-primary text-decoration-none">
                                                <i class="fas fa-link me-1"></i>
                                                {{ $platform->api_endpoint }}
                                            </a>
                                        @else
                                            <span class="text-muted fst-italic">Non renseigné</span>
                                        @endif
                                    </p>
                                </div>
                                <!-- API Key -->
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">API Key</label>
                                    <p class="mb-0 fw-semibold font-monospace">
                                        @if($platform->api_key)
                                            <span class="text-dark">{{ Str::mask($platform->api_key, '*', 4) }}</span>
                                        @else
                                            <span class="text-muted fst-italic">Non renseignée</span>
                                        @endif
                                    </p>
                                </div>
                                <!-- API Secret -->
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">API Secret</label>
                                    <p class="mb-0 fw-semibold font-monospace">
                                        @if($platform->api_secret)
                                            <span class="text-dark">{{ Str::mask($platform->api_secret, '*', 4) }}</span>
                                        @else
                                            <span class="text-muted fst-italic">Non renseigné</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Métadonnées -->
                    @if($platform->metadata)
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                                <i class="fas fa-database me-2 text-primary"></i>
                                Métadonnées
                            </h6>
                            <div class="bg-light rounded-3 p-4">
                                <pre class="mb-0" style="font-size: 0.85rem; white-space: pre-wrap;">{{ json_encode($platform->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            </div>
                        </div>
                    @endif

                    <!-- Actions rapides -->
                    <div class="border-top pt-4">
                        <div class="row g-3">
                            
                            <div class="col-sm-6 col-lg-4">
                                <div class="d-grid">
                                    <a href="{{ route('backend.cloud_platforms.index') }}"
                                       class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                        <i class="fas fa-list me-2"></i>
                                        Retour à la liste
                                    </a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-xl-4 col-lg-5">

            <!-- Informations générales -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        Informations générales
                    </h5>
                </div>
                <div class="card-body pt-2">
                    <!-- Statut -->
                    <div class="d-flex align-items-center p-3 bg-light rounded-3 mb-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-sm">
                                <div class="avatar-initial {{ $platform->status === 'active' ? 'bg-success' : 'bg-danger' }} bg-opacity-10 {{ $platform->status === 'active' ? 'text-success' : 'text-danger' }} rounded">
                                    <i class="fas {{ $platform->status === 'active' ? 'fa-check' : 'fa-times' }}"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label small text-muted mb-1">Statut</label>
                            <p class="mb-0 fw-semibold">
                                @if($platform->status === 'active')
                                    <span class="text-success">Active</span>
                                @else
                                    <span class="text-danger">Inactive</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Token -->
                    <div class="d-flex align-items-center p-3 bg-light rounded-3 mb-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-sm">
                                <div class="avatar-initial bg-warning bg-opacity-10 text-warning rounded">
                                    <i class="fas fa-key"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label small text-muted mb-1">Token</label>
                            <p class="mb-0 fw-semibold font-monospace" style="font-size: 0.8rem; word-break: break-all;">
                                {{ Str::mask($platform->token, '*', 6) }}
                            </p>
                        </div>
                    </div>

                    <!-- API Endpoint -->
                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-sm">
                                <div class="avatar-initial bg-info bg-opacity-10 text-info rounded">
                                    <i class="fas fa-globe"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label small text-muted mb-1">API Endpoint</label>
                            <p class="mb-0 fw-semibold" style="font-size: 0.85rem; word-break: break-all;">
                                @if($platform->api_endpoint)
                                    <a href="{{ $platform->api_endpoint }}" target="_blank" class="text-info text-decoration-none">
                                        {{ Str::limit($platform->api_endpoint, 35) }}
                                    </a>
                                @else
                                    <span class="text-muted fst-italic">Non renseigné</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations temporelles -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-clock me-2 text-primary"></i>
                        Informations temporelles
                    </h5>
                </div>
                <div class="card-body pt-2">
                    <!-- Créé le -->
                    <div class="d-flex align-items-center p-3 bg-light rounded-3 mb-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-sm">
                                <div class="avatar-initial bg-success bg-opacity-10 text-success rounded">
                                    <i class="fas fa-calendar-plus"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label small text-muted mb-1">Date de création</label>
                            <p class="mb-0 fw-semibold">
                                {{ mb_convert_case(\Carbon\Carbon::parse($platform->created_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY'), MB_CASE_TITLE, 'UTF-8') }}
                            </p>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($platform->created_at)->locale(app()->getLocale())->isoFormat('HH:mm:ss') }}</small>
                        </div>
                    </div>

                    <!-- Modifié le -->
                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-sm">
                                <div class="avatar-initial bg-warning bg-opacity-10 text-warning rounded">
                                    <i class="fas fa-calendar-edit"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label small text-muted mb-1">Dernière modification</label>
                            <p class="mb-0 fw-semibold">
                                {{ mb_convert_case(\Carbon\Carbon::parse($platform->updated_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY'), MB_CASE_TITLE, 'UTF-8') }}
                            </p>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($platform->updated_at)->locale(app()->getLocale())->isoFormat('HH:mm:ss') }}</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- / Content -->
@endsection()