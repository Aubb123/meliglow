@extends('backend/layouts/app')

@section('title')
    dashboard/comments/show
@endsection()

@section('content')
<!-- Content -->
<div class="container-fluid py-4">
    <!-- Header avec navigation -->
    <div class="row mb-4">
        <div class="col-12">
            @include('backend/layouts/includes/blogs/backend-pages-blogs-show-navbar')
        </div>
    </div>

    <!-- Commentaire principal -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white d-flex align-items-center">
                    <i class="fas fa-comment-dots me-2"></i>
                    <h5 class="mb-0">Détails du commentaire</h5>
                    @if($comment->is_visible == false)
                        <span class="badge bg-danger ms-auto">Masqué</span>
                    @else
                        <span class="badge bg-success ms-auto">Visible</span>
                    @endif
                </div>
                <div class="card-body p-0">
                    <div class="comment-container p-4 @if($comment->is_visible == false) bg-light border-start border-danger border-4 @endif">
                        <div class="d-flex align-items-start">
                            <!-- Avatar utilisateur -->
                            <div class="flex-shrink-0 me-3">
                                <img src="{{ $comment->user->getCoverImageUrl()['url_img'] }}" alt="Avatar" class="rounded-circle shadow-sm" width="50" height="50" style="object-fit: cover;">
                            </div>
                            
                            <!-- Contenu du commentaire -->
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-2">
                                    <a href="{{ route('backend.users.show', $comment->user->token) }}" 
                                       class="fw-bold text-decoration-none text-primary me-2">
                                        {{$comment->user->lastname}} {{$comment->user->firstname}}
                                    </a>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ mb_convert_case(\Carbon\Carbon::parse($comment->created_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY - HH:mm:ss'), MB_CASE_TITLE, "UTF-8") }}
                                    </small>
                                </div>
                                
                                <div class="comment-content">
                                    <p class="mb-0 lh-base">{{$comment->content}}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="mt-3 pt-3 border-top">
                            <form method="POST" id="delete-form-{{$comment->token}}" action="{{ route('backend.comments.destroy', $comment->token) }}" class="d-inline">
                                @csrf
                                @method('delete')
                                <a href="{{ route('backend.comments.show', $comment->token) }}" 
                                   class="btn btn-outline-info btn-sm me-2">
                                    <i class="fas fa-eye me-1"></i>Voir
                                </a>
                                <button type="button" 
                                        class="btn btn-outline-danger btn-sm" 
                                        onclick="confirmDelete('{{$comment->token}}', 'Êtes-vous sûr de vouloir supprimer ce commentaire ?')">
                                    <i class="fas fa-trash me-1"></i>Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Informations du commentaire -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-light d-flex align-items-center">
                    <i class="fas fa-info-circle me-2 text-info"></i>
                    <h6 class="mb-0 fw-semibold">Informations du commentaire</h6>
                </div>
                <div class="card-body">
                    <!-- État -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">État du commentaire</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                @if($comment->is_visible == false)
                                    <i class="fas fa-eye-slash text-danger"></i>
                                @else
                                    <i class="fas fa-eye text-success"></i>
                                @endif
                            </span>
                            <input type="text" 
                                   class="form-control" 
                                   value="@if($comment->is_visible == false)Commentaire masqué @else Commentaire visible @endif" 
                                   readonly>
                        </div>
                    </div>

                    <!-- Auteur -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Auteur</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user text-primary"></i>
                            </span>
                            <a href="{{ route('backend.users.show', $comment->user->token) }}" class="text-decoration-none">
                                <input class="form-control" type="text" value="{{ $comment->user->lastname }} {{ $comment->user->firstname }}" readonly>
                            </a>
                        </div>
                    </div>

                    <!-- Blog associé -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Article associé</label>
                        @if($comment->commentable_type == 'App\Models\Blog')
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-blog text-warning"></i>
                                </span>
                                <a href="{{ route('backend.blogs.show', $comment->commentable ? $comment->commentable->token : 'null') }}" 
                                   class="text-decoration-none">
                                    <input class="form-control" 
                                           type="text" 
                                           value="{{ $comment->commentable->title }}" 
                                           readonly>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Dates et métadonnées -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-light d-flex align-items-center">
                    <i class="fas fa-calendar-alt me-2 text-success"></i>
                    <h6 class="mb-0 fw-semibold">Métadonnées</h6>
                </div>
                <div class="card-body">
                    <!-- Date de création -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Date de création</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-plus-circle text-success"></i>
                            </span>
                            <input class="form-control" 
                                   type="text" 
                                   value="{{ mb_convert_case(\Carbon\Carbon::parse($comment->created_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY - HH:mm:ss'), MB_CASE_TITLE, 'UTF-8') }}" 
                                   readonly>
                        </div>
                    </div>

                    <!-- Dernière modification -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Dernière modification</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-edit text-info"></i>
                            </span>
                            <input class="form-control" 
                                   type="text" 
                                   value="{{ mb_convert_case(\Carbon\Carbon::parse($comment->updated_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY - HH:mm:ss'), MB_CASE_TITLE, 'UTF-8') }}" 
                                   readonly>
                        </div>
                    </div>

                    <!-- Statistiques supplémentaires -->
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="fs-4 fw-bold text-primary">{{strlen($comment->content)}}</div>
                                <small class="text-muted">Caractères</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="fs-4 fw-bold text-success">{{str_word_count($comment->content)}}</div>
                                <small class="text-muted">Mots</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire de modification -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-warning text-white d-flex align-items-center">
                    <i class="fas fa-edit me-2"></i>
                    <h5 class="mb-0">Modifier le commentaire</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.comments.update', $comment->token) }}" method="POST">
                        @csrf
                        @method('put')
                        
                        <div class="row">
                            <div class="col-md-8 mx-auto">
                                <div class="mb-4">
                                    <label for="is_visible" class="form-label fw-semibold">
                                        <i class="fas fa-toggle-on me-2 text-primary"></i>
                                        État du commentaire
                                    </label>
                                    <select class="form-select form-select-lg" name="is_visible" id="is_visible" required>
                                        <option value="0" {{ old('is_visible', $comment->is_visible) == 0 ? 'selected' : '' }}>
                                            🔒 Commentaire masqué
                                        </option>
                                        <option value="1" {{ old('is_visible', $comment->is_visible) == 1 ? 'selected' : '' }}>
                                            👁️ Commentaire visible
                                        </option>
                                    </select>
                                    @error('is_visible') 
                                        <div class="text-danger mt-2">
                                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                        </div> 
                                    @enderror
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-warning btn-lg">
                                        <i class="fas fa-save me-2"></i>
                                        Sauvegarder les modifications
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107, #e0a800);
}

.comment-container {
    transition: all 0.3s ease;
}

.comment-container:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.card {
    transition: all 0.3s ease;
    border-radius: 12px;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.input-group-text {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
}

.form-select:focus, .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
}
</style>
<!-- / Content -->
@endsection()