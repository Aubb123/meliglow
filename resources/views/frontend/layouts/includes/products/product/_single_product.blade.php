<!-- product item start -->
<div class="product-item">
    <figure class="product-thumb">
        <a href="{{ route('frontend.products.show', $product->token) }}">
            {{-- Image principale --}}
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
            {{-- Badge "new" si créé il y a moins de 7 jours --}}
            @if($product->created_at->diffInDays(getDateTime()) <= 7)
                <div class="product-label new">
                    <span>nouveau</span>
                </div>
            @endif

            {{-- Badge promotion si prix promo existe --}}
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
            {{--
                <a href="#" class="quick-view-btn" data-token="{{ $product->token }}" data-bs-toggle="modal" data-bs-target="#quick_view">
                    <span data-bs-toggle="tooltip" data-bs-placement="left" title="Quick View">
                        <i class="pe-7s-search"></i>
                    </span>
                </a>
            --}}
        </div>

        <div class="cart-hover">
            <a href="{{ route('frontend.products.show', $product->token) }}" class="btn btn-cart">Détails</a>
        </div>
    </figure>

    <div class="product-caption text-center">
        <div class="product-identity">
            <p class="manufacturer-name">
                <a href="#">{{ $product->category->name }}</a>
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
    </div>
</div>
<!-- product item end -->