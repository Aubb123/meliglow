@extends('backend/layouts/app')

@section('title')
    dashboard/blogs/show
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
                            <h4 class="mb-1 fw-bold text-dark">Détails du blog</h4>
                            <p class="mb-0 text-muted">Consultez et gérez les informations du blog</p>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('backend.blogs.show', $blog->token) }}" class="btn btn-outline-info d-flex align-items-center">
                                <i class="fas fa-eye me-2"></i>
                                Voir
                            </a>
                            <a href="{{ route('backend.blogs.edit', $blog->token) }}" class="btn btn-primary d-flex align-items-center">
                                <i class="fas fa-edit me-2"></i>
                                Modifier
                            </a>
                            <form method="POST" id="delete-form-{{$blog->token}}" action="{{ route('backend.blogs.destroy', $blog->token) }}" class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="button" class="btn btn-outline-danger d-flex align-items-center" onclick="confirmDelete('{{$blog->token}}', 'Êtes-vous sûr de vouloir supprimer ce blog ?')">
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
    @include('backend/layouts/includes/blogs/backend-pages-blogs-show-navbar')

    <div class="row g-4">
        <!-- Contenu principal -->
        <div class="col-xl-8 col-lg-7">
            <!-- Article principal -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <!-- En-tête de l'article -->
                    <div class="mb-4">
                        <h2 class="fw-bold text-dark mb-3">{{ $blog->title }}</h2>
                        
                        <!-- Meta-informations -->
                        <div class="d-flex align-items-center flex-wrap gap-3 mb-3">
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-user me-2"></i>
                                <a href="{{ route('backend.users.show', $blog->user->token) }}" class="text-decoration-none">
                                    {{ $blog->user->lastname }} {{ $blog->user->firstname }}
                                </a>
                            </div>
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-folder me-2"></i>
                                <a href="{{ route('backend.categories.show', $blog->categorie->token) }}" class="text-decoration-none">
                                    {{ $blog->categorie->name }}
                                </a>
                            </div>
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-calendar me-2"></i>
                                {{ mb_convert_case(\Carbon\Carbon::parse($blog->created_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY'), MB_CASE_TITLE, 'UTF-8') }}
                            </div>
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-clock me-2"></i>
                                {{ $blog->time_read }} min de lecture
                            </div>
                        </div>

                        <!-- Statut de visibilité -->
                        <div class="mb-3">
                            @if($blog->is_visible)
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                    <i class="fas fa-eye me-1"></i>
                                    Blog publié
                                </span>
                            @else
                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">
                                    <i class="fas fa-eye-slash me-1"></i>
                                    Blog masqué
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Image principale -->
                    <div class="mb-4">
                        <div class="position-relative">
                            <img src="{{ asset(getEnvFolder() . $blog->path_img) }}" 
                                 alt="{{ $blog->title }}" 
                                 class="img-fluid rounded-3 shadow-sm w-100" 
                                 style="max-height: 500px; object-fit: cover;">
                            <div class="position-absolute bottom-0 start-0 m-3">
                                <span class="badge bg-dark bg-opacity-75 text-white px-3 py-2 rounded-pill">
                                    <i class="fas fa-eye me-1"></i>
                                    {{ $blog->views }} vue(s)
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Tags -->
                    @if($blog->tags->count() > 0)
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                                <i class="fas fa-tags me-2 text-primary"></i>
                                Tags
                            </h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($blog->tags as $tag)
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                        <i class="fas fa-tag me-1"></i>
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Contenu -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <i class="fas fa-align-left me-2 text-primary"></i>
                            Contenu
                        </h6>
                        <div class="bg-light rounded-3 p-4">
                            <div class="content-blog">
                                {!! $blog->content !!}
                            </div>
                        </div>
                    </div>

                    <!-- Actions rapides -->
                    <div class="border-top pt-4">
                        <div class="row g-3">
                            <div class="col-sm-6 col-lg-3">
                                <div class="d-grid">
                                    <a href="{{ route('backend.blogs.edit', $blog->token) }}" 
                                       class="btn btn-outline-primary d-flex align-items-center justify-content-center">
                                        <i class="fas fa-edit me-2"></i>
                                        Modifier
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="d-grid">
                                    <a href="{{ route('backend.blogs.comments', $blog->token) }}" 
                                       class="btn btn-outline-info d-flex align-items-center justify-content-center">
                                        <i class="fas fa-comments me-2"></i>
                                        Commentaires
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="d-grid">
                                    <button type="button" 
                                            class="btn btn-outline-warning d-flex align-items-center justify-content-center">
                                        <i class="fas fa-share me-2"></i>
                                        Partager
                                    </button>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="d-grid">
                                    <button type="button" 
                                            class="btn btn-outline-danger d-flex align-items-center justify-content-center"
                                            onclick="confirmDelete('{{$blog->token}}', 'Êtes-vous sûr de vouloir supprimer ce blog ?')">
                                        <i class="fas fa-trash me-2"></i>
                                        Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section des commentaires -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-comments me-2 text-primary"></i>
                        Commentaires ({{ $blog->comments ? $blog->comments->count() : 0 }})
                    </h5>
                </div>
                <div class="card-body pt-2">
                    @include('backend/layouts/includes/blogs/backend-pages-blogs-show-section-comments')
                </div>
            </div>
        </div>

        <!-- Sidebar d'informations -->
        <div class="col-xl-4 col-lg-5">
            <!-- Statistiques -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-chart-bar me-2 text-primary"></i>
                        Statistiques
                    </h5>
                </div>
                <div class="card-body pt-2">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="bg-primary bg-opacity-10 rounded-3 p-3 text-center">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <div class="avatar avatar-sm">
                                        <div class="avatar-initial bg-primary text-white rounded">
                                            <i class="fas fa-eye"></i>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mb-1 fw-bold text-primary">{{ $blog->views }}</h5>
                                <small class="text-muted">Vues</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-info bg-opacity-10 rounded-3 p-3 text-center">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <div class="avatar avatar-sm">
                                        <div class="avatar-initial bg-info text-white rounded">
                                            <i class="fas fa-comments"></i>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mb-1 fw-bold text-info">{{ $blog->comments ? $blog->comments->count() : 0 }}</h5>
                                <small class="text-muted">Commentaires</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-success bg-opacity-10 rounded-3 p-3 text-center">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <div class="avatar avatar-sm">
                                        <div class="avatar-initial bg-success text-white rounded">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mb-1 fw-bold text-success">{{ $blog->time_read }}</h5>
                                <small class="text-muted">Min lecture</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-warning bg-opacity-10 rounded-3 p-3 text-center">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <div class="avatar avatar-sm">
                                        <div class="avatar-initial bg-warning text-white rounded">
                                            <i class="fas fa-tags"></i>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mb-1 fw-bold text-warning">{{ $blog->tags->count() }}</h5>
                                <small class="text-muted">Tags</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations de publication -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        Informations de publication
                    </h5>
                </div>
                <div class="card-body pt-2">
                    <div class="d-flex align-items-center p-3 bg-light rounded-3 mb-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-sm">
                                <div class="avatar-initial {{ $blog->is_visible ? 'bg-success' : 'bg-warning' }} bg-opacity-10 {{ $blog->is_visible ? 'text-success' : 'text-warning' }} rounded">
                                    <i class="{{ $blog->is_visible ? 'fas fa-eye' : 'fas fa-eye-slash' }}"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label small text-muted mb-1">État du blog</label>
                            <p class="mb-0 fw-semibold">
                                @if($blog->is_visible)
                                    <span class="text-success">Blog publié</span>
                                @else
                                    <span class="text-warning">Blog masqué</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center p-3 bg-light rounded-3 mb-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-sm">
                                <div class="avatar-initial bg-primary bg-opacity-10 text-primary rounded">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label small text-muted mb-1">Auteur</label>
                            <p class="mb-0">
                                <a href="{{ route('backend.users.show', $blog->user->token) }}" 
                                   class="text-decoration-none fw-semibold text-primary">
                                    {{ $blog->user->lastname }} {{ $blog->user->firstname }}
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center p-3 bg-light rounded-3 mb-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-sm">
                                <div class="avatar-initial bg-secondary bg-opacity-10 text-secondary rounded">
                                    <i class="fas fa-folder"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label small text-muted mb-1">Catégorie</label>
                            <p class="mb-0">
                                <a href="{{ route('backend.categories.show', $blog->categorie->token) }}" 
                                   class="text-decoration-none fw-semibold text-secondary">
                                    {{ $blog->categorie->name }}
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-sm">
                                <div class="avatar-initial bg-info bg-opacity-10 text-info rounded">
                                    <i class="fas fa-comments"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label small text-muted mb-1">Commentaires</label>
                            <p class="mb-0">
                                <a href="{{ route('backend.blogs.comments', $blog->token) }}" 
                                   class="text-decoration-none fw-semibold text-info">
                                    {{ $blog->comments ? $blog->comments->count() : 0 }} commentaire(s)
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
                                {{ mb_convert_case(\Carbon\Carbon::parse($blog->created_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY'), MB_CASE_TITLE, 'UTF-8') }}
                            </p>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($blog->created_at)->locale(app()->getLocale())->isoFormat('HH:mm:ss') }}</small>
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
                                {{ mb_convert_case(\Carbon\Carbon::parse($blog->updated_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY'), MB_CASE_TITLE, 'UTF-8') }}
                            </p>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($blog->updated_at)->locale(app()->getLocale())->isoFormat('HH:mm:ss') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Styles personnalisés pour le contenu du blog -->
<style>
.content-blog {
    line-height: 1.8;
}
.content-blog h1, .content-blog h2, .content-blog h3, .content-blog h4, .content-blog h5, .content-blog h6 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
    font-weight: 600;
}
.content-blog p {
    margin-bottom: 1rem;
    text-align: justify;
}
.content-blog img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
}
.content-blog blockquote {
    border-left: 4px solid var(--bs-primary);
    padding-left: 1rem;
    margin: 1.5rem 0;
    background-color: var(--bs-light);
    padding: 1rem;
    border-radius: 8px;
}
</style>

<!-- / Content -->
@endsection()