@extends('layouts.app')

@section('content')
<div class="body-content outer-top-xs" id="top-banner-and-menu">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @foreach ($product_type as $data)
                <div id="product-tabs-slider-{{ $data['id'] }}" class="scroll-tabs outer-top-vs wow fadeInUp">
                    <div class="more-info-tab clearfix ">
                        <h3 class="new-product-title pull-left">{{ $data['key_val'] }}</h3>
                        <ul class="nav nav-tabs nav-tab-line pull-right" id="new-products-{{ $data['id'] }}">
                            @foreach ($data['name'] as $index => $name_data)
                            <li class="@if ($loop->first) active @endif">
                                <a data-transition-type="{{ $data['id'] }}" href="#id{{ $data['id'] }}-{{ $loop->iteration }}" data-toggle="tab">{{ $name_data['name'] }}</a>
                            </li>
                            @endforeach
                        </ul>
                        <!-- /.nav-tabs -->
                    </div>
                    <div class="tab-content outer-top-xs">
                        @foreach ($data['product'] as $index => $product_data)
                        <div class="tab-pane @if ($loop->first) in active @endif" id="id{{ $data['id'] }}-{{ $loop->iteration }}">
                            <div class="product-slider">
                                <div class="owl-carousel home-owl-carousel custom-carousel owl-theme" data-item="4">
                                    @foreach ($product_data as $product)
                                    <div class="item item-carousel">
                                        <div class="products">
                                            <div class="product">
                                                <div class="product-image">
                                                    <div class="image">
                                                        <a href="">
                                                            <img src="{{ img_url($product['image']) }}" alt="">
                                                        </a>
                                                    </div>
                                                    <!-- /.image -->
                                                </div>
                                                <!-- /.product-image -->
        
                                                <div class="product-info text-center">
                                                    <div class="product-sec">
                                                        <h3 class="name">
                                                            <a href="">{{ $product['title'] }}</a>
                                                        </h3>
                                                        <div class="rating rateit-small"></div>
                                                        <div class="description"></div>
                                                        <div class="product-price">
                                                            <span class="price"> &#8377;{{ ($product['sale_price']) }}</span>
                                                            <span class="price-before-discount">&#8377;{{ $product['mrp'] }}</span>
                                                        </div>
                                                    </div>
                                                    <!-- /.product-price -->
                                                </div>
                                                <!-- /.product-info -->
                                                <div class="cart clearfix animate-effect">
                                                    <div class="action">
                                                        <ul class="list-unstyled">
                                                            <li class="add-cart-button btn-group">
                                                                <button data-toggle="tooltip" class="btn btn-primary icon" type="button" title="Add Cart">
                                                                    <i class="fa fa-shopping-cart"></i>
                                                                </button>
                                                                <button class="btn btn-primary cart-btn" type="button">Add to cart</button>
                                                            </li>
                                                            <li class="lnk wishlist">
                                                                <a data-toggle="tooltip" class="add-to-cart" href="" title="Wishlist">
                                                                    <i class="icon fa fa-heart"></i>
                                                                </a>
                                                            </li>
                                                            <li class="lnk">
                                                                <a data-toggle="tooltip" class="add-to-cart" href="" title="Compare">
                                                                    <i class="fa fa-signal" aria-hidden="true"></i>
                                                                </a>
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
                                    @endforeach
                                    <!-- /.item -->
                                </div>
                                <!-- /.home-owl-carousel -->
                            </div>
                            <!-- /.product-slider -->
                        </div>
                        @endforeach
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                @endforeach
            </div>
        </div>
        

    </div>
    <!-- /.container -->
</div>
@endsection