@extends('backend/layouts/app')

@section('title')
    dashboard/catégories/edit
@endsection()

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-6">
            <!-- Gamification Card -->
            <div class="col-md-12 col-xxl-12">
                <div class="card">
                    <h5 class="card-header">Formulaire de modification</h5> <hr class="m-0 p-0">
                    <div class="card-body demo-vertical-spacing demo-only-element">
                        <form action="{{ route('backend.tags.update', $tag->token) }}" method="POST">
                            @csrf
                            @method('put')
                            <div class="row">   
                                <div class="form-floating form-floating-outline mb-6">
                                    <input class="form-control" id="name" name="name" type="text" placeholder="{{ $tag->name }}" value="{{ old('name', $tag->name) }}" required>
                                    <label for="name">Nom de la balise</label>
                                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
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
