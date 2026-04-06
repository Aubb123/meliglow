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
                            <h5>Se connecter</h5>
                            <form action="{{ route('login.store') }}" method="POST">
                                @csrf
                                
                                <!-- Messages de succès -->
                                @include('frontend-messages')
                                
                                <div class="single-input-item">
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Votre Email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="single-input-item">
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Votre Mot de Passe" required>
                                    @error('password')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="single-input-item">
                                    <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
                                        <div class="remember-meta">
                                            <div class="custom-control custom-checkbox">
                                                {{-- 
                                                    <input type="checkbox" class="custom-control-input" id="rememberMe">
                                                    <label class="custom-control-label" for="rememberMe">Remember Me</label>
                                                --}}
                                            </div>
                                        </div>
                                        <a href="{{ route('forgot.password') }}" class="forget-pwd">Mot de passe oublié ?</a>
                                    </div>
                                </div>
                                <div class="single-input-item">
                                    <button type="submit" class="btn btn-sqr">Connexion</button>
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