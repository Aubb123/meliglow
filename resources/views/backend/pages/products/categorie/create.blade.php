@extends('backend/layouts/app')

@section('title')
    dashboard - catégories - create
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
                    <h5 class="card-header">Formulaire de création</h5> <hr class="m-0 p-0">
                    <div class="card-body demo-vertical-spacing demo-only-element">
                        <form action="{{ route('backend.product_categories.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text" placeholder="Exemple : Perruques, Huiles capillaires..." value="{{ old('name') }}" required>
                                        <label for="name">Nom de la catégorie</label>
                                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline mb-6">
                                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Description de la catégorie" rows="5">{{ old('description') }}</textarea>
                                        <label for="description">Description <span class="text-muted">(optionnelle)</span></label>
                                        @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-sm-12">
                                    <a href="{{ route('backend.product_categories.index') }}" class="btn btn-outline-secondary waves-effect me-2">Annuler</a>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Créer</button>
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
        var initialContent = "Description de la catégorie";
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