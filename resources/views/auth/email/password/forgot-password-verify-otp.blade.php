@extends('frontend/layouts/master')

@section('title') 
    Code de réinitialisation
@endsection

@section('content')

    <main class="main">

        <!-- login area -->
        <div class="auth-area py-100">
            <div class="container">
                <div class="col-md-5 mx-auto">
                    <div class="auth-form">
                        <div class="auth-header">
                            <a href="{{ route('frontend.index') }}">
                                <img src="{{ asset(getEnvFolder() . 'frontend/assets/img/logo/logo.png') }}" alt="">
                            </a>
                            <h2>Code de réinitialisation </h2>
                            <p>
                                Entrez le code OTP envoyé à votre adresse email suivante <strong class="text-primary">{{ $user->email }}</strong> pour réinitialiser votre mot de passe.
                            </p>
                        </div>

                        <!-- Messages de succès -->
                        @include('frontend-messages')

                        <form action="{{ route('forgot.password.verify.otp.store', $user->token) }}" method="POST">
                            @csrf
                            
                            <div class="form-group">
                                <div class="form-icon">
                                    <input type="text" name="otp_code" class="form-control @error('otp_code') is-invalid @enderror" placeholder="Code otp" value="{{ old('otp_code', '') }}" maxlength="6" pattern="[0-9]{6}" required autocomplete="one-time-code" style="letter-spacing: 0.5rem; font-size: 1.25rem;">
                                </div>
                                @error('otp_code') <div class="text-danger">{{ $message }}</div> @enderror
                                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="auth-btn">
                                <button type="submit" class="theme-btn">
                                    <span class="far fa-sign-in"></span> Vérifier le code
                                </button>
                            </div>
                            
                            <input type="hidden" name="user_token" value="{{ $user->token }}">

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- login area end -->

    </main>

@endsection