@extends('frontend/layouts/master')

@section('title', 'Contactez-nous')

@section('content')

    @include('frontend/layouts/partials/_breadcrumb', ['title' => 'Contactez-nous'])

    <br>

        <div class="contact-area section-padding pt-0">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="contact-message">
                            <h4 class="contact-title">
                                N'hésitez pas à nous contacter pour toute question ou demande d'information. Nous sommes là pour vous aider et répondre à vos besoins.
                            </h4>

                            @include('frontend-messages')

                            <form action="{{ route('frontend.contacts.store') }}" method="POST" class="#">
                                @csrf
                                <div class="row">

                                    {{-- Nom complet --}}
                                    <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                        <input name="fullname" placeholder="Nom complet *" type="text" value="{{ old('fullname') }}" required>
                                        @error('fullname')
                                        <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Téléphone --}}
                                    <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                        <input name="phone" placeholder="Téléphone *" type="text" value="{{ old('phone') }}" required>
                                        @error('phone')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                        <input name="email" placeholder="Email *" type="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Message --}}
                                    <div class="col-12">
                                        <div class="contact2-textarea text-center">
                                            <textarea placeholder="Message *" name="message" class="form-control2" required>{{ old('message') }}</textarea>
                                        </div>
                                        @error('message')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror

                                        <div class="contact-btn">
                                            <button class="btn btn-sqr" type="submit">Envoyer le message</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-info">
                            <h4 class="contact-title">Informations de contact</h4>
                            <p>
                                Si vous avez des questions, des préoccupations ou si vous souhaitez simplement en savoir plus sur nos produits et services, n'hésitez pas à nous contacter. Nous sommes impatients de vous aider et de vous fournir les informations dont vous avez besoin.
                            </p>
                            <ul>
                                <li><i class="fa fa-fax"></i> Address (localisation) : No 40 Baria Sreet 133/2 NewYork City</li>
                                <li><i class="fa fa-phone"></i> E-mail: info@yourdomain.com</li>
                                <li><i class="fa fa-envelope-o"></i> +88013245657</li>
                            </ul>
                            <div class="working-time">
                                <h6>Horaires d'ouverture</h6>
                                <p><span>Lundi – Vendredi :</span>08H– 22H</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection