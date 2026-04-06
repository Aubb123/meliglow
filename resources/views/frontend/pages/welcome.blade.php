@extends('frontend/layouts/master')

@section('title', 'Accueil')

@section('content')
    <main>

        {{--
            @if($featured_products->count() > 0)
                <!-- hero slider area start -->
                <section class="slider-area">
                    <div class="hero-slider-active slick-arrow-style slick-arrow-style_hero slick-dot-style">

                        <!-- 248.248.248  -->
                        @foreach($featured_products as $featured_product)
                            <!-- single slider item start -->
                            <div class="hero-single-slide hero-overlay">
                                <div class="hero-slider-item bg-img" style="background-color: #f8f8f8;" >
                                    <div class="container">
                                        <div class="row align-items-center">

                                            <!-- Texte à gauche -->
                                            <div class="col-md-6">
                                                <div class="hero-slider-content slide-{{ $loop->iteration }}">
                                                    <h2 class="slide-title fs-1">{{ $featured_product->name }}</h2>
                                                    <h4 class="slide-desc">
                                                        <b style="color: #c29958;">{{ config('app.name') }} : </b>Des produits pensés pour toi, des résultats qui parlent
                                                    </h4>
                                                    <a href="{{ route('frontend.products.show', $featured_product->token) }}" class="btn btn-hero">Lire plus</a>
                                                </div>
                                            </div>

                                            <!-- Image à droite -->
                                            <div class="col-md-6 text-center">
                                                @if(isset($featured_product->getImages()['data']) && count($featured_product->getImages()['data']) > 0)
                                                    <img src="{{ $featured_product->getImages()['data'][0]['url_img'] }}" alt="{{ $featured_product->name }}" class="img-fluid" style="max-height: 450px; object-fit: contain;">
                                                @else
                                                    <img src="{{ $featured_product->getImages()[0]['data']['url_img'] }}" alt="{{ $featured_product->name }}" class="img-fluid" style="max-height: 450px; object-fit: contain;">
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- single slider item end -->
                        @endforeach

                    </div>
                </section>
                <!-- hero slider area end -->
            
                <!-- hero slider area start -->
                <section class="hero-slider-area">
                    <div class="container custom-container p-0">
                        <div class="hero-slider-active-4 slick-dot-style">
                            @foreach($featured_products as $featured_product)
                            <div class="slider-item">
                                <a href="shop.html">
                                    <figure class="slider-thumb">

                                        @if(isset($featured_product->getImages()['data']) && count($featured_product->getImages()['data']) > 0)
                                            <img style="width: 480px; height: 680px; object-fit: cover;" src="{{ $featured_product->getImages()['data'][0]['url_img'] }}" alt="{{ $featured_product->name }}" >
                                        @else
                                            <img style="width: 480px; height: 680px; object-fit: cover;" src="{{ $featured_product->getImages()[0]['data']['url_img'] }}" alt="{{ $featured_product->name }}" >
                                        @endif

                                    </figure>
                                    <div class="slider-item-content">
                                        <h2>top collection</h2>
                                        <h3>Jewelry 2022</h3>
                                        <div class="btn btn-text">shop now</div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
                <!-- hero slider area end -->
            @else
                <div class="text-center py-4">
                    <p>Aucun produit mis en avant pour le moment.</p>
                </div>
            @endif
        --}}
        
        @if($featured_products->count() > 0)
            <!-- hero slider area start -->
            <section class="slider-area">
                <div class="hero-slider-active slick-arrow-style slick-arrow-style_hero slick-dot-style">
                    <!-- single slider item start -->
                    <div class="hero-single-slide hero-overlay">
                        <div class="hero-slider-item bg-img" data-bg="{{ asset(getEnvFolder() . 'frontend/assets/img/slider/home3-slide1.jpg') }}">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="hero-slider-content slide-1">
                                            <h2 class="slide-title">Pearls Spring<span>Collection</span></h2>
                                            <h4 class="slide-desc">New pearl earrings and more from $99</h4>
                                            <a href="shop.html" class="btn btn-hero">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single slider item end -->

                    <!-- single slider item start -->
                    <div class="hero-single-slide hero-overlay">
                        <div class="hero-slider-item bg-img" data-bg="{{ asset(getEnvFolder() . 'frontend/assets/img/slider/home3-slide2.jpg') }}">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="hero-slider-content slide-2">
                                            <h2 class="slide-title">Diamonds Jewelry <span>Collection</span></h2>
                                            <h4 class="slide-desc">Shukra Yogam & Silver Power Silver Saving Schemes.</h4>
                                            <a href="shop.html" class="btn btn-hero">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single slider item start -->

                    <!-- single slider item start -->
                    <div class="hero-single-slide hero-overlay">
                        <div class="hero-slider-item bg-img" data-bg="{{ asset(getEnvFolder() . 'frontend/assets/img/slider/home3-slide3.jpg') }}">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="hero-slider-content slide-3">
                                            <h2 class="slide-title">Family Jewelry <span>Collection</span></h2>
                                            <h4 class="slide-desc">Designer Jewelry Necklaces-Bracelets-Earings</h4>
                                            <a href="shop.html" class="btn btn-hero">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- single slider item start -->
                </div>
            </section>
            <!-- hero slider area end -->
        @else
            <div class="text-center py-4">
                <p>Aucun produit mis en avant pour le moment.</p>
            </div>
        @endif

        @include('frontend/layouts/partials/_about')

        <!-- product area start -->
        <section class="product-area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- section title start -->
                        <div class="section-title text-center">
                            <h2 class="title">Nos Produits</h2>
                            <p class="sub-title">Ajoutez nos produits à votre ligne hebdomadaire</p>
                        </div>
                        <!-- section title start -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="product-container">
                            <!-- product tab menu start -->
                            <div class="product-tab-menu">
                                <ul class="nav justify-content-center">
                                    @foreach($product_categories as $index => $category)
                                        <li>
                                            <a href="#tab{{ $category->id }}" class="{{ $index === 0 ? 'active' : '' }}" data-bs-toggle="tab">
                                                {{ $category->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- product tab menu end -->

                            <!-- product tab content start -->
                            <div class="tab-content">
                                @foreach($product_categories as $index => $category)
                                    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="tab{{ $category->id }}">
                                        <div class="product-carousel-4 slick-row-10 slick-arrow-style">

                                            @forelse($category->products->where('is_visible', true) as $product)
                                                @include('frontend/layouts/includes/products/product/_single_product', ['product' => $product])
                                            @empty
                                                <div class="text-center py-4">
                                                    <p>Aucun produit disponible dans cette catégorie.</p>
                                                </div>
                                            @endforelse

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- product tab content end -->
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- product area end -->

        <!-- product banner statistics area start -->
        <section class="product-banner-statistics">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="product-banner-carousel slick-row-10">
                            @forelse($product_categories as $category)
                                <!-- banner single slide start -->
                                <div class="banner-slide-item">
                                    <figure class="banner-statistics">
                                        <a href="{{ route('frontend.product_categories.show', $category->token) }}">
                                            @if($category->hasCoverImage())
                                                <img style="width: 405px; height: 485px; object-fit: cover;"  src="{{ $category->getCoverImageUrl()['url_img'] }}"  alt="product banner">
                                            @else
                                                <img style="width: 405px; height: 485px; object-fit: cover;"  src="{{ $category->getCoverImageUrl()['url_img'] }}"  alt="product banner">
                                            @endif
                                        </a>
                                        <div class="banner-content banner-content_style2">
                                            <h5 class="banner-text3">
                                                <a href="{{ route('frontend.product_categories.show', $category->token) }}" class="p-3 bg text-white text-center" style="display: block; background-color: #c29958;">{{ $category->name }}</a>
                                            </h5>
                                        </div>
                                    </figure>
                                </div>
                                <!-- banner single slide start -->
                            @empty
                                <!-- banner single slide start -->
                                <div class="banner-slide-item">
                                    <figure class="banner-statistics">
                                        <a href="#">
                                            <img src="{{ asset(getEnvFolder() . 'frontend/assets/img/banner/img1-middle.jpg') }}" alt="product banner">
                                        </a>
                                        <div class="banner-content banner-content_style2">
                                            <h5 class="banner-text3"><a href="#">BRACELATES</a></h5>
                                        </div>
                                    </figure>
                                </div>
                                <!-- banner single slide start -->
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- product banner statistics area end -->

        <!-- featured product area start -->
        <section class="feature-product section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- section title start -->
                        <div class="section-title text-center">
                            <h2 class="title">Nos Produits</h2>
                            <p class="sub-title">
                                Découvrez notre sélection de produits exclusifs, alliant qualité et élégance pour sublimer votre style.
                            </p>
                        </div>
                        <!-- section title start -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="product-carousel-4_2 slick-row-10 slick-arrow-style">
                            @forelse($products as $product)
                                <!-- product item start -->
                                <div class="product-item">
                                    <figure class="product-thumb">
                                        <a href="{{ route('frontend.products.show', $product->token) }}">

                                            <!-- Si $product->getImages()['data'] existe -->
                                            @if(isset($product->getImages()['data']) && count($product->getImages()['data']) > 0)
                                                {{-- width: 258px; height: 258px; --}}
                                                <img style="object-fit: cover;" class="pri-img" src="{{ $product->getImages()['data'][0]['url_img'] }}" alt="{{ $product->name }}">
                                            @else
                                                <img style="object-fit: cover;" class="pri-img" src="{{ $product->getImages()[0]['data']['url_img'] }}" alt="{{ $product->name }}">
                                            @endif

                                            @if(isset($product->getImages()['data']) && count($product->getImages()['data']) > 0)
                                                <img style="object-fit: cover;" class="sec-img" src="{{ isset($product->getImages()['data'][1]) ? $product->getImages()['data'][1]['url_img'] : $product->getImages()['data'][0]['url_img'] }}" alt="{{ $product->name }}">
                                            @else
                                                <img style="object-fit: cover;" class="sec-img" src="{{ $product->getImages()[0]['data']['url_img'] }}" alt="{{ $product->name }}">
                                            @endif

                                        </a>

                                        <div class="product-badge">
                                            {{-- Badge "New" si créé il y a moins de 7 jours --}}
                                            @if($product->created_at->diffInDays(getDateTime()) <= 7)
                                                <div class="product-label new">
                                                    <span>nouveauté</span>
                                                </div>
                                            @endif

                                            @if($product->promotional_price)
                                                @php
                                                    $discount = round((($product->sale_price - $product->promotional_price) / $product->sale_price) * 100);
                                                @endphp
                                                <div class="product-label discount">
                                                    <span>{{ $discount }}%</span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="button-group">
                                            <!--  -->
                                        </div>

                                        <div class="cart-hover">
                                            <button class="btn btn-cart">Détails</button>
                                            @if($product->stock > 0)
                                            @else
                                                <button class="btn btn-cart" disabled> Rupture de stock </button>
                                            @endif
                                        </div>
                                    </figure>

                                    <div class="product-caption text-center">
                                        <div class="product-identity">
                                            <p class="manufacturer-name">
                                                <a href="#">{{ $product->category->name ?? 'N/A' }}</a>
                                            </p>
                                        </div>

                                        <h6 class="product-name">
                                            <a href="{{ route('frontend.products.show', $product->token) }}">
                                                {{ Str::limit($product->name, 30) }}
                                            </a>
                                        </h6>

                                        <div class="price-box">
                                            @if($product->promotional_price)
                                                <span class="price-regular">{{ number_format($product->promotional_price, 0, ',', ' ') }} CFA</span>
                                                <span class="price-old"><del>{{ number_format($product->sale_price, 0, ',', ' ') }} CFA</del></span>
                                            @else
                                                <span class="price-regular">{{ number_format($product->sale_price, 0, ',', ' ') }} CFA</span>
                                            @endif
                                        </div>

                                        @if($product->stock > 0 && $product->stock <= 5)
                                            <p class="text-danger" style="font-size: 12px;">
                                                Plus que {{ $product->stock }} en stock !
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <!-- product item end -->
                            @empty
                                <div class="text-center py-4">
                                    <p>Aucun produit disponible pour le moment.</p>
                                </div>
                            @endforelse
                        </div>
                        <!-- Si il reste des produits à afficher -->
                        @if($products->hasMorePages())
                            <div class="text-center py-4">
                                <div class="contact-btn">
                                    <a class="btn btn-sqr" type="submit" href="{{ route('frontend.products.index') }}">Voir plus</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <!-- featured product area end -->

        @include('frontend/layouts/partials/_choosing')

        @include('frontend/layouts/partials/_testimonial')

        <!-- brand logo area start -->
        <div class="brand-logo section-padding pt-0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="brand-logo-carousel slick-row-10 slick-arrow-style">
                            <!-- single brand start -->
                            <div class="brand-item">
                                <a href="#">
                                    <img src="{{ asset(getEnvFolder() . 'frontend/assets/img/brand/1.png') }}" alt="">
                                </a>
                            </div>
                            <!-- single brand end -->

                            <!-- single brand start -->
                            <div class="brand-item">
                                <a href="#">
                                    <img src="{{ asset(getEnvFolder() . 'frontend/assets/img/brand/2.png') }}" alt="">
                                </a>
                            </div>
                            <!-- single brand end -->

                            <!-- single brand start -->
                            <div class="brand-item">
                                <a href="#">
                                    <img src="{{ asset(getEnvFolder() . 'frontend/assets/img/brand/3.png') }}" alt="">
                                </a>
                            </div>
                            <!-- single brand end -->

                            <!-- single brand start -->
                            <div class="brand-item">
                                <a href="#">
                                    <img src="{{ asset(getEnvFolder() . 'frontend/assets/img/brand/4.png') }}" alt="">
                                </a>
                            </div>
                            <!-- single brand end -->

                            <!-- single brand start -->
                            <div class="brand-item">
                                <a href="#">
                                    <img src="{{ asset(getEnvFolder() . 'frontend/assets/img/brand/5.png') }}" alt="">
                                </a>
                            </div>
                            <!-- single brand end -->

                            <!-- single brand start -->
                            <div class="brand-item">
                                <a href="#">
                                    <img src="{{ asset(getEnvFolder() . 'frontend/assets/img/brand/6.png') }}" alt="">
                                </a>
                            </div>
                            <!-- single brand end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- brand logo area end -->
    </main>


@endsection
