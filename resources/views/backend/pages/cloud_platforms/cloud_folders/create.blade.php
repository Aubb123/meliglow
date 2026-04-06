@extends('backend/layouts/app')

@section('title')
    Cloud Platforms - Ajouter un dossier
@endsection()

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
   
    @include('backend/layouts/includes/cloud_platforms/_show-header', ['platform' => $platform])

    <div class="row g-4">
        <!-- Contenu principal -->
        <div class="col-12">
            <div class="card">
                
                <h5 class="card-header">Formulaire de création</h5> <hr class="m-0 p-0">
                <div class="card-body demo-vertical-spacing demo-only-element">
                    <form action="{{ route('backend.cloud_folders.store', ['cloudPlatformToken' => $platform->token]) }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        <div class="row">   

                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-6">
                                    <input class="form-control" id="folder_name" name="folder_name" type="text" placeholder="Exemple : Motivation, Détermination " value="{{ old('folder_name', '') }}" required>
                                    <label for="folder_name">Nom du dossier</label>
                                    @error('folder_name') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Token document parent -->
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-6">
                                    <input class="form-control" id="cloud_folder_token" name="cloud_folder_token" type="text" placeholder="Token du dossier parent (optionnel)" value="{{ old('cloud_folder_token', '') }}">
                                    <label for="cloud_folder_token">Token du dossier parent (optionnel)</label>
                                    @error('cloud_folder_token') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Créer</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>
<!-- / Content -->
@endsection()