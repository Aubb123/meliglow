@extends('frontend/layouts/master')

@section('title') 
    Nouveau mot de passe
@endsection

@section('content')
    <main class="main">
        <!-- register area -->
        <div class="auth-area py-100">
            <div class="container">
                <div class="col-md-6 mx-auto">
                    <div class="auth-form">
                        <div class="auth-header">
                            <a href="{{ route('frontend.index') }}">
                                <img src="{{ asset(getEnvFolder() . 'frontend/assets/img/logo/logo.png') }}" alt="">
                            </a>
                            <h2>Créer un nouveau mot de passe</h2>
                            <p>Veuillez remplir le formulaire ci-dessous pour créer un nouveau mot de passe pour votre compte.</p>
                        </div>

                        <!-- Messages de succès -->
                        @include('frontend-messages')

                        <form method="POST" action="{{ route('forgot.password.update.new.password', $token) }}">
                            @csrf
                            @method('PUT')
                            
                            <!-- Mot de passe -->
                            <div class="form-group">
                                <div class="form-icon">
                                    <i class="far fa-key"></i>
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Mot de passe" required>
                                    <span class="password-view"><i class="far fa-eye-slash"></i></span>
                                </div>
                                @error('password')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Confirmation mot de passe -->
                            <div class="form-group">
                                <div class="form-icon">
                                    <i class="far fa-key"></i>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirmation mot de passe" required>
                                    <!-- <span class="password-view"><i class="far fa-eye-slash"></i></span> -->
                                </div>
                                @error('password_confirmation')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Informations sur la sécurité du mot de passe -->
                            <div class="alert alert-info mt-4" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="feather icon-info me-2"></i>
                                    <div class="small">
                                        <strong>Conseils :</strong> Utilisez au moins 8 caractères avec majuscules, minuscules, chiffres et symboles.
                                    </div>
                                </div>
                            </div>

                            <!-- Bouton d'inscription -->
                            <div class="auth-btn">
                                <button type="submit" class="theme-btn">
                                    <span class="far fa-user-plus"></span> Sauvegarder le nouveau mot de passe
                                </button>
                            </div>

                            <!-- Champs cachés -->
                            <input type="hidden" name="user_token" value="{{ old('user_token', $token) }}">
                            @error('user_token')<div class="text-danger">{{ $message }}</div> @enderror
                            
                            <input type="hidden" name="otp_code" value="{{ $otp_code }}">
                            @error('otp_code')<div class="text-danger">{{ $message }}</div> @enderror

                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- register area end -->
    </main>
@endsection