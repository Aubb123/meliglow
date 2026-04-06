@extends('backend/layouts/app')

@section('title')
    dashboard/blogs/edit
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
                        <form action="{{ route('backend.blogs.update', $blog->token) }}" method="POST" enctype="multipart/form-data" >
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-md-6">   
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input class="form-control" id="title" name="title" type="text" placeholder="{{$blog->title}}" value="{{ old('title', $blog->title) }}" required>
                                        <label for="title">Titre du blog</label>
                                        @error('title') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input class="form-control" id="time_read" name="time_read" type="text" placeholder="Ex: 2, 1, 5" value="{{ old('time_read', $blog->time_read) }}" required>
                                        <label for="time_read">Temps de lecture</label>
                                        @error('time_read') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">   
                                    <div class="form-floating form-floating-outline mb-6">
                                        <select class="form-control" name="is_visible" id="is_visible" required>
                                            <option selected></option>
                                            <option class="text-secondary" value="0" {{ old('is_visible', $blog->is_visible) == '0' ? 'selected' : '' }}>Blog masquer</option>
                                            <option class="text-secondary" value="1" {{ old('is_visible', $blog->is_visible) == '1' ? 'selected' : '' }}>Blog démasquer</option>
                                        </select>                                        
                                        <label for="is_visible">État du blog</label>
                                        @error('is_visible') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="form-floating form-floating-outline mb-6">
                                        <select class="form-control" name="categorie_token" id="categorie_token" required>
                                            <option selected></option>
                                            @foreach($categories as $categorie)
                                                <option class="text-secondary" value="{{ $categorie->token }}" {{ old('categorie_token', $blog->categorie->token) == $categorie->token ? 'selected' : '' }}>
                                                    {{ $categorie->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="categorie_token">Catégorie</label>
                                        @error('categorie_token') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="form-floating form-floating-outline mb-6">
                                    <input class="form-control" id="path_img" name="path_img" type="file" value="{{ old('path_img', $blog->path_img) }}" accept=".png, .jpg" >
                                    <label for="path_img">Image du blog</label>
                                    <div class="d-flex">
                                        <img src="{{ asset(getEnvFolder() . $blog->path_img )}}" alt="Aperçu de l'image actuel" style="max-height: 80px; border: 1px solid #ddd; padding: 4px; border-radius: 4px;" />
                                        <img id="previewImg" src="#" alt="Aperçu de l'image" style="display: none; max-height: 80px; border: 1px solid #ddd; padding: 4px; border-radius: 4px;" />
                                    </div>
                                    @error('path_img') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                                <div class="form-floating form-floating-outline mb-6">
                                    <textarea class="form-control" name="content" id="description" cols="30" rows="10" required></textarea>
                                    <label for="content">Contenu du blog</label>
                                    @error('content') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                                <div class="form-floating-outline mb-6">
                                    <label for="tags_token">Balise tag</label>
                                    <select class="form-control" name="tags_token[]" id="tags_token" multiple required size="5">
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->token }}" {{ in_array($tag->token, old('tags_token', $blog->tags->pluck('token')->toArray())) ? 'selected' : '' }}>{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('tags_token')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    @error('tags_token.*')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
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
        var initialContent = "{!! addslashes($blog->content) !!}";
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