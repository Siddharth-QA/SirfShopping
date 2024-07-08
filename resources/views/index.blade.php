@extends('layouts.app')
@section('content')
<div class="body-content outer-top-xs" id="top-banner-and-menu">
    <div class="container">
        <div class="row">
            <div id="hero">
                <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">
                    @foreach ($banners as $banner)
                        
                    <div class="item" style="background-image: url('{{ asset('assets/images/' . $banner->img) }}');">
                        <div class="container-fluid">
                            <div class="caption bg-color vertical-center text-left">
                                <div class="slider-header fadeInDown-1">Top Brands</div>
                                <div class="big-text fadeInDown-1"> {{ $banner->title }} </div>
                                <div class="excerpt fadeInDown-2 hidden-xs"> <span>{{ $banner->description }}</span> </div>
                                <div class="button-holder fadeInDown-3"> <a href="/" class="btn-lg btn btn-uppercase btn-primary shop-now-button">Shop Now</a> </div>
                            </div>
                            <!-- /.caption -->
                        </div>
                        <!-- /.container-fluid -->
                    </div>
                    <!-- /.item -->
                    @endforeach
                    <!-- /.item -->
    
                </div>
                <!-- /.owl-carousel -->
            </div>
        </div>
     
        <div class="row">
            @foreach ($product_type as $category)
                @php
                    $categoryHasProducts = false;
                @endphp
                
                @foreach ($category['subcategories'] as $subcategory)
                    @php
                        $subcategoryHasProducts = false;
                    @endphp
                    
                    @foreach ($subcategory['products'] as $product)
                        @if ($product->productInventory != null)
                            @php
                                $categoryHasProducts = true;
                                $subcategoryHasProducts = true;
                                break;
                            @endphp
                        @endif
                    @endforeach

                    @if ($subcategoryHasProducts)
                        @php
                            break;
                        @endphp
                    @endif
                @endforeach
                
                @if ($categoryHasProducts)
                <div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp">
                    <div class="more-info-tab clearfix">
                        <h3 class="new-product-title pull-left">{{ $category['category']['title'] }}</h3>
                        <ul class="nav nav-tabs nav-tab-line pull-right"
                            id="new-products-{{ $category['category']['id'] }}">
                            <li class="active">
                                <a data-transition-type="backSlide" href="#all-{{ $category['category']['id'] }}"
                                    data-toggle="tab">All</a>
                            </li>
                            @foreach ($category['subcategories'] as $subcategory)
                                @php
                                    $subcategoryHasProducts = false;
                                @endphp
                                
                                @foreach ($subcategory['products'] as $product)
                                    @if ($product->productInventory != null)
                                        @php
                                            $subcategoryHasProducts = true;
                                            break;
                                        @endphp
                                    @endif
                                @endforeach

                                @if ($subcategoryHasProducts)
                                <li>
                                    <a data-transition-type="backSlide"
                                        href="#subcategory-{{ $subcategory['subcategory']['id'] }}" data-toggle="tab">{{
                                        $subcategory['subcategory']['title'] }}</a>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                <div class="tab-content outer-top-xs">
                    <div class="tab-pane active" id="all-{{ $category['category']['id'] }}">
                        <div class="product-slider">
                            <div class="owl-carousel home-owl-carousel custom-carousel owl-theme" data-item="4">
                                @foreach ($category['subcategories'] as $subcategory)
                                @foreach ($subcategory['products'] as $product)
                                @if ($product->productInventory != null)
                                <div class="item item-carousel">
                                    <!-- Product HTML here -->
                                    <div class="products">
                                        <div class="product">
                                            <div class="product-image">
                                                <div class="image">
                                                    @if (!empty($product->productInventory->product_image->image))
                                                    <a
                                                        href="{{ route('detail', encodeRequestData($product->productInventory->id)) }}"><img
                                                            src="{{ img_url($product->productInventory->product_image->image) }}"
                                                            alt="">
                                                    </a>
                                                    @endif
                                                </div>
                                                <!-- /.image -->
                                                <div class="tag new"><span>new</span></div>
                                            </div>
                                            <!-- /.product-image -->
                                            <div class="product-info text-left">
                                                <h3 class="name"><a
                                                        href="{{ route('detail', encodeRequestData($product->productInventory->id)) }}">{{
                                                        $product->productInventory->title }}</a>
                                                </h3>
                                                <div class="rating rateit-small"></div>
                                                <div class="description"></div>
                                                <div class="product-price"> <span class="price">
                                                        ₹{{ $product->productInventory->sale_price }}
                                                    </span> <span class="price-before-discount">₹{{
                                                        $product->productInventory->mrp }}</span>
                                                </div>
                                                <!-- /.product-price -->
                                            </div>
                                            <!-- /.product-info -->
                                            <div class="cart clearfix animate-effect">
                                                <div class="action">
                                                    <ul class="list-unstyled">
                                                        <li class="add-cart-button btn-group">
                                                            <button data-toggle="tooltip"
                                                                class="btn btn-primary icon addToCart"
                                                                data-pdtid="{{ $product->productInventory->id }}"
                                                                type="button" title="Add Cart"> <i
                                                                    class="fa fa-shopping-cart"></i>
                                                            </button>
                                                            <button class="btn btn-primary cart-btn" type="button">Add
                                                                to cart</button>
                                                        </li>
                                                        <li class="lnk">
                                                            <a data-toggle="tooltip" class=" wishlist"
                                                                data-pdtid="{{ $product->productInventory->id }}"
                                                                href="detail.html" title="Wishlist"> <i
                                                                    class="icon fa fa-heart"></i> </a>
                                                        </li>
                                                        <li class="lnk">
                                                            <a data-toggle="tooltip" class="add-to-cart"
                                                                href="detail.html" title="Compare"> <i
                                                                    class="fa fa-signal" aria-hidden="true"></i> </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- /.action -->
                                            </div>
                                            <!-- /.cart -->
                                        </div>
                                        <!-- /.product -->
                                    </div>
                                    <!-- /.products -->
                                </div>
                                @endif
                                @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @foreach ($category['subcategories'] as $subcategory)
                    <div class="tab-pane" id="subcategory-{{ $subcategory['subcategory']['id'] }}">
                        <div class="product-slider">
                            <div class="owl-carousel home-owl-carousel custom-carousel owl-theme" data-item="4">
                                @foreach ($subcategory['products'] as $product)
                                @if ($product->productInventory != null)
                                <div class="item item-carousel">
                                    <!-- Product HTML here -->
                                    <div class="products">
                                        <div class="product">
                                            <div class="product-image">
                                                <div class="image">
                                                    @if (!empty($product->productInventory->product_image->image))
                                                    <a
                                                        href="{{ route('detail', encodeRequestData($product->productInventory->id)) }}"><img
                                                            src="{{ img_url($product->productInventory->product_image->image) }}"
                                                            alt="">
                                                    </a>
                                                    @endif
                                                </div>
                                                <!-- /.image -->
                                                <div class="tag new"><span>new</span></div>
                                            </div>
                                            <!-- /.product-image -->
                                            <div class="product-info text-left">
                                                <h3 class="name"><a
                                                        href="{{ route('detail', encodeRequestData($product->productInventory->id)) }}">{{
                                                        $product->productInventory->title }}</a>
                                                </h3>
                                                <div class="rating rateit-small"></div>
                                                <div class="description"></div>
                                                <div class="product-price"> <span class="price">
                                                        ₹{{ $product->productInventory->sale_price }}
                                                    </span> <span class="price-before-discount">₹{{
                                                        $product->productInventory->mrp }}</span>
                                                </div>
                                                <!-- /.product-price -->
                                            </div>
                                            <!-- /.product-info -->
                                            <div class="cart clearfix animate-effect">
                                                <div class="action">
                                                    <ul class="list-unstyled">
                                                        <li class="add-cart-button btn-group">
                                                            <button data-toggle="tooltip"
                                                                class="btn btn-primary icon addToCart"
                                                                data-pdtid="{{ $product->productInventory->id }}"
                                                                type="button" title="Add Cart"> <i
                                                                    class="fa fa-shopping-cart"></i>
                                                            </button>
                                                            <button class="btn btn-primary cart-btn" type="button">Add
                                                                to cart</button>
                                                        </li>
                                                        <li class="lnk">
                                                            <a data-toggle="tooltip" class=" wishlist"
                                                                data-pdtid="{{ $product->productInventory->id }}"
                                                                href="detail.html" title="Wishlist"> <i
                                                                    class="icon fa fa-heart"></i> </a>
                                                        </li>
                                                        <li class="lnk">
                                                            <a data-toggle="tooltip" class="add-to-cart"
                                                                href="detail.html" title="Compare"> <i
                                                                    class="fa fa-signal" aria-hidden="true"></i> </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- /.action -->
                                            </div>
                                            <!-- /.cart -->
                                        </div>
                                        <!-- /.product -->
                                    </div>
                                    <!-- /.products -->
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            @endforeach
        </div>


    </div>
    <!-- /.container -->
</div>
@endsection