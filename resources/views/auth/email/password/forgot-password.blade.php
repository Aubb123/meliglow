@extends('frontend/layouts/master')

@section('title') 
    Mot de passe oublié ?
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
                            <h2>Mot de passe oublié ? </h2>
                            <p>Ne vous inquiétez pas, cela peut arriver. Indiquez votre adresse email et nous vous enverrons un code otp vous permettant de réinitialiser votre mot de passe.</p>
                        </div>

                        <!-- Messages de succès -->
                        @include('frontend-messages')

                        <form method="POST" action="{{ route('forgot.password.send.link') }}">
                            @csrf
                            
                            <div class="form-group">
                                <div class="form-icon">
                                    <i class="far fa-envelope"></i>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Votre Email" value="{{ old('email') }}" required>
                                </div>
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="auth-btn">
                                <button type="submit" class="theme-btn">
                                    <span class="far fa-sign-in"></span> Envoyer le code
                                </button>
                            </div>
                        </form>

                        <div class="auth-bottom">
                            <p class="auth-bottom-text">Vous n'avez pas de compte ? <a href="{{ route('register') }}">S'inscrire</a></p>
                            <p class="auth-bottom-text">Vous avez déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- login area end -->

    </main>

@endsection