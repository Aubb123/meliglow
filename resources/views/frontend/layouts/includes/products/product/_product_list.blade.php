<div class="shop-main-wrapper section-padding">
    <div class="container">
        <div class="row">
            <!-- sidebar area start -->
            <div class="col-lg-3 order-2 order-lg-1">
                <aside class="sidebar-wrapper">
                    <!-- single sidebar start -->
                    <div class="sidebar-single">
                        <h5 class="sidebar-title">Categories</h5>
                        <div class="sidebar-body">
                            <ul class="shop-categories">
                                @foreach($productCategories as $category)
                                    <li><a href="{{ route('frontend.product_categories.show', ['token' => $category->token]) }}" @if(isset($categ->token) && $categ->token === $category->token) style="background-color: #c29958; color: white;" @endif >{{ $category->name }} <span>({{ $category->products->where('is_visible', true)->count() }})</span></a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- single sidebar end -->
                </aside>
            </div>
            <!-- sidebar area end -->

            <!-- shop main wrapper start -->
            <div class="col-lg-9 order-1 order-lg-2">
                <div class="shop-product-wrapper">
                    <!-- shop product top wrap start -->
                    <div class="shop-top-bar">
                        <div class="row align-items-center">
                            <div class="col-lg-7 col-md-6 order-2 order-md-1">
                                <div class="top-bar-left">
                                    {{--
                                        <div class="product-view-mode">
                                            <a class="active" href="#" data-target="grid-view" data-bs-toggle="tooltip" aria-label="Grid View" data-bs-original-title="Grid View"><i class="fa fa-th"></i></a>
                                            <a href="#" data-target="list-view" data-bs-toggle="tooltip" aria-label="List View" data-bs-original-title="List View"><i class="fa fa-list"></i></a>
                                        </div>
                                    --}}
                                    <div class="product-amount">
                                        <p>Affichage des résultats {{ $products->firstItem() }}–{{ $products->lastItem() }} SUR {{ $products->total() }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6 order-1 order-md-2">
                                <div class="top-bar-right">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- shop product top wrap start -->

                    <!-- product item list wrapper start -->
                    <div class="shop-product-wrap grid-view row mbn-30">
                        
                        @forelse ($products as $product)
                            <div class="col-md-4 col-sm-6">
                                @include('frontend/layouts/includes/products/product/_single_product', ['product' => $product])
                            </div>
                        @empty
                            <div class="alert alert-info">
                                <p class="text-center">Aucun produit trouvé.</p>
                            </div>
                        @endforelse

                    </div>
                    <!-- product item list wrapper end -->

                    <!-- start pagination area -->
                    <div class="paginatoin-area text-center">
                        {{ $products->appends(request()->input())->links('vendor.pagination.bootstrap-4') }}         
                    </div>
                    <!-- end pagination area -->
                </div>
            </div>
            <!-- shop main wrapper end -->
        </div>
    </div>
</div>