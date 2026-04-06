@extends('backend/layouts/app')

@section('title')
    dashboard/categories/show
@endsection()

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- En-tête de page -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div>
                            <h4 class="mb-1 fw-bold text-dark">Détails de la catégorie</h4>
                            <p class="mb-0 text-muted">Consultez et gérez les informations de la catégorie</p>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('backend.categories.show', $categorie->token) }}" class="btn btn-outline-info d-flex align-items-center">
                                <i class="fas fa-eye me-2"></i>
                                Voir
                            </a>
                            <a href="{{ route('backend.categories.edit', $categorie->token) }}" class="btn btn-primary d-flex align-items-center">
                                <i class="fas fa-edit me-2"></i>
                                Modifier
                            </a>
                            <form method="POST" id="delete-form-{{$categorie->token}}" action="{{ route('backend.categories.destroy', $categorie->token) }}" class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="button" class="btn btn-outline-danger d-flex align-items-center" onclick="confirmDelete('{{$categorie->token}}', 'Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                    <i class="fas fa-trash me-2"></i>
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Barre de navigation -->
    @include('backend/layouts/includes/categories/backend-pages-categories-show-navbar')

    <div class="row g-4">
        <!-- Contenu principal -->
        <div class="col-lg-8">
            <!-- Carte principale de la catégorie -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-folder me-2 text-primary"></i>
                        {{ $categorie->name }}
                    </h5>
                </div>
                <div class="card-body pt-2">
                    <!-- Image de la catégorie -->
                    <div class="mb-4">
                        <div class="position-relative">
                            <img src="{{ asset(getEnvFolder() . $categorie->path_img) }}" 
                                 alt="{{ $categorie->name }}" 
                                 class="img-fluid rounded-3 shadow-sm w-100" 
                                 style="max-height: 400px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-primary bg-opacity-90 text-white px-3 py-2 rounded-pill">
                                    <i class="fas fa-image me-1"></i>
                                    Image principale
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <i class="fas fa-align-left me-2 text-secondary"></i>
                            Description
                        </h6>
                        <div class="bg-light rounded-3 p-4">
                            <p class="mb-0 text-dark lh-lg">
                                {{ $categorie->description ?: 'Aucune description disponible pour cette catégorie.' }}
                            </p>
                        </div>
                    </div>

                    <!-- Statistiques rapides -->
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="bg-primary bg-opacity-10 rounded-3 p-3 text-center">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <div class="avatar avatar-sm">
                                        <div class="avatar-initial bg-primary text-white rounded">
                                            <i class="fas fa-blog"></i>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mb-1 fw-bold text-primary">{{ $categorie->blogs->count() }}</h5>
                                <small class="text-muted">Blog(s) associé(s)</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-success bg-opacity-10 rounded-3 p-3 text-center">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <div class="avatar avatar-sm">
                                        <div class="avatar-initial bg-success text-white rounded">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="mb-1 fw-bold text-success">{{ \Carbon\Carbon::parse($categorie->created_at)->format('d/m/Y') }}</h6>
                                <small class="text-muted">Date de création</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-warning bg-opacity-10 rounded-3 p-3 text-center">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <div class="avatar avatar-sm">
                                        <div class="avatar-initial bg-warning text-white rounded">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="mb-1 fw-bold text-warning">{{ \Carbon\Carbon::parse($categorie->updated_at)->format('d/m/Y') }}</h6>
                                <small class="text-muted">Dernière modification</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-tools me-2 text-primary"></i>
                        Actions rapides
                    </h5>
                </div>
                <div class="card-body pt-2">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="d-grid">
                                <a href="{{ route('backend.categories.edit', $categorie->token) }}" 
                                   class="btn btn-outline-primary d-flex align-items-center justify-content-center py-3">
                                    <i class="fas fa-edit me-2"></i>
                                    Modifier la catégorie
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-grid">
                                <a href="{{ route('backend.categories.blogs', $categorie->token) }}" 
                                   class="btn btn-outline-info d-flex align-items-center justify-content-center py-3">
                                    <i class="fas fa-blog me-2"></i>
                                    Voir les blogs ({{ $categorie->blogs->count() }})
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-grid">
                                <button type="button" 
                                        class="btn btn-outline-success d-flex align-items-center justify-content-center py-3">
                                    <i class="fas fa-plus me-2"></i>
                                    Ajouter un blog
                                </button>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-grid">
                                <button type="button" 
                                        class="btn btn-outline-danger d-flex align-items-center justify-content-center py-3"
                                        onclick="confirmDelete('{{$categorie->token}}', 'Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                    <i class="fas fa-trash me-2"></i>
                                    Supprimer la catégorie
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar d'informations -->
        <div class="col-lg-4">
            <!-- Informations générales -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        Informations générales
                    </h5>
                </div>
                <div class="card-body pt-2">
                    <div class="d-flex align-items-center p-3 bg-light rounded-3 mb-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-sm">
                                <div class="avatar-initial bg-primary bg-opacity-10 text-primary rounded">
                                    <i class="fas fa-tag"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label small text-muted mb-1">Nom de la catégorie</label>
                            <p class="mb-0 fw-semibold">{{ $categorie->name }}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center p-3 bg-light rounded-3 mb-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-sm">
                                <div class="avatar-initial bg-info bg-opacity-10 text-info rounded">
                                    <i class="fas fa-blog"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label small text-muted mb-1">Blogs associés</label>
                            <p class="mb-0">
                                <a href="{{ route('backend.categories.blogs', $categorie->token) }}" 
                                   class="text-decoration-none fw-semibold text-info">
                                    {{ $categorie->blogs->count() }} Blog(s)
                                </a>
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
                                {{ mb_convert_case(\Carbon\Carbon::parse($categorie->created_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY'), MB_CASE_TITLE, 'UTF-8') }}
                            </p>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($categorie->created_at)->locale(app()->getLocale())->isoFormat('HH:mm:ss') }}</small>
                        </div>
                    </div>

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
                                {{ mb_convert_case(\Carbon\Carbon::parse($categorie->updated_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY'), MB_CASE_TITLE, 'UTF-8') }}
                            </p>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($categorie->updated_at)->locale(app()->getLocale())->isoFormat('HH:mm:ss') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection()