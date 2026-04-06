<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div>
                        <h4 class="mb-1 fw-bold text-dark">Détails du continent: <strong class="text-primary" >{{ $continent->name }}</strong></h4>
                        <p class="mb-0 text-muted">Consultez et gérez les informations du continent</p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('backend.continents.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
                            <i class="fas fa-arrow-left me-2"></i>
                            Retour
                        </a>
                        <a href="{{ route('backend.continents.edit', $continent->token) }}" class="btn btn-primary d-flex align-items-center">
                            <i class="fas fa-edit me-2"></i>
                            Modifier
                        </a>
                        <!-- Bouton pour afficher les pays -->
                        <a href="{{ route('backend.continents.countries', $continent->token) }}" class="btn btn-outline-primary d-flex align-items-center">
                            <i class="fas fa-globe me-2"></i>
                            Voir les pays {{ $continent->countries->count() > 0 ? '(' . $continent->countries->count() . ')' : '' }}
                        </a>
                        <form method="POST" id="delete-form-{{$continent->token}}" action="#" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-outline-danger d-flex align-items-center" onclick="confirmDelete('{{$continent->token}}', 'Êtes-vous sûr de vouloir supprimer ce continent ?')">
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