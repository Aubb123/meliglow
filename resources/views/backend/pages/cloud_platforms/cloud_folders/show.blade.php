@extends('backend/layouts/app')

@section('title')
    Cloud Folders - Show
@endsection()

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row g-4">

        <!-- Contenu principal -->
        <div class="col-xl-8 col-lg-7">

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">

                    <!-- Titre -->
                    <div class="mb-4">
                        <h2 class="fw-bold text-dark mb-2">
                            <i class="fas fa-folder text-warning me-2"></i>
                            {{ $folder->folder_name }}
                        </h2>

                        <small class="text-muted">
                            {{ $folder->path ?? 'Dossier racine' }}
                        </small>
                    </div>

                    <!-- Informations principales -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            Informations du dossier
                        </h6>

                        <div class="bg-light rounded-3 p-4">
                            <div class="row g-3">

                                <!-- ID interne -->
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">ID interne</label>
                                    <p class="mb-0 fw-semibold">
                                        {{ $folder->id }}
                                    </p>
                                </div>

                                <!-- ID Cloud -->
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">ID Cloud</label>
                                    <p class="mb-0 fw-semibold font-monospace">
                                        {{ $folder->folder_id ?? 'Non synchronisé' }}
                                    </p>
                                </div>

                                <!-- Dossier parent -->
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Dossier parent</label>
                                    <p class="mb-0 fw-semibold">
                                        {{ optional($folder->parentFolder)->folder_name ?? 'Aucun (Racine)' }}
                                    </p>
                                </div>

                                <!-- Plateforme -->
                                <div class="col-md-6">
                                    <label class="form-label small text-muted mb-1">Plateforme</label>
                                    <p class="mb-0 fw-semibold">
                                        {{ optional($folder->cloudPlatform)->name ?? 'Non définie' }}
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Métadonnées -->
                    @if($folder->metadata)
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                                <i class="fas fa-database me-2 text-primary"></i>
                                Métadonnées
                            </h6>
                            <div class="bg-light rounded-3 p-4">
                                <pre class="mb-0" style="font-size: 0.85rem; white-space: pre-wrap;">
                                    {{ json_encode($folder->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
                                </pre>
                            </div>
                        </div>
                    @endif

                    <!-- Bouton retour -->
                    <div class="border-top pt-4">
                        <a href="{{ route('backend.cloud_platforms.cloud_folders', ['token' => $folder->cloudPlatform->token]) }}"
                           class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Retour à la liste
                        </a>
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
                        <i class="fas fa-key me-2 text-primary"></i>
                        Informations générales
                    </h5>
                </div>

                <div class="card-body pt-2">

                    <!-- Token -->
                    <div class="p-3 bg-light rounded-3 mb-3">
                        <label class="form-label small text-muted mb-1">Token</label>
                        <p class="mb-0 fw-semibold font-monospace" style="font-size: 0.8rem; word-break: break-all;">
                            {{ $folder->token }}
                        </p>
                    </div>

                    <!-- Nombre de sous-dossiers -->
                    <div class="p-3 bg-light rounded-3">
                        <label class="form-label small text-muted mb-1">Sous-dossiers</label>
                        <p class="mb-0 fw-semibold">
                            {{ $folder->children()->count() }}
                        </p>
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
                    <div class="p-3 bg-light rounded-3 mb-3">
                        <label class="form-label small text-muted mb-1">Date de création</label>
                        <p class="mb-0 fw-semibold">
                            {{ \Carbon\Carbon::parse($folder->created_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY') }}
                        </p>
                        <small class="text-muted">
                            {{ \Carbon\Carbon::parse($folder->created_at)->isoFormat('HH:mm:ss') }}
                        </small>
                    </div>

                    <!-- Modifié le -->
                    <div class="p-3 bg-light rounded-3">
                        <label class="form-label small text-muted mb-1">Dernière modification</label>
                        <p class="mb-0 fw-semibold">
                            {{ \Carbon\Carbon::parse($folder->updated_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY') }}
                        </p>
                        <small class="text-muted">
                            {{ \Carbon\Carbon::parse($folder->updated_at)->isoFormat('HH:mm:ss') }}
                        </small>
                    </div>

                </div>
            </div>

            <!-- Bouton de suppression -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-3">
                    <form id="delete-form-{{$folder->token}}" action="{{ route('backend.cloud_folders.destroy', ['token' => $folder->token]) }}" method="POST" >
                        @csrf
                        @method('delete')

                        <!-- Suppression définitive -->
                        <div class="mb-3">
                            <label class="form-check-label" for="deleteForeverCheckbox">
                                Supprimer définitivement ?
                            </label>
                            <select class="form-select form-select-sm" id="deleteForeverSelect" name="delete_forever">
                                <option value="1" >Oui</option>
                                <option value="0" selected>Non (déplace dans la corbeille)</option>
                            </select>
                        </div>

                        <button type="button" class="btn btn-danger w-100" onclick="confirmDelete('{{$folder->token}}', 'Êtes-vous sûr de vouloir supprimer ce dossier ?')">
                            <i class="fas fa-trash me-2"></i>
                            Supprimer le dossier
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <div class="col-12">
            <div class="card">
                @include('backend/layouts/includes/cloud_platforms/cloud_folders/_backend-pages-cloud_folders-index-table', ['cloud_folders' => $cloudFolders, 'platform' => $platform])
            </div>
        </div>

    </div>
</div>
<!-- / Content -->
@endsection()