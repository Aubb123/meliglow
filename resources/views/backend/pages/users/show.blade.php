@extends('backend/layouts/app')

@section('title') dashboard/users/show @endsection()

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Inclur l'entete -->
    @include('backend/layouts/includes/users/_show-header')
    
    <!-- Contenu des onglets -->
    <div class="row g-4">
        <!-- Sidebar utilisateur -->
        <div class="col-xl-4 col-lg-5">
            <!-- Carte profil principal -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center py-5">
                    <div class="position-relative d-inline-block mb-4">
                        <img class="rounded-circle border border-3 border-white shadow" src="{{ $user->getCoverImageUrl()['url_img'] }}" style="width: 120px; height: 120px; object-fit: cover;" alt="Avatar utilisateur">
                        <!-- Badge statut -->
                        <span class="position-absolute bottom-0 end-0 p-1 bg-white rounded-circle">
                            @if($user->is_active)
                                <span class="badge bg-success rounded-pill p-2">●</span>
                            @else
                                <span class="badge bg-danger rounded-pill p-2">●</span>
                            @endif
                        </span>
                    </div>

                    <h5 class="mb-2 fw-bold">{{ $user->lastname }} {{ $user->firstname }}</h5>
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fs-6">
                        {{ $user->role->label }}
                    </span>
                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill fs-6">
                        {{ $user->country->name }}
                    </span>

                    <div class="mt-4 pt-4 border-top">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="border-end">
                                    <h6 class="mb-1 fw-bold {{ $user->is_active ? 'text-success' : 'text-danger' }}">
                                        {{ $user->is_active ? 'Actif' : 'Bloqué' }}
                                    </h6>
                                    <small class="text-muted">Status</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border-end">
                                    <h6 class="mb-1 fw-bold">
                                        @if($user->email_verified_at)
                                            <i class="fas fa-check text-success"></i>
                                        @else
                                            <i class="fas fa-times text-danger"></i>
                                        @endif
                                    </h6>
                                    <small class="text-muted">Email</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <h6 class="mb-1 fw-bold text-capitalize">{{ $user->getSexeFrAttribute() }}</h6>
                                <small class="text-muted">Genre</small>
                            </div>
                        </div>
                    </div>

                    <!-- Biographie -->
                    @if($user->bio)
                        <div class="mt-4 pt-4 border-top text-start">
                            <h6 class="fw-bold mb-2">
                                <i class="fas fa-quote-left me-2 text-primary"></i>
                                Biographie
                            </h6>
                            <p class="text-muted small mb-0">{{ $user->bio }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Réseaux sociaux -->
            @if($user->facebook_link || $user->twitter_link || $user->instagram_link || $user->linkedin_link || $user->youtube_link || $user->tiktok_link || $user->whatsapp_link || $user->website_link)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
                        <h5 class="mb-0 fw-bold d-flex align-items-center">
                            <i class="fas fa-share-alt me-2 text-primary"></i>
                            Réseaux sociaux
                        </h5>
                    </div>
                    <div class="card-body pt-2">
                        <div class="d-flex flex-column gap-3">
                            @if($user->facebook_link)
                            <a href="{{ $user->facebook_link }}" target="_blank" class="d-flex align-items-center text-decoration-none p-2 rounded-3 bg-light hover-shadow">
                                <div class="avatar avatar-sm me-3">
                                    <div class="avatar-initial rounded" style="background-color: #1877f2;">
                                        <i class="fab fa-facebook-f text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-semibold text-dark">Facebook</p>
                                    <small class="text-muted">Voir le profil</small>
                                </div>
                                <i class="fas fa-external-link-alt text-muted"></i>
                            </a>
                            @endif

                            @if($user->twitter_link)
                            <a href="{{ $user->twitter_link }}" target="_blank" class="d-flex align-items-center text-decoration-none p-2 rounded-3 bg-light hover-shadow">
                                <div class="avatar avatar-sm me-3">
                                    <div class="avatar-initial rounded" style="background-color: #000000;">
                                        <i class="fab fa-x-twitter text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-semibold text-dark">Twitter / X</p>
                                    <small class="text-muted">Voir le profil</small>
                                </div>
                                <i class="fas fa-external-link-alt text-muted"></i>
                            </a>
                            @endif

                            @if($user->instagram_link)
                            <a href="{{ $user->instagram_link }}" target="_blank" class="d-flex align-items-center text-decoration-none p-2 rounded-3 bg-light hover-shadow">
                                <div class="avatar avatar-sm me-3">
                                    <div class="avatar-initial rounded" style="background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%);">
                                        <i class="fab fa-instagram text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-semibold text-dark">Instagram</p>
                                    <small class="text-muted">Voir le profil</small>
                                </div>
                                <i class="fas fa-external-link-alt text-muted"></i>
                            </a>
                            @endif

                            @if($user->linkedin_link)
                            <a href="{{ $user->linkedin_link }}" target="_blank" class="d-flex align-items-center text-decoration-none p-2 rounded-3 bg-light hover-shadow">
                                <div class="avatar avatar-sm me-3">
                                    <div class="avatar-initial rounded" style="background-color: #0077b5;">
                                        <i class="fab fa-linkedin-in text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-semibold text-dark">LinkedIn</p>
                                    <small class="text-muted">Voir le profil</small>
                                </div>
                                <i class="fas fa-external-link-alt text-muted"></i>
                            </a>
                            @endif

                            @if($user->youtube_link)
                            <a href="{{ $user->youtube_link }}" target="_blank" class="d-flex align-items-center text-decoration-none p-2 rounded-3 bg-light hover-shadow">
                                <div class="avatar avatar-sm me-3">
                                    <div class="avatar-initial rounded" style="background-color: #ff0000;">
                                        <i class="fab fa-youtube text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-semibold text-dark">YouTube</p>
                                    <small class="text-muted">Voir la chaîne</small>
                                </div>
                                <i class="fas fa-external-link-alt text-muted"></i>
                            </a>
                            @endif

                            @if($user->tiktok_link)
                            <a href="{{ $user->tiktok_link }}" target="_blank" class="d-flex align-items-center text-decoration-none p-2 rounded-3 bg-light hover-shadow">
                                <div class="avatar avatar-sm me-3">
                                    <div class="avatar-initial rounded" style="background-color: #000000;">
                                        <i class="fab fa-tiktok text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-semibold text-dark">TikTok</p>
                                    <small class="text-muted">Voir le profil</small>
                                </div>
                                <i class="fas fa-external-link-alt text-muted"></i>
                            </a>
                            @endif

                            @if($user->whatsapp_link)
                            <a href="{{ $user->whatsapp_link }}" target="_blank" class="d-flex align-items-center text-decoration-none p-2 rounded-3 bg-light hover-shadow">
                                <div class="avatar avatar-sm me-3">
                                    <div class="avatar-initial rounded" style="background-color: #25d366;">
                                        <i class="fab fa-whatsapp text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-semibold text-dark">WhatsApp</p>
                                    <small class="text-muted">Contacter</small>
                                </div>
                                <i class="fas fa-external-link-alt text-muted"></i>
                            </a>
                            @endif

                            @if($user->website_link)
                            <a href="{{ $user->website_link }}" target="_blank" class="d-flex align-items-center text-decoration-none p-2 rounded-3 bg-light hover-shadow">
                                <div class="avatar avatar-sm me-3">
                                    <div class="avatar-initial rounded bg-secondary">
                                        <i class="fas fa-globe text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-semibold text-dark">Site web personnel</p>
                                    <small class="text-muted">Visiter le site</small>
                                </div>
                                <i class="fas fa-external-link-alt text-muted"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Timeline d'activité -->
            @include('backend/layouts/includes/users/backend-pages-users-show-aside')
        </div>

        <!-- Contenu principal -->
        <div class="col-xl-8 col-lg-7">

            <!-- Informations personnelles -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-user me-2 text-primary"></i>
                        Informations personnelles
                    </h5>
                </div>
                <div class="card-body pt-2">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-sm">
                                        <div class="avatar-initial bg-primary bg-opacity-10 text-primary rounded">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form-label small text-muted mb-1">Nom complet</label>
                                    <p class="mb-0 fw-semibold">{{ $user->lastname }} {{ $user->firstname }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-sm">
                                        <div class="avatar-initial bg-info bg-opacity-10 text-info rounded">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form-label small text-muted mb-1">Email</label>
                                    <p class="mb-0 fw-semibold">{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-sm">
                                        <div class="avatar-initial bg-secondary bg-opacity-10 text-secondary rounded">
                                            <i class="{{ $user->getSexeIconAttribute() }}"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form-label small text-muted mb-1">Genre</label>
                                    <p class="mb-0 fw-semibold text-capitalize">{{ $user->sexe ? $user->getSexeFrAttribute() : 'Non spécifié' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-sm">
                                        <div class="avatar-initial bg-warning bg-opacity-10 text-warning rounded">
                                            <i class="fas fa-birthday-cake"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form-label small text-muted mb-1">Date de naissance</label>
                                    <p class="mb-0 fw-semibold">
                                        @if($user->birth_date)
                                            {{ \Carbon\Carbon::parse($user->birth_date)->locale(app()->getLocale())->isoFormat('D MMMM YYYY') }}
                                            <br>
                                            <small class="text-muted">({{ \Carbon\Carbon::parse($user->birth_date)->age }} ans)</small>
                                        @else
                                            <span class="text-muted">Non spécifiée</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-sm">
                                        <div class="avatar-initial bg-success bg-opacity-10 text-success rounded">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form-label small text-muted mb-1">Téléphone</label>
                                    <p class="mb-0 fw-semibold">
                                        @if($user->phone)
                                            <a href="tel:{{ $user->phone }}" class="text-decoration-none text-success">{{ $user->phone }}</a>
                                        @else
                                            <span class="text-muted">Non spécifié</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-sm">
                                        <div class="avatar-initial bg-danger bg-opacity-10 text-danger rounded">
                                            <i class="fas fa-flag"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form-label small text-muted mb-1">Pays</label>
                                    <p class="mb-0 fw-semibold">{{ $user->country->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations du compte -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-cog me-2 text-primary"></i>
                        Informations du compte
                    </h5>
                </div>
                <div class="card-body pt-2">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-sm">
                                        <div class="avatar-initial bg-secondary bg-opacity-10 text-secondary rounded">
                                            <i class="fas fa-key"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form-label small text-muted mb-1">Token</label>
                                    <p class="mb-0 fw-semibold">
                                        <code class="small">{{ $user->token }}</code>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-sm">
                                        <div class="avatar-initial {{ $user->is_active ? 'bg-success' : 'bg-danger' }} bg-opacity-10 {{ $user->is_active ? 'text-success' : 'text-danger' }} rounded">
                                            <i class="{{ $user->is_active ? 'fas fa-check' : 'fas fa-times' }}"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form-label small text-muted mb-1">État du compte</label>
                                    <p class="mb-0 fw-semibold">
                                        @if($user->is_active)
                                            <span class="text-success">Compte actif</span>
                                        @else
                                            <span class="text-danger">Compte désactivé</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-sm">
                                        <div class="avatar-initial {{ $user->email_verified_at ? 'bg-success' : 'bg-warning' }} bg-opacity-10 {{ $user->email_verified_at ? 'text-success' : 'text-warning' }} rounded">
                                            <i class="{{ $user->email_verified_at ? 'fas fa-check' : 'fas fa-exclamation-triangle' }}"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form-label small text-muted mb-1">Vérification email</label>
                                    <p class="mb-0 fw-semibold">
                                        @if($user->email_verified_at)
                                            <span class="text-success">Vérifié le</span><br>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($user->email_verified_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY, HH:mm') }}</small>
                                        @else
                                            <span class="text-warning">Non vérifié</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-sm">
                                        <div class="avatar-initial bg-primary bg-opacity-10 text-primary rounded">
                                            <i class="fas fa-shield-alt"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form-label small text-muted mb-1">Rôle</label>
                                    <p class="mb-0">
                                        <a href="{{ route('backend.roles.show', $user->role->token) }}" 
                                           class="text-decoration-none fw-semibold text-primary">
                                            {{ $user->role->label }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-sm">
                                        <div class="avatar-initial bg-info bg-opacity-10 text-info rounded">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form-label small text-muted mb-1">Date de création</label>
                                    <p class="mb-0 fw-semibold">
                                        {{ mb_convert_case(\Carbon\Carbon::parse($user->created_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY'), MB_CASE_TITLE, "UTF-8") }}
                                    </p>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($user->created_at)->locale(app()->getLocale())->isoFormat('HH:mm:ss') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-sm">
                                        <div class="avatar-initial bg-warning bg-opacity-10 text-warning rounded">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form-label small text-muted mb-1">Dernière modification</label>
                                    <p class="mb-0 fw-semibold">
                                        {{ mb_convert_case(\Carbon\Carbon::parse($user->updated_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY'), MB_CASE_TITLE, "UTF-8") }}
                                    </p>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($user->updated_at)->locale(app()->getLocale())->isoFormat('HH:mm:ss') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card border-0 shadow-sm mb-4">
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
                                <a href="{{ route('backend.users.edit', $user->token) }}" 
                                   class="btn btn-outline-primary d-flex align-items-center justify-content-center py-3">
                                    <i class="fas fa-edit me-2"></i>
                                    Modifier le profil
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-grid">
                                <button type="button" 
                                        class="btn btn-outline-info d-flex align-items-center justify-content-center py-3">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Envoyer notification
                                </button>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-grid">
                                <button type="button" 
                                        class="btn btn-outline-danger d-flex align-items-center justify-content-center py-3 suspend-user">
                                    <i class="fas fa-trash me-2"></i>
                                    Supprimer le compte
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inclure le code d'affichage des images et vidéos -->
            @include('backend/layouts/includes/others/_show_media', ['model' => $user])

        </div>
    </div>
</div>
<!-- / Content -->
@endsection()