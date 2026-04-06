<!-- En-tête de page -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div>
                        <h4 class="mb-1 fw-bold text-dark">Détails de la plateforme cloud : <strong class="text-primary"> {{ $platform->label }} </strong></h4>
                        <p class="mb-0 text-muted">Consultez et gérez les informations de la plateforme</p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('backend.cloud_platforms.show', $platform->token) }}" class="btn btn-outline-info d-flex align-items-center">
                            <i class="fas fa-eye me-2"></i>
                            Voir
                        </a>
                        
                        <a href="{{ route('backend.cloud_platforms.cloud_folders', $platform->token) }}" class="btn btn-outline-secondary d-flex align-items-center">
                            <i class="fas fa-folder-open me-2"></i>
                            Dossiers associés
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>