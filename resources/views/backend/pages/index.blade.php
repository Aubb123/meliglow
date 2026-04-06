@extends('backend/layouts/app')

@section('title') Dashboard @endsection

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-6">
            <!-- Gamification Card -->
            <div class="col-md-12 col-xxl-12">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-md-9 order-2 order-md-1">
                            <div class="card-body"> 
                                <h4 class="card-title mb-4">Bienvenue sur votre tableau de bord <span class="fw-bold"> {{ auth()->user()->lastname }} {{ auth()->user()->firstname }} !</span> 🎉</h4>
                                <p class="mb-0">Utilisez cet espace pour rester connecté avec votre équipe, partager des ressources inspirantes et recevoir des notifications importantes. 😎</p>
                                <p>Votre engagement est la clé du succès des jeunes que nous soutenons ensemble.</p>
                                <button type="submit" class="btn btn-primary">{{ config('app.name') }}</button>
                                <!-- Bouton pour exporter la base de donner -->
                                <a href="{{ route('backend.export.db') }}" class="btn btn-outline-primary mt-2">Exporter la base de données</a>
                            </div>
                        </div>
                        <div class="col-md-3 text-center text-md-end order-1 order-md-2">
                            <div class="card-body pb-0 px-0 pt-2">
                                <img src="{{ asset(getEnvFolder() . 'backend/assets/img/illustrations/illustration-john-light.png') }}" height="186" class="scaleX-n1-rtl" alt="View Profile">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Gamification Card -->
        </div>
    </div>
    <!-- / Content -->
@endsection()