@extends('frontend/layouts/master')

@section('title', 'Détail du produit: ' . $product->name)

@section('content')

    @include('frontend/layouts/partials/_breadcrumb', ['title' => 'Détail du produit: ' . $product->name])

     <br>

     @include('frontend/layouts/includes/products/product/_single_product_detail', ['product' => $product])

     <!-- related products area start -->
    <section class="related-products section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- section title start -->
                    <div class="section-title text-center">
                        <h2 class="title">Produits similaires</h2>
                        <p class="sub-title">
                            Découvrez d'autres produits de la même catégorie qui pourraient vous intéresser.
                        </p>
                    </div>
                    <!-- section title start -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-carousel-4 slick-row-10 slick-arrow-style">
                        @forelse($similarProducts as $similarProduct)
                            @include('frontend/layouts/includes/products/product/_single_product', ['product' => $similarProduct])
                        @empty
                            <div class="text-center py-4">
                                <p>Aucun produit similaire disponible pour le moment.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- related products area end -->

@endsection