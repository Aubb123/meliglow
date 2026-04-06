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
                        <form action="{{ route('backend.categories.update', $categorie->token) }}" method="POST" enctype="multipart/form-data" >
                            @csrf
                            @method('put')
                            <div class="row">   
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input class="form-control" id="name" name="name" type="text" placeholder="{{ $categorie->name }}" value="{{ old('name', $categorie->name) }}" required>
                                        <label for="name">Nom de la catégorie</label>
                                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input class="form-control" id="path_img" name="path_img" type="file" value="{{ old('path_img', $categorie->path_img) }}" accept=".png, .jpg">
                                        <label for="path_img">Image de la catégorie</label>
                                        <div class="d-flex">
                                            <img src="{{ asset(getEnvFolder() . $categorie->path_img)}}" alt="Aperçu de l'image actuel" style="max-height: 80px; border: 1px solid #ddd; padding: 4px; border-radius: 4px;" />
                                            <img id="previewImg" src="#" alt="Aperçu de l'image" style="display: none; max-height: 80px; border: 1px solid #ddd; padding: 4px; border-radius: 4px;" />
                                        </div>
                                        @error('path_img') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="form-floating form-floating-outline mb-6">
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="10" required></textarea>
                                    <label for="description">Description</label>
                                    @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Sauvegarder</button>
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
        var initialContent = "{!! addslashes($categorie->description) !!}";
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

        // Script pour afficher le bouton de chargement après soumission du formulaire
        document.getElementById('form').addEventListener('submit', function(e) {
            e.preventDefault();
            document.getElementById('formButton').style.display = 'none';
            document.getElementById('loader').style.display = 'block';
            this.submit();
        });
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