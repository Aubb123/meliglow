@extends('backend/layouts/app')

@section('title')
    dashboard/contacts/show
@endsection()

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header avec titre et actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold text-primary mb-1">Détails du contact</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.contacts.index') }}">Contacts</a></li>
                            <li class="breadcrumb-item active">{{$contact->fullname}}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <form method="POST" id="delete-form-{{$contact->token}}" action="{{ route('backend.contacts.destroy', $contact->token) }}" class="d-inline">
                        @csrf
                        @method('delete')
                        <a href="{{ route('backend.contacts.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="ri-arrow-left-line me-1"></i>Retour
                        </a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('{{$contact->token}}', 'Êtes-vous sûr de vouloir supprimer ce contact ?')">
                            <i class="ri-delete-bin-6-line me-1"></i>Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Carte principale - Message du contact -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white mb-4">
                    <h5 class="mb-0 ">
                        <i class="ri-message-3-line me-2"></i>
                        Message de {{$contact->fullname}}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-light border-start border-primary border-4 mb-0">
                        <p class="mb-0 fs-6">{{ $contact->message }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations de contact -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="ri-contacts-line me-2"></i>
                        Informations de contact
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted">
                                <i class="ri-user-line me-1"></i>Nom complet
                            </label>
                            <div class="form-control-plaintext bg-light rounded p-2 border">
                                {{ $contact->fullname }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted">
                                <i class="ri-mail-line me-1"></i>Email
                            </label>
                            <div class="form-control-plaintext bg-light rounded p-2 border">
                                <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                    {{ $contact->email }}
                                </a>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted">
                                <i class="ri-phone-line me-1"></i>Numéro de téléphone
                            </label>
                            <div class="form-control-plaintext bg-light rounded p-2 border">
                                <a href="tel:{{ $contact->phone }}" class="text-decoration-none">
                                    {{ $contact->phone }}
                                </a>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted">
                                <i class="ri-price-tag-3-line me-1"></i>Objet
                            </label>
                            <div class="form-control-plaintext bg-light rounded p-2 border">
                                @if($contact->objet)
                                    <span class="badge bg-primary">{{ $contact->objet->label }}</span>
                                @else
                                    <span class="text-muted fst-italic">Aucun objet spécifié</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations système -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="ri-information-line me-2"></i>
                        Informations système
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted">
                                <i class="ri-user-settings-line me-1"></i>Compte utilisateur
                            </label>
                            <div class="form-control-plaintext bg-light rounded p-2 border">
                                @if($contact->user)
                                    <a href="{{ route('backend.users.show', $contact->user->token) }}" class="text-decoration-none">
                                        <i class="ri-external-link-line me-1"></i>
                                        {{ $contact->user->lastname }} {{ $contact->user->firstname }}
                                    </a>
                                @else
                                    <span class="text-muted fst-italic">Aucun compte associé</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted">
                                <i class="ri-calendar-line me-1"></i>Date de création
                            </label>
                            <div class="form-control-plaintext bg-light rounded p-2 border">
                                <span class="text-success">
                                    {{ mb_convert_case(\Carbon\Carbon::parse($contact->created_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY - HH:mm:ss'), MB_CASE_TITLE, 'UTF-8') }}
                                </span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted">
                                <i class="ri-time-line me-1"></i>Dernière modification
                            </label>
                            <div class="form-control-plaintext bg-light rounded p-2 border">
                                <span class="text-info">
                                    {{ mb_convert_case(\Carbon\Carbon::parse($contact->updated_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY - HH:mm:ss'), MB_CASE_TITLE, 'UTF-8') }}
                                </span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted">
                                <i class="ri-fingerprint-line me-1"></i>Identifiant
                            </label>
                            <div class="form-control-plaintext bg-light rounded p-2 border">
                                <code class="text-muted">{{ $contact->token }}</code>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides (optionnel) -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light mb-4">
                    <h5 class="mb-0">
                        <i class="ri-tools-line me-2"></i>
                        Actions rapides
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="mailto:{{ $contact->email }}" class="btn btn-outline-primary">
                            <i class="ri-mail-send-line me-1"></i>Répondre par email
                        </a>
                        <a href="tel:{{ $contact->phone }}" class="btn btn-outline-success">
                            <i class="ri-phone-line me-1"></i>Appeler
                        </a>
                        @if($contact->user)
                            <a href="{{ route('backend.users.show', $contact->user->token) }}" class="btn btn-outline-info">
                                <i class="ri-user-line me-1"></i>Voir le profil utilisateur
                            </a>
                        @endif
                        <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                            <i class="ri-printer-line me-1"></i>Imprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->

<style>
@media print {
    .btn, .card-header { display: none !important; }
    .card { border: 1px solid #dee2e6 !important; }
}
</style>
@endsection()