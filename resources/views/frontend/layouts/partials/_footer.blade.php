<!-- footer area start -->
<footer class="footer-widget-area">
    <div class="footer-top section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="widget-item">
                        <div class="widget-title">
                            <div class="widget-logo">
                                <a href="index.html">
                                    <img src="{{ asset(getEnvFolder() . 'frontend/assets/img/logo/logo.png') }}" alt="brand logo">
                                </a>
                            </div>
                        </div>
                        <div class="widget-body">
                            <p>
                                {{ config('app.name') }} est une marque de cosmétiques naturels dédiée à la beauté et au bien-être. 
                                <!-- Nous croyons en la puissance de la nature pour révéler votre éclat intérieur et extérieur. Nos produits sont formulés avec des ingrédients soigneusement sélectionnés, issus de sources durables, pour offrir des soins efficaces et respectueux de votre peau. Chez Meli'Glow, nous nous engageons à vous aider à rayonner naturellement, en mettant en avant la pureté, la qualité et l'efficacité dans chaque produit que nous créons. -->
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="widget-item">
                        <h6 class="widget-title">Contact</h6>
                        <div class="widget-body">
                            <address class="contact-block">
                                <ul>
                                    <li><i class="pe-7s-home"></i> 4710-4890 Breckinridge USA</li>
                                    <li><i class="pe-7s-mail"></i> <a href="mailto:demo@plazathemes.com">demo@yourdomain.com </a></li>
                                    <li><i class="pe-7s-call"></i> <a href="tel:(012)800456789987">(012) 800 456 789-987</a></li>
                                </ul>
                            </address>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="widget-item">
                        <h6 class="widget-title">Information</h6>
                        <div class="widget-body">
                            <ul class="info-list">
                                <li><a href="{{ route('frontend.about') }}">À propos de nous</a></li>
                                <li><a href="{{ route('frontend.privacy') }}">Politique</a></li>
                                <li><a href="{{ route('frontend.terms') }}">Conditions</a></li>
                                <li><a href="{{ route('frontend.contact') }}">Nous contacter</a></li> 
                                @auth
                                    <!-- Si le auth()->user()->role_id est égal à 1, 2 ou 3 -->
                                    @if(auth()->user()->role_id === 1 ||auth()->user()->role_id === 2 ||auth()->user()->role_id === 3)
                                        <li><a href="{{ route('backend.index') }}">Dashboard</a></li>
                                    @endif
                                    <!-- Se déconnecter -->
                                    <li>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Se déconnecter
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                @else
                                    <li><a href="{{ route('login') }}">Se connecter</a></li>
                                    <li><a href="{{ route('register') }}">S'inscrire</a></li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="widget-item">
                        <h6 class="widget-title">Suivez-nous</h6>
                        <div class="widget-body social-link">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center mt-20">
                <div class="col-md-6">
                    <div class="newsletter-wrapper">
                        <h6 class="widget-title-text">Inscrivez-vous à la newsletter</h6>
                        
                        <form class="newsletter-inner" action="{{ route('frontend.subscribe.store') }}" method="POST">
                            @csrf
                            @method('POST')

                            <input type="email" class="news-field" autocomplete="off" placeholder="Entrez votre adresse e-mail" name="email">
                            <button type="submit" class="news-btn">S'abonner</button>
                        </form>

                        <!-- mail-chimp-alerts Start -->
                        <div class="mailchimp-alerts">
                            <div class="mailchimp-submitting"></div><!-- mail-chimp-submitting end -->
                            <div class="mailchimp-success"></div><!-- mail-chimp-success end -->
                            <div class="mailchimp-error"></div><!-- mail-chimp-error end -->
                        </div>
                        <!-- mail-chimp-alerts end -->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="footer-payment">
                        <img src="{{ asset(getEnvFolder() . 'frontend/assets/img/payment.png') }}" alt="payment method">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="copyright-text text-center">
                        <p>&copy; {{ date('Y') }} <b>{{ config('app.name') }}</b> 
                        Conçu par <a href="https://hasthemes.com/"><b>Chic dev</b></a></p>
                        <!-- Conçu avec <i class="fa fa-heart text-danger"></i> par <a href="https://hasthemes.com/"><b>HasThemes</b></a></p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer area end -->