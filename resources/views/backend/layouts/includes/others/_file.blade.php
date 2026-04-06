@if($model->hasCoverImage())

    @if(get_class($model) === 'App\Models\Product')
        <div class="row g-3">
            @foreach($model->getImages()['data'] as $image)

                <div class="col-md-4 col-sm-6">
                    <div class="position-relative rounded-3 overflow-hidden shadow-sm" style="height: 160px;">

                        <img src="{{ $image['url_img'] }}" alt="{{ $model->name }}" class="w-100 h-100" style="object-fit: cover;">

                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center gap-2" style="background: rgba(0,0,0,0.45); opacity: 0; transition: opacity 0.2s;" onmouseenter="this.style.opacity=1" onmouseleave="this.style.opacity=0">
                            <a href="{{ $image['url_img'] }}" target="_blank" class="btn btn-sm btn-light">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            <form id="delete-form-cloud-file-{{ $model->token }}-{{ $image['cloud_file_token'] }}" action="{{ route('backend.cloud_files.delete') }}" method="POST">
                                @csrf
                                @method('delete')

                                <button type="button" class="btn btn-sm btn-danger d-flex align-items-center" onclick="confirmDeleteCloudFile('{{$model->token}}', '{{ $image['cloud_file_token'] }}', 'Êtes-vous sûr de vouloir supprimer ce fichier ?')">
                                    <i class="fas fa-trash"></i>
                                </button>

                                <input type="hidden" name="file_type" value="images">
                                <input type="hidden" name="delete_forever" value="0">
                                <input type="hidden" name="model_token" value="{{ $model->token }}">
                                <input type="hidden" name="model_type" value="{{ get_class($model) }}">
                                <input type="hidden" name="cloud_file_token" value="{{ $image['cloud_file_token'] }}">
                            </form>

                        </div>
                    </div>
                </div>
                
            @endforeach
        </div>

        <!-- {{-- Bouton + Formulaire ajout d'autres images --}} -->
        <div class="mt-3">
            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#formAddImages">
                <i class="fas fa-upload me-2"></i>
                Ajouter d'autres images
            </button>
        </div>

        <div class="collapse mt-3" id="formAddImages">
            <div class="card border-0 bg-light rounded-3 p-3">
                <form action="{{ route('backend.cloud_files.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @error('file_type') <div class="text-danger">{{ $message }}</div> @enderror
                    @error('model_token') <div class="text-danger">{{ $message }}</div> @enderror
                    @error('model_type') <div class="text-danger">{{ $message }}</div> @enderror

                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <label for="cloud_platform_token_exist" class="form-label">Choisir une plateforme cloud</label>
                            <select name="cloud_platform_token" id="cloud_platform_token_exist" class="form-select" required>
                                <option value="" disabled selected>-- Plateforme --</option>
                                @foreach(getCloudPlatforms() as $platform)
                                    <option value="{{ $platform->token }}">{{ ucfirst($platform->label) }}</option>
                                @endforeach
                            </select>
                            @error('cloud_platform_token') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="flex-grow-1">
                            <label for="path_exist" class="form-label">Uploader une image</label>
                            <input class="form-control @error('path') is-invalid @enderror" type="file" name="path" id="path_exist" accept=".jpg, .jpeg, .png" required>
                            @error('path') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center mt-3">
                            <i class="fas fa-save me-1"></i>
                            Enregistrer
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse" data-bs-target="#formAddImages">
                            Annuler
                        </button>
                    </div>

                    <div class="mt-3">
                        <img id="previewFileUploadExist" src="#" alt="Aperçu" style="display: none; max-height: 100px; border-radius: 6px; border: 1px solid #ddd; padding: 4px;" />
                    </div>

                    <input type="hidden" name="file_type" value="images">
                    <input type="hidden" name="model_token" value="{{ $model->token }}">
                    <input type="hidden" name="model_type" value="{{ get_class($product) }}">

                </form>
            </div>
        </div>
    @else
        <div class="mb-4">
            <img src="{{ $model->getCoverImageUrl()['url_img'] }}" alt="{{ $model->name }}" class="img-fluid rounded-3 shadow-sm w-100" style="max-height: 300px; object-fit: cover;">

            <div class="mt-2 d-flex gap-2">
                <a href="{{ $model->getCoverImageUrl()['url_img'] }}" target="_blank" class="btn btn-sm btn-outline-primary d-flex align-items-center">
                    <i class="fas fa-eye me-2"></i>
                    Voir l'image
                </a>

                <form id="delete-form-cloud-file-{{ $model->token }}-{{ $model->getCoverImageUrl()['cloud_file_token'] }}" action="{{ route('backend.cloud_files.delete') }}" method="POST">
                    @csrf
                    @method('delete')

                    <button type="button" class="btn btn-sm btn-outline-danger d-flex align-items-center" onclick="confirmDeleteCloudFile('{{$model->token}}', '{{ $model->getCoverImageUrl()['cloud_file_token'] }}', 'Êtes-vous sûr de vouloir supprimer ce fichier ?')">
                        <i class="fas fa-trash me-2"></i>
                        Supprimer l'image
                    </button>

                    <input type="hidden" name="file_type" value="images">
                    <input type="hidden" name="delete_forever" value="0">
                    <input type="hidden" name="model_token" value="{{ $model->token }}">
                    <input type="hidden" name="model_type" value="{{ get_class($model) }}">
                    <input type="hidden" name="cloud_file_token" value="{{ $model->getCoverImageUrl()['cloud_file_token'] }}">
                </form>
                
            </div>

        </div>
    @endif

@else
    <div class="mb-4">
        <div class="bg-light rounded-3 d-flex flex-column align-items-center justify-content-center p-4" style="height: 200px; border: 2px dashed #dee2e6;">
            <i class="fas fa-image fa-2x text-muted mb-3"></i>
            <p class="text-muted mb-3">Aucune image disponible</p>
            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#formAddImage">
                <i class="fas fa-upload me-2"></i>
                Ajouter une image
            </button>
        </div>

        <div class="collapse mt-3" id="formAddImage">
            <div class="card border-0 bg-light rounded-3 p-3">
                <form action="{{ route('backend.cloud_files.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @error('file_type') <div class="text-danger">{{ $message }}</div> @enderror
                    @error('model_token') <div class="text-danger">{{ $message }}</div> @enderror
                    @error('model_type') <div class="text-danger">{{ $message }}</div> @enderror

                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <label for="cloud_platform_token" class="form-label">Choisir une plateforme cloud</label>
                            <select name="cloud_platform_token" id="cloud_platform_token" class="form-select" required>
                                <option value="" disabled selected>-- Plateforme --</option>
                                @foreach(getCloudPlatforms() as $platform)
                                    <option value="{{ $platform->token }}">{{ ucfirst($platform->label) }}</option>
                                @endforeach
                            </select>
                            @error('cloud_platform_token') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="flex-grow-1">
                            <label for="path" class="form-label">Uploader une image</label>
                            <input class="form-control @error('path') is-invalid @enderror" type="file" name="path" id="path" accept=".jpg, .jpeg, .png" required >
                            @error('path')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center">
                            <i class="fas fa-save me-1"></i>
                            Enregistrer
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse" data-bs-target="#formAddImage">
                            Annuler
                        </button>
                    </div>

                    {{-- Aperçu en temps réel --}}
                    <div class="mt-3">
                        <img id="previewFileUpload" src="#" alt="Aperçu" style="display: none; max-height: 100px; border-radius: 6px; border: 1px solid #ddd; padding: 4px;" />
                    </div>

                    <input type="hidden" name="file_type" value="images">
                    <input type="hidden" name="model_token" value="{{ $model->token }}">
                    <input type="hidden" name="model_type" value="{{ get_class($model) }}">

                </form>
            </div>
        </div>
    </div>
@endif
















































