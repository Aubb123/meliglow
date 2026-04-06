@extends('backend/layouts/app')

@section('title')
    dashboard/catégories/edit
@endsection()

@section('style')
    <script src="{{ asset(getEnvFolder() . 'others/backend/summernote/jquery-3.5.1.min.js')}}"></script>
    <script src="{{ asset(getEnvFolder() . 'others/backend/summernote/popper.min.js')}}"></script>

    <script src="{{ asset(getEnvFolder() . 'others/backend/summernote/bootstrap.min.js')}}"></script>

    <link href="{{ asset(getEnvFolder() . 'others/backend/summernote/summernote-bs4.min.css')}}" rel="stylesheet">
    <script src="{{ asset(getEnvFolder() . 'others/backend/summernote/summernote-bs4.min.js')}}"></script>
@endsection

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-6">
            <!-- Gamification Card -->
            <div class="col-md-12 col-xxl-12">
                <div class="card">
                    <h5 class="card-header">Formulaire de modification</h5> <hr class="m-0 p-0">
                    <div class="card-body demo-vertical-spacing demo-only-element">
                        <form action="{{ route('backend.products.update', $product->token) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-4">

                                {{-- Colonne principale --}}
                                <div class="col-lg-8">

                                    {{-- Informations générales --}}
                                    <div class="card border-0 shadow-sm mb-4">
                                        <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
                                            <h5 class="mb-0 fw-bold d-flex align-items-center">
                                                <i class="fas fa-box me-2 text-primary"></i>
                                                Informations générales
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            {{-- Nom --}}
                                            <div class="form-floating form-floating-outline mb-4">
                                                <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text" placeholder="Nom du produit" value="{{ old('name', $product->name) }}" required >
                                                <label for="name">Nom du produit</label>
                                                @error('name')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- Catégorie --}}
                                            <div class="form-floating form-floating-outline mb-4">
                                                <select class="form-select @error('product_categorie_token') is-invalid @enderror" id="product_categorie_token" name="product_categorie_token" required >
                                                    <option value="{{ $category->token }}" {{ old('product_categorie_token') == $category->token ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                </select>
                                                <label for="product_categorie_token">Catégorie</label>
                                                @error('product_categorie_token')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- Description --}}
                                            <div class="form-floating form-floating-outline mb-4">
                                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description du produit" rows="5" style="height: 150px" required >{{ old('description', $product->description) }}</textarea>
                                                <label for="description">Description</label>
                                                @error('description')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Prix --}}
                                    <div class="card border-0 shadow-sm mb-4">
                                        <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
                                            <h5 class="mb-0 fw-bold d-flex align-items-center">
                                                <i class="fas fa-tags me-2 text-primary"></i>
                                                Prix
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                {{-- Prix d'achat --}}
                                                <div class="col-md-4">
                                                    <div class="form-floating form-floating-outline">
                                                        <input class="form-control @error('purchase_price') is-invalid @enderror" id="purchase_price" name="purchase_price" type="number" step="0.01" min="0" placeholder="0" value="{{ old('purchase_price', $product->purchase_price) }}" required>
                                                        <label for="purchase_price">Prix d'achat (FCFA)</label>
                                                        @error('purchase_price')
                                                            <div class="text-danger small">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                {{-- Prix de vente --}}
                                                <div class="col-md-4">
                                                    <div class="form-floating form-floating-outline">
                                                        <input class="form-control @error('sale_price') is-invalid @enderror" id="sale_price" name="sale_price" type="number" step="0.01" min="0" placeholder="0" value="{{ old('sale_price', $product->sale_price) }}" required>
                                                        <label for="sale_price">Prix de vente (FCFA)</label>
                                                        @error('sale_price')
                                                            <div class="text-danger small">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                {{-- Prix promotionnel --}}
                                                <div class="col-md-4">
                                                    <div class="form-floating form-floating-outline">
                                                        <input class="form-control @error('promotional_price') is-invalid @enderror" id="promotional_price" name="promotional_price" type="number" step="0.01" min="0" placeholder="0" value="{{ old('promotional_price', $product->promotional_price) }}">
                                                        <label for="promotional_price">Prix promo (FCFA) <span class="text-muted">(optionnel)</span></label>
                                                        @error('promotional_price')
                                                            <div class="text-danger small">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Sidebar --}}
                                <div class="col-lg-4">

                                    {{-- Statistiques --}}
                                    <div class="card border-0 shadow-sm mb-4">
                                        <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
                                            <h5 class="mb-0 fw-bold d-flex align-items-center">
                                                <i class="fas fa-chart-bar me-2 text-primary"></i>
                                                Statistiques
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-center p-3 bg-light rounded-3 mb-3">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-sm">
                                                        <div class="avatar-initial bg-info bg-opacity-10 text-info rounded">
                                                            <i class="fas fa-eye"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <label class="form-label small text-muted mb-1">Vues</label>
                                                    <p class="mb-0 fw-semibold">{{ $product->views }}</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-sm">
                                                        <div class="avatar-initial bg-success bg-opacity-10 text-success rounded">
                                                            <i class="fas fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <label class="form-label small text-muted mb-1">Créé le</label>
                                                    <p class="mb-0 fw-semibold">{{ \Carbon\Carbon::parse($product->created_at)->format('d/m/Y') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Stock & Visibilité --}}
                                    <div class="card border-0 shadow-sm mb-4">
                                        <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2">
                                            <h5 class="mb-0 fw-bold d-flex align-items-center">
                                                <i class="fas fa-cog me-2 text-primary"></i>
                                                Stock & Visibilité
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            {{-- Stock --}}
                                            <div class="form-floating form-floating-outline mb-4">
                                                <input class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" type="number" min="0" placeholder="0" value="{{ old('stock', $product->stock) }}" required>
                                                <label for="stock">Quantité en stock</label>
                                                @error('stock')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- Visibilité --}}
                                            <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
                                                <div>
                                                    <p class="mb-0 fw-semibold">Visibilité</p>
                                                    <small class="text-muted">Publier ou garder en brouillon</small>
                                                </div>
                                                <div class="form-check form-switch mb-0">
                                                    <input class="form-check-input" type="checkbox" id="is_visible" name="is_visible" value="1" {{ old('is_visible', $product->is_visible) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_visible"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Boutons --}}
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-grid gap-2">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                    <i class="fas fa-save me-2"></i>
                                                    Mettre à jour
                                                </button>
                                                <a href="{{ route('backend.products.show', $product->token) }}" class="btn btn-outline-secondary waves-effect">
                                                    Annuler
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--/ Gamification Card -->
        </div>
    </div>
    <!-- / Content -->
@endsection()

@section('summernote')
    @if(app()->getLocale() == 'fr')
        <script src="{{ asset(getEnvFolder() . 'others/backend/summernote/lang/summernote-fr-FR.js')}}"></script>
    @endif
    <script>
        var initialContent = "{!! addslashes($product->description) !!}";
        $('#description').summernote({
            tabsize: 2,
            height: 200,
            lang: 'fr-FR',
            toolbar: [
                ['history', ['undo', 'redo']],
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear', 'strikethrough', 'superscript', 'subscript']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ]
        });
        $('#description').summernote('code', initialContent);
    </script>
@endsection()

@section('script')
    <script>
        // Script pour prévisualiser l'image sélectionner 
        document.getElementById('path_img').addEventListener('change', function(event) {
            const input = event.target;
            const preview = document.getElementById('previewImg');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
                preview.src = '#';
            }
        });
    </script>
@endsection()