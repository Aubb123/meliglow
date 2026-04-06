@extends('backend/layouts/app')

@section('title') Roles - Édition @endsection()


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
                    <h5 class="card-header">Formulaire de modification</h5>
                    <div class="card-body demo-vertical-spacing demo-only-element">
                        <form action="{{ route('backend.roles.update', $role->token) }}" method="POST">
                            @csrf
                            @method('put')
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" id="label" name="label" placeholder="{{ $role->label }}" value="{{ old('label', $role->label) }}" required>
                                <label for="label">Libellé</label>
                                @error('label') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-floating form-floating-outline mb-6">
                                <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
                                <label for="description">Description</label>
                                @error('description') <div class="text-danger">{{ $message }}</div> @enderror
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
        var initialContent = "{!! addslashes($role->description) !!}";
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