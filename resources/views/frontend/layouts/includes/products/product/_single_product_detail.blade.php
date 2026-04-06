<!-- page main wrapper start -->
<div class="shop-main-wrapper section-padding pb-0">
    <div class="container">
        <div class="row">
            <!-- product details wrapper start -->
            <div class="col-lg-12 order-1 order-lg-2">
                <!-- product details inner start -->
                <div class="product-details-inner">
                    <div class="row">

                        {{-- ===== COLONNE IMAGES ===== --}}
                        <div class="col-lg-5">
                            <div class="product-large-slider">
                                @if($product->hasCoverImage())
                                    @foreach($product->getImages()['data'] as $image)
                                        <div class="pro-large-img img-zoom">
                                            <img style="width: 600px; height: 400px;" src="{{ $image['url_img'] }}" alt="{{ $product->name }}" />
                                        </div>
                                    @endforeach
                                @else
                                    <div class="pro-large-img img-zoom">
                                        <img style="width: 600px; height: 400px;" src="{{ $product->getImages()[0]['data']['url_img'] }}" alt="{{ $product->name }}" />
                                    </div>
                                @endif
                            </div>
                            <div class="pro-nav slick-row-10 slick-arrow-style">
                                @if($product->hasCoverImage())
                                    @foreach($product->getImages()['data'] as $image)
                                        <div class="pro-nav-thumb">
                                            <img style="width: 95px; height: 95px;" src="{{ $image['url_img'] }}" alt="{{ $product->name }}" />
                                        </div>
                                    @endforeach
                                @else
                                    <div class="pro-nav-thumb">
                                        <img style="width: 95px; height: 95px;" src="{{ $product->getImages()[0]['data']['url_img'] }}" alt="{{ $product->name }}" />
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- ===== COLONNE INFOS PRODUIT ===== --}}
                        <div class="col-lg-7">
                            <div class="product-details-des">

                                {{-- Catégorie --}}
                                <div class="manufacturer-name">
                                    <a href="#">{{ $product->category->name }}</a>
                                </div>

                                {{-- Nom du produit --}}
                                <h3 class="product-name">{{ $product->name }}</h3>

                                {{-- Prix --}}
                                <div class="price-box">
                                    @if($product->promotional_price)
                                        <span class="price-regular">{{ number_format($product->promotional_price, 0, ',', ' ') }} CFA</span>
                                        <span class="price-old"><del>{{ number_format($product->sale_price, 0, ',', ' ') }} CFA</del></span>
                                    @else
                                        <span class="price-regular">{{ number_format($product->sale_price, 0, ',', ' ') }} CFA</span>
                                    @endif
                                </div>

                                {{-- Offre promotionnelle --}}
                                @if($product->promotional_price)
                                    @php
                                        $discount = round((($product->sale_price - $product->promotional_price) / $product->sale_price) * 100);
                                    @endphp
                                    <h5 class="offer-text"><strong>Offre spéciale</strong> — {{ $discount }}% de réduction !</h5>
                                @endif

                                {{-- Stock --}}
                                <div class="availability">
                                    @if($product->stock <= 10 && $product->stock > 0)
                                        <i class="fa fa-check-circle" style="color: green;"></i>
                                        <span>{{ $product->stock }} en stock</span>
                                    @else
                                        @if($product->stock <= 0)
                                        <i class="fa fa-times-circle" style="color: red;"></i>
                                        <span>Rupture de stock</span>
                                        @else
                                        <i class="fa fa-check-circle" style="color: green;"></i>
                                        <span>En stock</span>
                                        @endif
                                    @endif
                                </div>

                                {{-- Description courte --}}
                                <p class="pro-desc">{{ Str::limit($product->description, 300) }}</p>

                                <div class="quantity-cart-box d-flex align-items-center">
                                    <div class="action_link">
                                        <!-- Bouton Acheter qui redirige vers le compte whatsapp -->
                                        <a href="https://wa.me/{{ config('app.whatsapp_number') }}?text=Bonjour%20!%20Je%20suis%20intéressé(e)%20par%20le%20produit%20{{ urlencode($product->name) }}" class="btn btn-cart2" target="_blank">
                                            <i class="fa fa-whatsapp"></i> Acheter
                                        </a>
                                    </div>
                                </div>

                                {{-- Badges nouveau / promo --}}
                                <div class="mb-3">
                                    @if($product->created_at->diffInDays(getDateTime()) <= 7)
                                        <span class="badge bg-success me-2">Nouveau</span>
                                    @endif
                                    @if($product->is_featured)
                                        <span class="badge bg-warning text-dark">Mis en avant</span>
                                    @endif
                                </div>

                                {{-- Partage réseaux sociaux --}}
                                <div class="like-icon">
                                    <a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank">
                                        <i class="fa fa-facebook"></i>like
                                    </a>
                                    {{--<a class="twitter" href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($product->name) }}" target="_blank">
                                        <i class="fa fa-twitter"></i>tweet
                                    </a>
                                    <a class="pinterest" href="https://pinterest.com/pin/create/button/?url={{ urlencode(request()->fullUrl()) }}" target="_blank">
                                        <i class="fa fa-pinterest"></i>save
                                    </a>--}}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- product details inner end -->

                <!-- product details reviews start -->
                <div class="product-details-reviews section-padding pb-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="product-review-info">
                                <ul class="nav review-tab">
                                    <li>
                                        <a class="active" data-bs-toggle="tab" href="#tab_one">Description</a>
                                    </li>
                                    <li>
                                        <a data-bs-toggle="tab" href="#tab_two">Informations</a>
                                    </li>
                                </ul>

                                <div class="tab-content reviews-tab">

                                    {{-- Onglet Description --}}
                                    <div class="tab-pane fade show active" id="tab_one">
                                        <div class="tab-one">
                                            <p>{{ $product->description }}</p>
                                        </div>
                                    </div>

                                    {{-- Onglet Informations --}}
                                    <div class="tab-pane fade" id="tab_two">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td><strong>Catégorie</strong></td>
                                                    <td>{{ $product->category->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Prix de vente</strong></td>
                                                    <td>{{ number_format($product->sale_price, 0, ',', ' ') }} CFA</td>
                                                </tr>
                                                @if($product->promotional_price)
                                                    <tr>
                                                        <td><strong>Prix promotionnel</strong></td>
                                                        <td>{{ number_format($product->promotional_price, 0, ',', ' ') }} CFA</td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td><strong>Stock disponible</strong></td>
                                                    <td>
                                                        @if($product->stock <= 10 && $product->stock > 0)
                                                            {{ $product->stock }} unité(s)
                                                        @else
                                                            <span class="text-danger">Rupture de stock</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                {{--<tr>
                                                    <td><strong>Vues</strong></td>
                                                    <td>{{ $product->views }}</td>
                                                </tr>--}}
                                                <tr>
                                                    <td><strong>Dernière mise à jour</strong></td>
                                                    <td>{{ $product->updated_at->format('d/m/Y') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Référence</strong></td>
                                                    <td>{{ strtoupper($product->token) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- product details reviews end -->

            </div>
            <!-- product details wrapper end -->
        </div>
    </div>
</div>
<!-- page main wrapper end -->