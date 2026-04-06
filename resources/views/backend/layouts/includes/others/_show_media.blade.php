<div class="accordion mb-4 mt-4" id="accordionExample">


    @if(get_class($model) === 'App\Models\User')
        <!-- Image -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne">Image</button>
            </h2>
            <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body"> 

                    {{-- dd($model->getCoverImageUrl()['url_img']); --}}
                    
                    @if($model->hasCoverImage())
                        <img style="object-fit: cover;" src="{{ $model->getCoverImageUrl()['url_img'] }}" alt="{{ $model->title }}" class="img-fluid rounded" loading="lazy">

                        <!-- Petit bouton de suppression -->
                        <form id="delete-form-cloud-file-{{$model->token}}-{{ $model->getCoverImageUrl()['cloud_file_token'] }}" action="{{ route('backend.cloud_files.delete') }}" method="POST" class="d-inline mt-3">
                            @csrf
                            @method('delete')

                            <!-- Suppression définitive -->
                            <div class="mt-3"><hr>
                                <label class="form-check-label" for="deleteForeverCheckbox">
                                    Supprimer définitivement ?
                                </label>
                                <select name="delete_forever" id="deleteForeverCheckbox" class="form-select form-select-sm w-auto d-inline-block ms-2">
                                    <option value="1">Oui</option>
                                    <option value="0" selected>Non (déplace dans la corbeille)</option>
                                </select>
                            </div>

                            <button type="button" class="btn btn-sm btn-danger mt-2" onclick="confirmDeleteCloudFile('{{$model->token}}', '{{ $model->getCoverImageUrl()['cloud_file_token'] }}', 'Êtes-vous sûr de vouloir supprimer cette image de couverture ?')">
                                Supprimer l'image
                            </button>

                            <input type="hidden" name="file_type" value="image">
                            <input type="hidden" name="model_token" value="{{ $model->token }}">
                            <input type="hidden" name="model_type" value="{{ get_class($model) }}">
                            <input type="hidden" name="cloud_file_token" value="{{ $model->getCoverImageUrl()['cloud_file_token'] }}">
                        </form>

                    @else
                        <img style="object-fit: cover;" src="{{ $model->getCoverImageUrl()['url_img'] }}" alt="Default course image" class="img-fluid rounded">

                        <!-- Petit formulaire pour ajouter une image de couverture -->
                        <form action="{{ route('backend.cloud_files.upload') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                            @csrf

                            @error('file_type') <div class="text-danger">{{ $message }}</div> @enderror
                            @error('model_token') <div class="text-danger">{{ $message }}</div> @enderror
                            @error('model_type') <div class="text-danger">{{ $message }}</div> @enderror

                            <div class="row">
                                <div class="col-6">
                                    <!-- Choisir une plateforme cloud -->
                                    <div class="mb-3">
                                        <label for="cloud_platform_token" class="form-label">Choisir une plateforme cloud</label>
                                        <select name="cloud_platform_token" id="cloud_platform_token" class="form-select" required>
                                            <option value="" disabled selected>-- Sélectionnez une plateforme --</option>
                                            @foreach(getCloudPlatforms() as $platform)
                                                <option value="{{ $platform->token }}">{{ ucfirst($platform->label) }}</option>
                                            @endforeach
                                        </select>
                                        @error('cloud_platform_token') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="path" class="form-label">Ajouter une image de couverture</label>
                                        <input type="file" name="path" id="path" class="form-control" accept="image/*">
                                        @error('path') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <!-- Prévisualiser l'image -->
                                    <img id="previewImg" src="#" alt="Preview Image" style="display: none; max-height: 150px; border: 1px solid #ddd; padding: 4px; border-radius: 4px;">
                                </div>

                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary">Ajouter le fichier</button>
                                </div>

                            </div>

                            <input type="hidden" name="file_type" value="images">
                            <input type="hidden" name="model_token" value="{{ $model->token }}">
                            <input type="hidden" name="model_type" value="{{ get_class($model) }}">
                        </form>

                    @endif

                </div>
            </div>
        </div>
    @endif

    @if(get_class($model) === 'App\Models\Course')

        {{ dd($model->getVideoUrl()['url_vdo']); }}

        <!-- Vidéo promotionnel --> 
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo">Vidéo promotionnelle</button>
            </h2>
            <div id="accordionTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">

                    @if($model->hasVideo()) 
                        <div class="course-video">
                            <video controls width="100%" poster="{{ $model->getCoverImageUrl()['url_img'] }}" preload="metadata">
                                <source src="{{ $model->getVideoUrl()['url_vdo'] }}" type="video/mp4">
                                Votre navigateur ne supporte pas la lecture de vidéos.
                            </video>

                            <!-- Petit bouton de suppression -->
                            <form id="delete-form-cloud-file-{{$model->token}}-{{ $model->getVideoUrl()['cloud_file_token'] }}" method="POST" action="{{ route('backend.cloud_files.delete.video') }}" class="d-inline mt-3">
                                @csrf
                                @method('delete')

                                <!-- Suppression définitive -->
                                <div class="mt-3"><hr>
                                    <label class="form-check-label" for="deleteForeverCheckbox">
                                        Supprimer définitivement ?
                                    </label>
                                    <select name="delete_forever" id="deleteForeverCheckbox" class="form-select form-select-sm w-auto d-inline-block ms-2">
                                        <option value="1">Oui</option>
                                        <option value="0" selected>Non (déplace dans la corbeille)</option>
                                    </select>
                                </div>

                                <button type="button" class="btn btn-sm btn-danger mt-2" onclick="confirmDeleteCloudFile('{{$model->token}}', '{{ $model->getVideoUrl()['cloud_file_token'] }}', 'Êtes-vous sûr de vouloir supprimer cette vidéo ?')">
                                    Supprimer la vidéo
                                </button>

                                <input type="hidden" name="file_type" value="video">
                                <input type="hidden" name="model_token" value="{{ $model->token }}">
                                <input type="hidden" name="model_type" value="{{ get_class($model) }}">
                                <input type="hidden" name="cloud_file_token" value="{{ $model->getVideoUrl()['cloud_file_token'] }}">
                            </form>

                        </div>
                    @else
                        <div class="course-video">
                            <video controls width="100%" poster="{{ $model->getCoverImageUrl()['url_img'] }}" preload="metadata">
                                <source src="{{ $model->getVideoUrl()['url_vdo'] }}" type="video/mp4">
                                Votre navigateur ne supporte pas la lecture de vidéos.
                            </video>

                            
                        <!-- Petit formulaire pour ajouter une video -->
                        <form action="{{ route('backend.cloud_files.upload.video') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                            @csrf

                            @error('file_type') <div class="text-danger">{{ $message }}</div> @enderror
                            @error('model_token') <div class="text-danger">{{ $message }}</div> @enderror
                            @error('model_type') <div class="text-danger">{{ $message }}</div> @enderror

                            <div class="row">
                                <div class="col-6">
                                    <!-- Choisir une plateforme cloud -->
                                    <div class="mb-3">
                                        <label for="cloud_platform_token" class="form-label">Choisir une plateforme cloud</label>
                                        <select name="cloud_platform_token" id="cloud_platform_token" class="form-select" required>
                                            <option value="" disabled selected>-- Sélectionnez une plateforme --</option>
                                            @foreach(getCloudPlatforms() as $platform)
                                                <option value="{{ $platform->token }}">{{ ucfirst($platform->label) }}</option>
                                            @endforeach
                                        </select>
                                        @error('cloud_platform_token') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="path_video" class="form-label">Ajouter une video</label>
                                        <input type="file" name="path_video" id="path_video" class="form-control" accept="video/*">
                                        @error('path_video') <div class="text-danger">{{ $message }}</div> @enderror
                                        
                                        <video id="previewVideo" controls style="display: none; max-height: 150px; border: 1px solid #ddd; padding: 4px; border-radius: 4px;">
                                            <source src="#" type="video/mp4">
                                            Votre navigateur ne supporte pas la lecture de vidéos.
                                        </video>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary">Ajouter la video</button>
                                </div>

                            </div>

                            <input type="hidden" name="file_type" value="video">
                            <input type="hidden" name="is_official_video" value="0">
                            <input type="hidden" name="model_token" value="{{ $model->token }}">
                            <input type="hidden" name="model_type" value="{{ get_class($model) }}">
                        </form>

                        </div>
                    @endif

                </div>
            </div>
        </div>
    @endif

</div>

@section('script')
    <script>
        // Script pour prévisualiser l'image sélectionner 
        document.getElementById('path').addEventListener('change', function(event) {
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

        // Script pour prévisualiser la vidéo sélectionnée
        document.getElementById('path_video').addEventListener('change', function(event){
            const input = event.target;
            const preview = document.getElementById('previewVideo');

            if (input.files && input.files[0]) {
                const fileURL = URL.createObjectURL(input.files[0]);
                preview.querySelector('source').src = fileURL;
                preview.load();
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
                preview.querySelector('source').src = '#';
            }
        });

    </script>
@endsection()