@extends('frontend/layouts/master')

@section('title', 'Se connecter à ' . config('app.name'))

@section('content')

    @include('frontend/layouts/partials/_breadcrumb', ['title' => 'Se connecter à ' . config('app.name')])

    <div class="login-register-wrapper section-padding">
        <div class="container">
            <div class="member-area-from-wrap">
                <div class="row">
                    <!-- Login Content Start -->
                    <div class="col-lg-3">
                    </div>
                    <div class="col-lg-6">
                        <div class="login-reg-form-wrap">
                            <h5>S'inscrire</h5>
                            
                            <form action="{{ route('register.store') }}" method="POST">
                                @csrf

                                <!-- Messages -->
                                @include('frontend-messages')

                                {{-- Champ pays --}}
                                <div class="single-input-item">
                                    <select name="country_token" class="form-control @error('country_token') is-invalid @enderror" required>
                                        <option value="">Sélectionnez votre pays</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->token }}" {{ old('country_token') == $country->token ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('country_token')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Champ nom --}}
                                <div class="single-input-item">
                                    <input type="text" name="lastname" class="form-control @error('lastname') is-invalid @enderror" placeholder="Votre nom" value="{{ old('lastname') }}" required>
                                    @error('lastname')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Champ prénom --}}
                                <div class="single-input-item">
                                    <input type="text" name="firstname" class="form-control @error('firstname') is-invalid @enderror" placeholder="Votre prénom" value="{{ old('firstname') }}" required>
                                    @error('firstname')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Champ email --}}
                                <div class="single-input-item">
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Votre Email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Champ mot de passe --}}
                                <div class="single-input-item">
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Votre mot de passe (min 8 caractères)" required>
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Champ confirmation mot de passe --}}
                                <div class="single-input-item">
                                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirmez votre mot de passe" required>
                                    @error('password_confirmation')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Checkbox conditions --}}
                                <div class="single-input-item">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input @error('sign_agree_check') is-invalid @enderror" type="checkbox" name="sign_agree_check" value="1" id="agree" {{ old('sign_agree_check') ? 'checked' : '' }} >
                                        <label class="custom-control-label" for="agree">
                                            J'accepte les <a href="#">Conditions d'utilisation.</a>
                                        </label>
                                    </div>
                                    @error('sign_agree_check')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Bouton submit --}}
                                <div class="single-input-item">
                                    <button type="submit" class="btn btn-sqr">S'inscrire</button>
                                </div>

                            </form>

                        </div>
                    </div>
                    <div class="col-lg-3">
                    </div>
                    <!-- Login Content End -->

                    {{--
                        <!-- Register Content Start -->
                        <div class="col-lg-6">
                            <div class="login-reg-form-wrap sign-up-form">
                                <h5>Singup Form</h5>
                                <form action="#" method="post">
                                    <div class="single-input-item">
                                        <input type="text" placeholder="Full Name" required="">
                                    </div>
                                    <div class="single-input-item">
                                        <input type="email" placeholder="Enter your Email" required="">
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="single-input-item">
                                                <input type="password" placeholder="Enter your Password" required="">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="single-input-item">
                                                <input type="password" placeholder="Repeat your Password" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-input-item">
                                        <div class="login-reg-form-meta">
                                            <div class="remember-meta">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="subnewsletter">
                                                    <label class="custom-control-label" for="subnewsletter">Subscribe
                                                        Our Newsletter</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-input-item">
                                        <button class="btn btn-sqr">Register</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Register Content End -->
                    --}}
                </div>
            </div>
        </div>
    </div>

@endsection