<!-- Statistiques résumées -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
        <h5 class="mb-0 fw-bold d-flex align-items-center">
            <i class="fas fa-chart-bar me-2 text-primary"></i>
            Résumé
        </h5>
    </div>
    <div class="card-body pt-2">
        <div class="row g-3">
            <div class="col-12">
                <div class="bg-primary bg-opacity-10 rounded-3 p-3 text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div class="avatar avatar-sm">
                            <div class="avatar-initial bg-primary text-white rounded">
                                <i class="fas fa-code"></i>
                            </div>
                        </div>
                    </div>
                    <h5 class="mb-1 fw-bold text-primary">{{ $continent->code }}</h5>
                    <small class="text-muted">Code continent</small>
                </div>
            </div>
            <div class="col-6">
                <div class="bg-info bg-opacity-10 rounded-3 p-3 text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div class="avatar avatar-sm">
                            <div class="avatar-initial bg-info text-white rounded">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                    <h6 class="mb-1 fw-bold text-info">{{ $continent->population ? number_format($continent->population / 1000000, 1) . 'M' : 'N/A' }}</h6>
                    <small class="text-muted">Population</small>
                </div>
            </div>
            <div class="col-6">
                <div class="bg-success bg-opacity-10 rounded-3 p-3 text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div class="avatar avatar-sm">
                            <div class="avatar-initial bg-success text-white rounded">
                                <i class="fas fa-map"></i>
                            </div>
                        </div>
                    </div>
                    <h6 class="mb-1 fw-bold text-success">{{ $continent->area ? number_format($continent->area / 1000000, 1) . 'M' : 'N/A' }}</h6>
                    <small class="text-muted">km²</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Informations principales -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
        <h5 class="mb-0 fw-bold d-flex align-items-center">
            <i class="fas fa-info-circle me-2 text-primary"></i>
            Informations principales
        </h5>
    </div>
    <div class="card-body pt-2">
        <div class="d-flex align-items-center p-3 bg-light rounded-3 mb-3">
            <div class="flex-shrink-0 me-3">
                <div class="avatar avatar-sm">
                    <div class="avatar-initial {{ $continent->is_active ? 'bg-success' : 'bg-danger' }} bg-opacity-10 {{ $continent->is_active ? 'text-success' : 'text-danger' }} rounded">
                        <i class="{{ $continent->is_active ? 'fas fa-check-circle' : 'fas fa-times-circle' }}"></i>
                    </div>
                </div>
            </div>
            <div class="flex-grow-1">
                <label class="form-label small text-muted mb-1">État</label>
                <p class="mb-0 fw-semibold">
                    @if($continent->is_active)
                        <span class="text-success">Actif</span>
                    @else
                        <span class="text-danger">Inactif</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="d-flex align-items-center p-3 bg-light rounded-3 mb-3">
            <div class="flex-shrink-0 me-3">
                <div class="avatar avatar-sm">
                    <div class="avatar-initial bg-secondary bg-opacity-10 text-secondary rounded">
                        <i class="fas fa-sort"></i>
                    </div>
                </div>
            </div>
            <div class="flex-grow-1">
                <label class="form-label small text-muted mb-1">Ordre d'affichage</label>
                <p class="mb-0 fw-semibold">{{ $continent->sort_order }}</p>
            </div>
        </div>

        <div class="d-flex align-items-center p-3 bg-light rounded-3">
            <div class="flex-shrink-0 me-3">
                <div class="avatar avatar-sm">
                    <div class="avatar-initial bg-warning bg-opacity-10 text-warning rounded">
                        <i class="fas fa-link"></i>
                    </div>
                </div>
            </div>
            <div class="flex-grow-1">
                <label class="form-label small text-muted mb-1">Token</label>
                <p class="mb-0 fw-semibold text-break">{{ $continent->token }}</p>
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
                    {{ mb_convert_case(\Carbon\Carbon::parse($continent->created_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY'), MB_CASE_TITLE, 'UTF-8') }}
                </p>
                <small class="text-muted">{{ \Carbon\Carbon::parse($continent->created_at)->locale(app()->getLocale())->isoFormat('HH:mm:ss') }}</small>
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
                    {{ mb_convert_case(\Carbon\Carbon::parse($continent->updated_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY'), MB_CASE_TITLE, 'UTF-8') }}
                </p>
                <small class="text-muted">{{ \Carbon\Carbon::parse($continent->updated_at)->locale(app()->getLocale())->isoFormat('HH:mm:ss') }}</small>
            </div>
        </div>
    </div>
</div>