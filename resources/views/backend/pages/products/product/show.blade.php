@extends('backend/layouts/app')

@section('title')
    dashboard/products/show
@endsection()

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- En-tête --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div>
                            <h4 class="mb-1 fw-bold text-dark">Détails du produit</h4>
                            <p class="mb-0 text-muted">Consultez et gérez les informations du produit</p>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('backend.products.edit', $product->token) }}" class="btn btn-primary d-flex align-items-center">
                                <i class="fas fa-edit me-2"></i>
                                Modifier
                            </a>
                            <form method="POST" id="delete-form-{{ $product->token }}" action="{{ route('backend.products.destroy', $product->token) }}" class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="button" class="btn btn-outline-danger d-flex align-items-center" onclick="confirmDelete('{{ $product->token }}', 'Êtes-vous sûr de vouloir supprimer ce produit ?')">
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

        {{-- Colonne principale --}}
        <div class="col-lg-8">

            {{-- Carte principale --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-box me-2 text-primary"></i>
                        {{ $product->name }}
                    </h5>
                </div>
                <div class="card-body">

                    {{-- Statut & Catégorie --}}
                    <div class="d-flex align-items-center gap-2 mb-4">
                        @if($product->is_visible)
                            <span class="badge bg-success px-3 py-2">
                                <i class="fas fa-eye me-1"></i> Publié
                            </span>
                        @else
                            <span class="badge bg-danger px-3 py-2">
                                <i class="fas fa-eye-slash me-1"></i> Brouillon
                            </span>
                        @endif
                        <a href="{{ route('backend.product_categories.show', $product->category->token) }}" class="badge bg-primary px-3 py-2 text-decoration-none">
                            <i class="fas fa-folder me-1"></i>
                            {{ $product->category->name }}
                        </a>
                        @if($product->stock == 0)
                            <span class="badge bg-danger px-3 py-2">Rupture de stock</span>
                        @elseif($product->stock <= 5)
                            <span class="badge bg-warning text-dark px-3 py-2">Stock faible</span>
                        @else
                            <span class="badge bg-success px-3 py-2">En stock</span>
                        @endif
                        <!-- Mettre en avant -->
                        @if($product->is_featured)
                            <span class="badge bg-warning text-dark px-3 py-2">
                                <i class="fas fa-star me-1"></i> En avant
                            </span>
                        @else
                            <span class="badge bg-secondary px-3 py-2">
                                <i class="fas fa-star me-1"></i> Non en avant
                            </span>
                        @endif
                    </div>

                    @include('backend/layouts/includes/others/_file', ['model' => $product])

                    {{-- Description --}}
                    <div class="mb-4 mt-5">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <i class="fas fa-align-left me-2 text-secondary"></i>
                            Description
                        </h6>
                        <div class="bg-light rounded-3 p-4">
                            <p class="mb-0 text-dark lh-lg">{{ $product->description }}</p>
                        </div>
                    </div>

                    {{-- Prix --}}
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <i class="fas fa-tags me-2 text-secondary"></i>
                            Tarification
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="bg-light rounded-3 p-3 text-center">
                                    <small class="text-muted d-block mb-1">Prix d'achat</small>
                                    <span class="fw-bold text-dark">{{ number_format($product->purchase_price, 0, ',', ' ') }} FCFA</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-primary bg-opacity-10 rounded-3 p-3 text-center">
                                    <small class="text-muted d-block mb-1">Prix de vente</small>
                                    <span class="fw-bold text-primary">{{ number_format($product->sale_price, 0, ',', ' ') }} FCFA</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                @if($product->promotional_price)
                                <div class="bg-warning bg-opacity-10 rounded-3 p-3 text-center">
                                    <small class="text-muted d-block mb-1">Prix promotionnel</small>
                                    <span class="fw-bold text-warning">{{ number_format($product->promotional_price, 0, ',', ' ') }} FCFA</span>
                                </div>
                                @else
                                <div class="bg-light rounded-3 p-3 text-center">
                                    <small class="text-muted d-block mb-1">Prix promotionnel</small>
                                    <span class="text-muted">Aucune promo</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Statistiques rapides --}}
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="bg-info bg-opacity-10 rounded-3 p-3 text-center">
                                <div class="avatar avatar-sm mx-auto mb-2">
                                    <div class="avatar-initial bg-info text-white rounded">
                                        <i class="fas fa-eye"></i>
                                    </div>
                                </div>
                                <h5 class="mb-1 fw-bold text-info">{{ $product->views }}</h5>
                                <small class="text-muted">Vue(s)</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-success bg-opacity-10 rounded-3 p-3 text-center">
                                <div class="avatar avatar-sm mx-auto mb-2">
                                    <div class="avatar-initial bg-success text-white rounded">
                                        <i class="fas fa-cubes"></i>
                                    </div>
                                </div>
                                <h5 class="mb-1 fw-bold text-success">{{ $product->stock }}</h5>
                                <small class="text-muted">En stock</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-warning bg-opacity-10 rounded-3 p-3 text-center">
                                <div class="avatar avatar-sm mx-auto mb-2">
                                    <div class="avatar-initial bg-warning text-white rounded">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                </div>
                                <h6 class="mb-1 fw-bold text-warning">{{ \Carbon\Carbon::parse($product->created_at)->format('d/m/Y') }}</h6>
                                <small class="text-muted">Date création</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions rapides --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-tools me-2 text-primary"></i>
                        Actions rapides
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @can('web.check.role.user', [1, 2])
                        <div class="col-sm-6">
                            <div class="d-grid">
                                <a href="{{ route('backend.products.edit', $product->token) }}"
                                   class="btn btn-outline-primary d-flex align-items-center justify-content-center py-3">
                                    <i class="fas fa-edit me-2"></i>
                                    Modifier le produit
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-grid">
                                <button type="button"
                                        class="btn btn-outline-danger d-flex align-items-center justify-content-center py-3"
                                        onclick="confirmDelete('{{ $product->token }}', 'Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                    <i class="fas fa-trash me-2"></i>
                                    Supprimer le produit
                                </button>
                            </div>
                        </div>
                        @endcan
                        <div class="col-sm-6">
                            <div class="d-grid">
                                <a href="{{ route('backend.product_categories.show', $product->category->token) }}"
                                   class="btn btn-outline-info d-flex align-items-center justify-content-center py-3">
                                    <i class="fas fa-folder me-2"></i>
                                    Voir la catégorie
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-grid">
                                <a href="{{ route('backend.products.index') }}"
                                   class="btn btn-outline-secondary d-flex align-items-center justify-content-center py-3">
                                    <i class="fas fa-list me-2"></i>
                                    Retour à la liste
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">

            {{-- Informations générales --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        Informations générales
                    </h5>
                </div>
                <div class="card-body pt-2">

                    {{-- Nom --}}
                    <div class="d-flex align-items-center p-3 bg-light rounded-3 mb-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-sm">
                                <div class="avatar-initial bg-primary bg-opacity-10 text-primary rounded">
                                    <i class="fas fa-box"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label small text-muted mb-1">Nom</label>
                            <p class="mb-0 fw-semibold">{{ $product->name }}</p>
                        </div>
                    </div>

                    {{-- Catégorie --}}
                    <div class="d-flex align-items-center p-3 bg-light rounded-3 mb-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-sm">
                                <div class="avatar-initial bg-info bg-opacity-10 text-info rounded">
                                    <i class="fas fa-folder"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label small text-muted mb-1">Catégorie</label>
                            <p class="mb-0">
                                <a href="{{ route('backend.product_categories.show', $product->category->token) }}"
                                   class="text-decoration-none fw-semibold text-info">
                                    {{ $product->category->name }}
                                </a>
                            </p>
                        </div>
                    </div>

                    {{-- Ajouté par --}}
                    <div class="d-flex align-items-center p-3 bg-light rounded-3 mb-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-sm">
                                <div class="avatar-initial bg-warning bg-opacity-10 text-warning rounded">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label small text-muted mb-1">Ajouté par</label>
                            <p class="mb-0 fw-semibold">
                                {{ $product->user->lastname }} {{ $product->user->firstname }}
                            </p>
                        </div>
                    </div>

                    {{-- Marge --}}
                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-sm">
                                <div class="avatar-initial bg-success bg-opacity-10 text-success rounded">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label small text-muted mb-1">Marge bénéficiaire</label>
                            <p class="mb-0 fw-semibold text-success">
                                {{ number_format($product->sale_price - $product->purchase_price, 0, ',', ' ') }} FCFA
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Informations temporelles --}}
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
                                {{ mb_convert_case(\Carbon\Carbon::parse($product->created_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY'), MB_CASE_TITLE, 'UTF-8') }}
                            </p>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($product->created_at)->locale(app()->getLocale())->isoFormat('HH:mm:ss') }}
                            </small>
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
                                {{ mb_convert_case(\Carbon\Carbon::parse($product->updated_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY'), MB_CASE_TITLE, 'UTF-8') }}
                            </p>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($product->updated_at)->locale(app()->getLocale())->isoFormat('HH:mm:ss') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mettre en avant -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-star me-2 text-warning"></i>
                        Mettre en avant
                    </h5>
                </div>
                <div class="card-body pt-2">
                    <div class="d-flex align-items-center p-3 rounded-3">
                        <div class="flex-grow-1">
                            <label class="form-label small text-muted mb-1">Produit en avant</label>
                            
                            <!-- Formulaire de mise en avant -->
                            <form method="POST" action="{{ route('backend.products.featured', $product->token) }}">
                                @csrf
                                @method('patch')

                                <!-- Un select -->
                                <select name="is_featured" class="form-select mb-3" onchange="this.form.submit()">
                                    <option value="0" {{ !$product->is_featured ? 'selected' : '' }}>Non</option>
                                    <option value="1" {{ $product->is_featured ? 'selected' : '' }}>Oui</option>
                                </select>

                                {{--
                                    <button type="submit" class="btn btn-sm btn-warning mt-3">
                                        {{ $product->is_featured ? 'Désactiver la mise en avant' : 'Activer la mise en avant' }}
                                    </button>
                                --}}

                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection()