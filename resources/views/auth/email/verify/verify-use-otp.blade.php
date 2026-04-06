@extends('frontend/layouts/master')

@section('title', 'Vérification de l\'email - ' . config('app.name'))

@section('content')

    @include('frontend/layouts/partials/_breadcrumb', ['title' => 'Vérification de l\'email - ' . config('app.name')])

    <div class="login-register-wrapper section-padding">
        <div class="container">
            <div class="member-area-from-wrap">
                <div class="row">
                    <!-- Login Content Start -->
                    <div class="col-lg-3">
                    </div>
                    <div class="col-lg-6">
                        <div class="login-reg-form-wrap">
                            <h5>Vérification de l'email : {{ $user->email }}</h5>
                            <form action="{{ route('email.confirm') }}" method="POST">
                                @csrf

                                <!-- Messages de succès -->
                                @include('frontend-messages')

                                <div class="single-input-item">
                                    <input type="text" name="otp_code" id="otp_code" class="form-control @error('otp_code') is-invalid @enderror" placeholder="Entrez le code OTP" required>
                                    @error('otp_code')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="single-input-item">
                                    <!-- Bouton de soumission -->
                                    <button type="submit" class="btn btn-sqr">Vérifier</button>
                                
                                    <!-- Bouton de renvoi d'OTP -->
                                    <a class="btn btn-sqr" style="margin-left: 10px; background-color: #007bff; border-color: #007bff; color: #fff;" href="{{ route('email.resend') }}" onclick="event.preventDefault(); document.getElementById('resend-form').submit();" >
                                        Renvoyer le code OTP
                                    </a>

                                    <!-- Bouton de déconnexion -->
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn" style="margin-left: 10px; background-color: #dc3545; border-color: #dc3545; color: #fff; padding: 10px;">
                                        Se déconnecter
                                    </a>
                                </div>
                                
                            </form>
                            
                            <!-- Formulaire de renvoi d'OTP -->
                            <form id="resend-form" method="POST" action="{{ route('email.resend') }}" class="d-inline">
                                @csrf
                            </form>

                            <!-- Formulaire de déconnexion -->
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                            {{-- Section changement d'email --}}
                            <div class="mt-4">
                                <a class="btn btn-link" data-bs-toggle="collapse" href="#changeEmailSection" role="button" aria-expanded="false" aria-controls="changeEmailSection">
                                    <i id="collapse-icon" class="fa fa-chevron-down"></i> Changer d'email
                                </a>
                                <div class="collapse mt-3" id="changeEmailSection">
                                    <form action="{{ route('email.change') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Entrez votre nouvel email" value="{{ old('email', $user->email) }}" required>
                                            @error('email')
                                                <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                            <small class="form-text text-muted">Un nouveau code OTP sera envoyé à ce nouvel email.</small>
                                            <!-- Bouton de soumission -->
                                            <button type="submit" class="btn btn-success w-100" style="background-color: #28a745; border-color: #28a745; color: #fff; padding: 10px;">
                                                Sauvegarder
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otpInput = document.getElementById('otp_code');
            const collapseIcon = document.getElementById('collapse-icon');
            const changeEmailSection = document.getElementById('changeEmailSection');
            
            // Auto-focus sur le champ OTP
            if (otpInput) {
                otpInput.focus();
                
                // Formatage automatique du code OTP (seulement les chiffres)
                otpInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    e.target.value = value;
                });
            }
            
            // Animation de l'icône collapse
            if (changeEmailSection && collapseIcon) {
                changeEmailSection.addEventListener('show.bs.collapse', function() {
                    collapseIcon.style.transform = 'rotate(180deg)';
                    collapseIcon.style.transition = 'transform 0.3s ease';
                });
                
                changeEmailSection.addEventListener('hide.bs.collapse', function() {
                    collapseIcon.style.transform = 'rotate(0deg)';
                    collapseIcon.style.transition = 'transform 0.3s ease';
                });
            }
        });
    </script>

@endsection