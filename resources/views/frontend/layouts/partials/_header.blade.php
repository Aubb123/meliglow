    <!-- Start Header Area -->
<header class="header-area">
    <!-- main header start -->
    <div class="main-header d-none d-lg-block">

    {{--       
        <!-- header top start -->
        <div class="header-top bg-gray">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="welcome-message">
                            <p>Welcome to Corano Jewelry online store</p>
                        </div>
                    </div>
                    <div class="col-lg-6 text-right">
                        <div class="header-top-settings">
                            <ul class="nav align-items-center justify-content-end">
                                <li class="curreny-wrap">
                                    $ Currency
                                    <i class="fa fa-angle-down"></i>
                                    <ul class="dropdown-list curreny-list">
                                        <li><a href="#">$ USD</a></li>
                                        <li><a href="#">€ EURO</a></li>
                                    </ul>
                                </li>
                                <li class="language">
                                    <img src="{{ asset(getEnvFolder() . 'frontend/assets/img/icon/en.png') }}" alt="flag"> English
                                    <i class="fa fa-angle-down"></i>
                                    <ul class="dropdown-list">
                                        <li><a href="#"><img src="{{ asset(getEnvFolder() . 'frontend/assets/img/icon/en.png') }}" alt="flag"> english</a></li>
                                        <li><a href="#"><img src="{{ asset(getEnvFolder() . 'frontend/assets/img/icon/fr.png') }}" alt="flag"> french</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- header top end -->
    --}}

        <!-- header middle area start -->
        <div class="header-main-area sticky">
            <div class="container">
                <div class="row align-items-center position-relative">

                    <!-- start logo area -->
                    <div class="col-lg-2">
                        <div class="logo">
                            <a href="{{ route('frontend.index') }}">
                                <img src="{{ asset(getEnvFolder() . 'frontend/assets/img/logo/logo.png') }}" alt="Brand Logo">
                            </a>
                        </div>
                    </div>
                    <!-- start logo area -->

                    <!-- main menu area start -->
                    <div class="col-lg-6 position-static">
                        <div class="main-menu-area">
                            <div class="main-menu">
                                <!-- main menu navbar start -->
                                <nav class="desktop-menu">
                                    <ul>
                                        <li><a @if(request()->routeIs('frontend.index')) style="color: #c29958;" @endif href="{{ route('frontend.index') }}">Accueil</a></li>
                                        <li><a @if(request()->routeIs('frontend.about')) style="color: #c29958;" @endif href="{{ route('frontend.about') }}">À propos</a></li>
                                        <li><a @if(request()->routeIs('frontend.products.index')) style="color: #c29958;" @endif href="{{ route('frontend.products.index') }}">Produits</a></li>
                                        <li><a @if(request()->routeIs('frontend.contact')) style="color: #c29958;" @endif href="{{ route('frontend.contact') }}">Contact</a></li>
                                        <li><a @if(request()->routeIs('frontend.blogs.index')) style="color: #c29958;" @endif href="{{ route('frontend.blogs.index') }}">Blog</a></li>
                                    </ul>
                                </nav>
                                <!-- main menu navbar end -->
                            </div>
                        </div>
                    </div>
                    <!-- main menu area end -->

                    <!-- mini cart area start -->
                    <div class="col-lg-4">
                        <div class="header-right d-flex align-items-center justify-content-end">
                            <div class="header-configure-area">
                                <ul class="nav justify-content-end">
                                    <li class="header-search-container mr-0">
                                        <button class="search-trigger d-block"><i class="pe-7s-search"></i></button>
                                        <form class="header-search-box d-none" action="{{ route('frontend.products.search') }}" method="GET">
                                            @csrf
                                            <input name="query" type="text" placeholder="Rechercher des produits..." class="header-search-field" value="{{ request()->input('query') }}">
                                            <button type="submit" class="header-search-btn"><i class="pe-7s-search"></i></button>
                                        </form>
                                    </li>
                                    <li class="user-hover">
                                        <a href="#">
                                            <i class="pe-7s-user"></i>
                                        </a>
                                        <ul class="dropdown-list">
                                            @auth
                                                <!-- Bouton "Déconnexion" -->
                                                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Déconnexion</a></li>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            @else
                                                <li><a href="{{ route('login') }}">Connexion</a></li>
                                                <li><a href="{{ route('register') }}">Inscription</a></li>
                                            @endauth
                                        </ul>
                                    </li>
                                    {{--<li>
                                        <a href="#">
                                            <i class="pe-7s-like"></i>
                                            <div class="notification">0</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="minicart-btn">
                                            <i class="pe-7s-shopbag"></i>
                                            <div class="notification">2</div>
                                        </a>
                                    </li>--}}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- mini cart area end -->

                </div>
            </div>
        </div>
        <!-- header middle area end -->
    </div>
    <!-- main header start -->

    <!-- mobile header start -->
    <!-- mobile header start -->
    <div class="mobile-header d-lg-none d-md-block sticky">
        <!--mobile header top start -->
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="mobile-main-header">
                        <div class="mobile-logo">
                            <a href="{{ route('frontend.index') }}">
                                <img src="{{ asset(getEnvFolder() . 'frontend/assets/img/logo/logo.png') }}" alt="Brand Logo">
                            </a>
                        </div>
                        <div class="mobile-menu-toggler">
                            {{--<div class="mini-cart-wrap">
                                <a href="#">
                                    <i class="pe-7s-shopbag"></i>
                                    <div class="notification">0</div>
                                </a>
                            </div>--}}
                            <button class="mobile-menu-btn">
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- mobile header top start -->
    </div>
    <!-- mobile header end -->
    <!-- mobile header end -->

    <!-- offcanvas mobile menu start -->
    <!-- off-canvas menu start -->
    <aside class="off-canvas-wrapper">
        <div class="off-canvas-overlay"></div>
        <div class="off-canvas-inner-content">
            <div class="btn-close-off-canvas">
                <i class="pe-7s-close"></i>
            </div>

            <div class="off-canvas-inner">
                <!-- search box start -->
                <div class="search-box-offcanvas">
                    <form action="{{ route('frontend.products.search') }}" method="GET">
                        @csrf

                        <input name="query" type="text" placeholder="Rechercher des produits..." value="{{ request()->input('query') }}">
                        <button type="submit" class="search-btn"><i class="pe-7s-search"></i></button>
                    </form>
                </div>
                <!-- search box end -->

                <!-- mobile menu start -->
                <div class="mobile-navigation">

                    <!-- mobile menu navigation start -->
                    <nav>
                        <ul class="mobile-menu">
                            <li><a @if(request()->routeIs('frontend.index')) style="color: #c29958;" @endif href="{{ route('frontend.index') }}">Accueil</a></li>
                            <li><a @if(request()->routeIs('frontend.about')) style="color: #c29958;" @endif href="{{ route('frontend.about') }}">À propos</a></li>
                            <li><a @if(request()->routeIs('frontend.products.index')) style="color: #c29958;" @endif href="{{ route('frontend.products.index') }}">Produits</a></li>
                            <li><a @if(request()->routeIs('frontend.contact')) style="color: #c29958;" @endif href="{{ route('frontend.contact') }}">Contact</a></li>
                            <li><a @if(request()->routeIs('frontend.blogs.index')) style="color: #c29958;" @endif href="{{ route('frontend.blogs.index') }}">Blog</a></li>
                        </ul>
                    </nav>
                    <!-- mobile menu navigation end -->
                </div>
                <!-- mobile menu end -->

                <div class="mobile-settings">
                    <ul class="nav">
                        {{--<li>
                            <div class="dropdown mobile-top-dropdown">
                                <a href="#" class="dropdown-toggle" id="currency" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Currency
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="currency">
                                    <a class="dropdown-item" href="#">$ USD</a>
                                    <a class="dropdown-item" href="#">$ EURO</a>
                                </div>
                            </div>
                        </li>--}}
                        <li>
                            <div class="dropdown mobile-top-dropdown">
                                <a href="#" class="dropdown-toggle" id="myaccount" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Mon compte
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="myaccount">
                                    @auth
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Se déconnecter</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    @else
                                        <a class="dropdown-item" href="{{ route('frontend.login') }}"> Se connecter</a>
                                        <a class="dropdown-item" href="{{ route('frontend.register') }}"> S'inscrire</a>
                                    @endauth
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- offcanvas widget area start -->
                <div class="offcanvas-widget-area">
                    <div class="off-canvas-contact-widget">
                        <ul>
                            <li><i class="fa fa-mobile"></i>
                                <a href="#">0123456789</a>
                            </li>
                            <li><i class="fa fa-envelope-o"></i>
                                <a href="#">info@yourdomain.com</a>
                            </li>
                        </ul>
                    </div>
                    <div class="off-canvas-social-widget">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-pinterest-p"></i></a>
                        <a href="#"><i class="fa fa-linkedin"></i></a>
                        <a href="#"><i class="fa fa-youtube-play"></i></a>
                    </div>
                </div>
                <!-- offcanvas widget area end -->
            </div>
        </div>
    </aside>
    <!-- off-canvas menu end -->
    <!-- offcanvas mobile menu end -->
</header>
<!-- end Header Area -->