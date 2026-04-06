<!-- En-tête de page -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div>
                        <h4 class="mb-1 fw-bold text-dark">Profil utilisateur: <strong class="text-primary">{{ $user->lastname }} {{ $user->firstname }}</strong></h4>
                        <p class="mb-0 text-muted">Consultez et gérez les informations de l'utilisateur</p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('backend.users.edit', $user->token) }}" class="btn btn-primary d-flex align-items-center">
                            <i class="fas fa-edit me-2"></i>
                            Modifier
                        </a>
                        <button type="button" class="btn btn-outline-danger d-flex align-items-center suspend-user">
                            <i class="fas fa-trash me-2"></i>
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>