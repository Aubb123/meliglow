@extends('backend/layouts/app')

@section('title')
    dashboard - product-categories - show
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
                            <p class="mb-0 text-muted">Consultez et gérez les informations de la catégorie de produits</p>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('backend.product_categories.show', $category->token) }}" class="btn btn-outline-info d-flex align-items-center">
                                <i class="fas fa-eye me-2"></i>
                                Voir
                            </a>
                            <a href="{{ route('backend.product_categories.edit', $category->token) }}" class="btn btn-primary d-flex align-items-center">
                                <i class="fas fa-edit me-2"></i>
                                Modifier
                            </a>
                            <form method="POST" id="delete-form-{{ $category->token }}" action="{{ route('backend.product_categories.destroy', $category->token) }}" class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="button" class="btn btn-outline-danger d-flex align-items-center" onclick="confirmDelete('{{ $category->token }}', 'Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
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

    <div class="row g-4">
        <!-- Contenu principal -->
        <div class="col-lg-8">
            <!-- Carte principale de la catégorie -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-folder me-2 text-primary"></i>
                        {{ $category->name }}
                    </h5>
                </div>
                <div class="card-body pt-2">

                    @include('backend/layouts/includes/others/_file', ['model' => $category])

                    <!-- Description -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <i class="fas fa-align-left me-2 text-secondary"></i>
                            Description
                        </h6>
                        <div class="bg-light rounded-3 p-4">
                            <p class="mb-0 text-dark lh-lg">
                                {{ $category->description ?: 'Aucune description disponible pour cette catégorie.' }}
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
                                            <i class="fas fa-box"></i>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mb-1 fw-bold text-primary">{{ $category->products->count() }}</h5>
                                <small class="text-muted">Produit(s) associé(s)</small>
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
                                <h6 class="mb-1 fw-bold text-success">
                                    {{ \Carbon\Carbon::parse($category->created_at)->format('d/m/Y') }}
                                </h6>
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
                                <h6 class="mb-1 fw-bold text-warning">
                                    {{ \Carbon\Carbon::parse($category->updated_at)->format('d/m/Y') }}
                                </h6>
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
                                <a href="{{ route('backend.product_categories.edit', $category->token) }}"
                                   class="btn btn-outline-primary d-flex align-items-center justify-content-center py-3">
                                    <i class="fas fa-edit me-2"></i>
                                    Modifier la catégorie
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-grid">
                                <a href="{{ route('backend.product_categories.show', $category->token) }}"
                                   class="btn btn-outline-info d-flex align-items-center justify-content-center py-3">
                                    <i class="fas fa-box me-2"></i>
                                    Voir les produits ({{ $category->products->count() }})
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-grid">
                                <a href="{{ route('backend.products.create', ['categorie_token' => $category->token]) }}"
                                   class="btn btn-outline-success d-flex align-items-center justify-content-center py-3">
                                    <i class="fas fa-plus me-2"></i>
                                    Ajouter un produit
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-grid">
                                <button type="button"
                                        class="btn btn-outline-danger d-flex align-items-center justify-content-center py-3"
                                        onclick="confirmDelete('{{ $category->token }}', 'Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                    <i class="fas fa-trash me-2"></i>
                                    Supprimer la catégorie
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des produits associés -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-boxes me-2 text-primary"></i>
                        Produits associés ({{ $products->count() }})
                    </h5>

                    @include('backend/layouts/includes/products/product/_backend-pages-products-index-table', ['products' => $products])
                    
                    <div class="ms-auto">
                        <a href="{{ route('backend.products.index') }}" class="btn btn-outline-info d-flex align-items-center">
                            <i class="fas fa-eye me-2"></i>
                            Voir tous les produits
                        </a>
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
                    <!-- Nom -->
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
                            <p class="mb-0 fw-semibold">{{ $category->name }}</p>
                        </div>
                    </div>

                    <!-- Nombre de produits -->
                    <div class="d-flex align-items-center p-3 bg-light rounded-3 mb-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-sm">
                                <div class="avatar-initial bg-info bg-opacity-10 text-info rounded">
                                    <i class="fas fa-box"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label small text-muted mb-1">Produits associés</label>
                            <p class="mb-0">
                                <a href="{{ route('backend.product_categories.show', $category->token) }}"
                                   class="text-decoration-none fw-semibold text-info">
                                    {{ $category->products->count() }} Produit(s)
                                </a>
                            </p>
                        </div>
                    </div>

                    <!-- Produits visibles -->
                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-sm">
                                <div class="avatar-initial bg-success bg-opacity-10 text-success rounded">
                                    <i class="fas fa-eye"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label small text-muted mb-1">Produits publiés</label>
                            <p class="mb-0 fw-semibold text-success">
                                {{ $category->products->where('is_visible', true)->count() }} Publié(s)
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
                    <!-- Date de création -->
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
                                {{ mb_convert_case(\Carbon\Carbon::parse($category->created_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY'), MB_CASE_TITLE, 'UTF-8') }}
                            </p>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($category->created_at)->locale(app()->getLocale())->isoFormat('HH:mm:ss') }}
                            </small>
                        </div>
                    </div>

                    <!-- Dernière modification -->
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
                                {{ mb_convert_case(\Carbon\Carbon::parse($category->updated_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY'), MB_CASE_TITLE, 'UTF-8') }}
                            </p>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($category->updated_at)->locale(app()->getLocale())->isoFormat('HH:mm:ss') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection()