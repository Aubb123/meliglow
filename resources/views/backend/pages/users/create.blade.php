@extends('backend/layouts/app')

@section('title')
    dashboard/users/create
@endsection()

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-6">
            <!-- Gamification Card -->
            <div class="col-md-12 col-xxl-12">
                <div class="card">
                    <h5 class="card-header">Formulaire de création d'utilisateur</h5> <hr class="m-0 p-0">
                    <div class="card-body demo-vertical-spacing demo-only-element">
                        <form action="{{ route('backend.users.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Section : Informations obligatoires -->
                            <h6 class="mb-4 text-primary">Informations obligatoires</h6>
                            <div class="row">   
                                <div class="col-md-6">

                                    <div class="form-floating form-floating-outline mb-6">
                                        <input class="form-control" id="lastname" name="lastname" placeholder="Ex: John DOE" value="{{ old('lastname', '') }}" type="text" required>
                                        <label for="lastname">Nom complet</label>
                                        @error('lastname') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-floating form-floating-outline mb-6">
                                        <input class="form-control" id="firstname" name="firstname" placeholder="Ex: John" value="{{ old('firstname', '') }}" type="text" required>
                                        <label for="firstname">Prénom</label>
                                        @error('firstname') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input class="form-control" id="email" name="email" placeholder="exemple@gmail.com" value="{{ old('email', '') }}" type="email" required>
                                        <label for="email">Email</label>
                                        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-floating form-floating-outline mb-6">
                                        <select class="form-control" name="role_token" id="role_token" required>
                                            <option value="" selected>Sélectionner un rôle</option>
                                            @foreach($roles as $role)
                                                <option class="text-secondary" value="{{$role->token}}" {{ old('role_token', '') == $role->token ? 'selected' : '' }}>{{$role->label}}</option>
                                            @endforeach
                                        </select>
                                        <label for="role_token">Rôle</label>
                                        @error('role_token') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input class="form-control" id="password" name="password" placeholder="@2025Exemple" value="{{ old('password', '') }}" type="password" required>
                                        <label for="password">Mot de passe</label>
                                        @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input class="form-control" id="password_confirmation" name="password_confirmation" placeholder="@2025Exemple" value="{{ old('password_confirmation', '') }}" type="password" required>
                                        <label for="password_confirmation">Confirmer le mot de passe</label>
                                        @error('password_confirmation') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    
                                    <div class="form-floating form-floating-outline mb-6">
                                        <select class="form-control" name="countrie_token" id="countrie_token" required>
                                            <option value="" selected>Sélectionner un pays</option>
                                            @foreach($countries as $country)
                                                <option class="text-secondary" value="{{$country->token}}" {{ old('countrie_token', '') == $country->token ? 'selected' : '' }}>{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                        <label for="countrie_token">Pays</label>
                                        @error('countrie_token') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    
                                    <div class="form-floating form-floating-outline mb-6">
                                        <select class="form-control" name="is_active" id="is_active" required>
                                            <option value="" selected>Sélectionner l'état</option>
                                            <option class="text-secondary" value="0" {{ old('is_active', "") === '0' ? 'selected' : '' }}>Désactivé</option>
                                            <option class="text-secondary" value="1" {{ old('is_active', "") === '1' ? 'selected' : '' }}>Actif</option>
                                        </select>                                        
                                        <label for="is_active">État du compte</label>
                                        @error('is_active') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    
                                </div>
                            </div>

                            <hr class="my-6">

                            <!-- Section : Informations personnelles optionnelles -->
                            <h6 class="mb-4 text-primary">Informations personnelles (optionnelles)</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-6">
                                        <select class="form-control" name="sexe" id="sexe">
                                            <option value="" selected>Non spécifié</option>
                                            <option class="text-secondary" value="man" {{ old('sexe', "") == 'man' ? 'selected' : '' }}>Homme</option>
                                            <option class="text-secondary" value="woman" {{ old('sexe', "") == 'woman' ? 'selected' : '' }}>Femme</option>
                                        </select>                                        
                                        <label for="sexe">Sexe</label>
                                        @error('sexe') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input class="form-control" id="birth_date" name="birth_date" value="{{ old('birth_date', '') }}" type="date">
                                        <label for="birth_date">Date de naissance</label>
                                        @error('birth_date') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input class="form-control" id="phone" name="phone" placeholder="+229 XX XX XX XX" value="{{ old('phone', '') }}" type="tel">
                                        <label for="phone">Téléphone</label>
                                        @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-6">
                                        <textarea class="form-control" id="bio" name="bio" placeholder="Parlez de vous..." style="height: 150px;" maxlength="300">{{ old('bio', '') }}</textarea>
                                        <label for="bio">Biographie</label>
                                        <span class="text-muted" >Max 300 caractères</span>
                                        @error('bio') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-6">

                            <!-- Section : Réseaux sociaux -->
                            <h6 class="mb-4 text-primary">Réseaux sociaux (optionnels)</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input class="form-control" id="facebook_link" name="facebook_link" placeholder="https://facebook.com/username" value="{{ old('facebook_link', '') }}" type="url">
                                        <label for="facebook_link">Facebook</label>
                                        @error('facebook_link') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input class="form-control" id="twitter_link" name="twitter_link" placeholder="https://twitter.com/username" value="{{ old('twitter_link', '') }}" type="url">
                                        <label for="twitter_link">Twitter / X</label>
                                        @error('twitter_link') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input class="form-control" id="instagram_link" name="instagram_link" placeholder="https://instagram.com/username" value="{{ old('instagram_link', '') }}" type="url">
                                        <label for="instagram_link">Instagram</label>
                                        @error('instagram_link') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input class="form-control" id="linkedin_link" name="linkedin_link" placeholder="https://linkedin.com/in/username" value="{{ old('linkedin_link', '') }}" type="url">
                                        <label for="linkedin_link">LinkedIn</label>
                                        @error('linkedin_link') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input class="form-control" id="youtube_link" name="youtube_link" placeholder="https://youtube.com/@username" value="{{ old('youtube_link', '') }}" type="url">
                                        <label for="youtube_link">YouTube</label>
                                        @error('youtube_link') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input class="form-control" id="tiktok_link" name="tiktok_link" placeholder="https://tiktok.com/@username" value="{{ old('tiktok_link', '') }}" type="url">
                                        <label for="tiktok_link">TikTok</label>
                                        @error('tiktok_link') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input class="form-control" id="whatsapp_link" name="whatsapp_link" placeholder="https://wa.me/229XXXXXXXX" value="{{ old('whatsapp_link', '') }}" type="url">
                                        <label for="whatsapp_link">WhatsApp</label>
                                        @error('whatsapp_link') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input class="form-control" id="website_link" name="website_link" placeholder="https://monsite.com" value="{{ old('website_link', '') }}" type="url">
                                        <label for="website_link">Site web personnel</label>
                                        @error('website_link') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-6">

                            <!-- Boutons d'action -->
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light me-3">
                                        <i class="mdi mdi-content-save me-1"></i> Créer l'utilisateur
                                    </button>
                                    <a href="{{ route('backend.users.index') }}" class="btn btn-outline-secondary waves-effect">
                                        <i class="mdi mdi-arrow-left me-1"></i> Annuler
                                    </a>
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