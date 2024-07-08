@extends('layouts.app')

@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    @if (!empty($category))
                        <li class='active'>{{ $category->title}} @if (!empty($_GET['price']) || !empty($_GET['name']))
                                / {{ !empty($_GET['price']) ? $_GET['price'] . ' price' : $_GET['name'] }}
                            @endif
                        </li>
                        @elseif (!empty($subcategory))
                        <li class='active'>{{ $subcategory->title}} @if (!empty($_GET['price']) || !empty($_GET['name']))
                            / {{ !empty($_GET['price']) ? $_GET['price'] . ' price' : $_GET['name'] }}
                        @endif
                    </li>
                    @elseif (!empty($search))
                    <li class='active'>{{ $search}}
                    </li>
                    @endif

                </ul>
            </div>
            <!-- /.breadcrumb-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.breadcrumb -->
    <div class="body-content outer-top-xs">
      <div class="container">
    @php
        $hasProductInventory = false;
        $ProductInventory = false;
    @endphp

    @foreach ($products as $product)
        @if (!is_null($product->productInventory))
            @php
                $hasProductInventory = true;
                break;
            @endphp
        @endif
    @endforeach

    @if (!empty($productInventories))
        @php
            $hasProductInventory = true;
            $ProductInventory = true;
        @endphp
    @endif

    @if ($hasProductInventory)
        <div class="row">
            <div class="col-md-12">
                <div class="clearfix filters-container m-t-10">
                    <div class="row">
                        <div class="col col-sm-6 col-md-2">
                            <div class="filter-tabs">
                                <ul id="filter-tabs" class="nav nav-tabs nav-tab-box nav-tab-fa-icon">
                                    <li class="active">
                                        <a data-toggle="tab" href="#grid-container">
                                            <i class="icon fa fa-th-large"></i>Grid
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#list-container">
                                            <i class="icon fa fa-th-list"></i>List
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        {{-- <div class="col col-sm-12 col-md-6 ml-auto">
                            <div class="no-padding">
                                <div class="lbl-cnt">
                                    <span class="lbl">Sort by</span>
                                    <div class="fld inline">
                                        <div class="dropdown dropdown-small dropdown-med dropdown-white inline">
                                            <button data-toggle="dropdown" type="button" class="btn dropdown-toggle">
                                                Position <span class="caret"></span>
                                            </button>
                                            <ul role="menu" class="dropdown-menu">
                                                <li role="presentation"><a href="?price=Lowest">Price: Lowest first</a></li>
                                                <li role="presentation"><a href="?price=Highest">Price: Highest first</a></li>
                                                <li role="presentation"><a href="?name=Asc">Product Name: A to Z</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>

                <div class="search-result-container">
                    <div id="myTabContent" class="tab-content category-list">
                        <div class="tab-pane active" id="grid-container">
                            <div class="category-product">
                                <div class="row">
                                    @if(!empty($productInventories))
                                        @foreach ($productInventories as $productInventory)
                                            <div class="col-sm-6 col-md-3 wow fadeInUp">
                                                <div class="products">
                                                    <div class="product">
                                                        <div class="product-image">
                                                            <div class="image">
                                                                <a href="{{ route('detail', encodeRequestData($productInventory->id)) }}">
                                                                    @if (!empty($productInventory->product_image->image))
                                                                        <img src="{{ img_url($productInventory->product_image->image) }}" alt="">
                                                                    @else
                                                                        <img src="" alt="">
                                                                    @endif
                                                                </a>
                                                            </div>
                                                            <div class="tag new"><span>new</span></div>
                                                        </div>
                                                        <div class="product-info text-left">
                                                            <h3 class="name"><a href="{{ route('detail', encodeRequestData($productInventory->id)) }}">{{ $productInventory->title }}</a></h3>
                                                            <div class="rating rateit-small"></div>
                                                            <div class="description"></div>
                                                            <div class="product-price">
                                                                <span class="price">₹{{ $productInventory->sale_price }}</span>
                                                                <span class="price-before-discount">₹{{ $productInventory->mrp }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="cart clearfix animate-effect">
                                                            <div class="action">
                                                                <ul class="list-unstyled">
                                                                    <li class="add-cart-button btn-group">
                                                                        <button class="btn btn-primary icon addToCart" data-pdtid="{{ $productInventory->id }}" data-toggle="dropdown" type="button">
                                                                            <i class="fa fa-shopping-cart"></i>
                                                                        </button>
                                                                        <button class="btn btn-primary cart-btn" type="button">Add to cart</button>
                                                                    </li>
                                                                    <li class="lnk">
                                                                        <a class="add-to-cart wishlist" data-pdtid="{{ $productInventory->id }}" title="Wishlist">
                                                                            <i class="icon fa fa-heart"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li class="lnk">
                                                                        <a class="add-to-cart" href="{{ route('detail', $productInventory->id) }}" title="Compare">
                                                                            <i class="fa fa-signal"></i>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    @foreach ($products as $product)
                                        @if ($product->productInventory != null)
                                            <div class="col-sm-6 col-md-3 wow fadeInUp">
                                                <div class="products">
                                                    <div class="product">
                                                        <div class="product-image">
                                                            <div class="image">
                                                                <a href="{{ route('detail', encodeRequestData($product->productInventory->id)) }}">
                                                                    @if (!empty($product->productInventory->product_image->image))
                                                                        <img src="{{ img_url($product->productInventory->product_image->image) }}" alt="">
                                                                    @else
                                                                        <img src="" alt="">
                                                                    @endif
                                                                </a>
                                                            </div>
                                                            <div class="tag new"><span>new</span></div>
                                                        </div>
                                                        <div class="product-info text-left">
                                                            <h3 class="name"><a href="{{ route('detail', encodeRequestData($product->productInventory->id)) }}">{{ $product->productInventory->title }}</a></h3>
                                                            <div class="rating rateit-small"></div>
                                                            <div class="description"></div>
                                                            <div class="product-price">
                                                                <span class="price">₹{{ $product->productInventory->sale_price }}</span>
                                                                <span class="price-before-discount">₹{{ $product->productInventory->mrp }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="cart clearfix animate-effect">
                                                            <div class="action">
                                                                <ul class="list-unstyled">
                                                                    <li class="add-cart-button btn-group">
                                                                        <button class="btn btn-primary icon addToCart" data-pdtid="{{ $product->productInventory->id }}" data-toggle="dropdown" type="button">
                                                                            <i class="fa fa-shopping-cart"></i>
                                                                        </button>
                                                                        <button class="btn btn-primary cart-btn" type="button">Add to cart</button>
                                                                    </li>
                                                                    <li class="lnk">
                                                                        <a class="add-to-cart wishlist" data-pdtid="{{ $product->productInventory->id }}" title="Wishlist">
                                                                            <i class="icon fa fa-heart"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li class="lnk">
                                                                        <a class="add-to-cart" href="{{ route('detail', $product->productInventory->id) }}" title="Compare">
                                                                            <i class="fa fa-signal"></i>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="list-container">
                            <div class="category-product">
                                @if(!empty($productInventories))
                                    @foreach ($productInventories as $productInventory)
                                        <div class="category-product-inner wow fadeInUp">
                                            <div class="products">
                                                <div class="product-list product">
                                                    <div class="row product-list-row">
                                                        <div class="col col-sm-4 col-lg-4">
                                                            <div class="product-image">
                                                                <div class="image">
                                                                    @if ($productInventory->product_image != null)
                                                                        <img src="{{ img_url($productInventory->product_image->image) }}" alt="">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-sm-8 col-lg-8">
                                                            <div class="product-info">
                                                                <h3 class="name"><a href="{{ route('detail', encodeRequestData($productInventory->id)) }}">{{ $productInventory->title }}</a></h3>
                                                                <div class="rating rateit-small"></div>
                                                                <div class="product-price">
                                                                    <span class="price">₹{{ $productInventory->sale_price }}</span>
                                                                    <span class="price-before-discount">₹{{ $productInventory->mrp }}</span>
                                                                </div>
                                                                <div class="cart clearfix animate-effect">
                                                                    <div class="action">
                                                                        <ul class="list-unstyled">
                                                                            <li class="add-cart-button btn-group">
                                                                                <button class="btn btn-primary icon addToCart" data-pdtid="{{ $productInventory->id }}" data-toggle="dropdown" type="button">
                                                                                    <i class="fa fa-shopping-cart"></i>
                                                                                </button>
                                                                                <button class="btn btn-primary cart-btn addToCart" data-pdtid="{{ $productInventory->id }}" type="button">Add to cart</button>
                                                                            </li>
                                                                            <li class="lnk">
                                                                                <a class="add-to-cart wishlist" data-pdtid="{{ $productInventory->id }}" title="Wishlist">
                                                                                    <i class="icon fa fa-heart"></i>
                                                                                </a>
                                                                            </li>
                                                                            <li class="lnk">
                                                                                <a class="add-to-cart" href="{{ route('detail', encodeRequestData($productInventory->id)) }}" title="Compare">
                                                                                    <i class="fa fa-signal"></i>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tag new"><span>new</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                @foreach ($products as $product)
                                    @if ($product->productInventory != null)
                                        <div class="category-product-inner wow fadeInUp">
                                            <div class="products">
                                                <div class="product-list product">
                                                    <div class="row product-list-row">
                                                        <div class="col col-sm-4 col-lg-4">
                                                            <div class="product-image">
                                                                <div class="image">
                                                                    @if ($product->productInventory->product_image != null)
                                                                        <img src="{{ img_url($product->productInventory->product_image->image) }}" alt="">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-sm-8 col-lg-8">
                                                            <div class="product-info">
                                                                <h3 class="name"><a href="{{ route('detail', encodeRequestData($product->productInventory->id)) }}">{{ $product->productInventory->title }}</a></h3>
                                                                <div class="rating rateit-small"></div>
                                                                <div class="product-price">
                                                                    <span class="price">₹{{ $product->productInventory->sale_price }}</span>
                                                                    <span class="price-before-discount">₹{{ $product->productInventory->mrp }}</span>
                                                                </div>
                                                                <div class="description m-t-10">
                                                                    {!! $product->description !!}
                                                                </div>
                                                                <div class="cart clearfix animate-effect">
                                                                    <div class="action">
                                                                        <ul class="list-unstyled">
                                                                            <li class="add-cart-button btn-group">
                                                                                <button class="btn btn-primary icon addToCart" data-pdtid="{{ $product->productInventory->id }}" data-toggle="dropdown" type="button">
                                                                                    <i class="fa fa-shopping-cart"></i>
                                                                                </button>
                                                                                <button class="btn btn-primary cart-btn addToCart" data-pdtid="{{ $product->productInventory->id }}" type="button">Add to cart</button>
                                                                            </li>
                                                                            <li class="lnk">
                                                                                <a class="add-to-cart wishlist" data-pdtid="{{ $product->productInventory->id }}" title="Wishlist">
                                                                                    <i class="icon fa fa-heart"></i>
                                                                                </a>
                                                                            </li>
                                                                            <li class="lnk">
                                                                                <a class="add-to-cart" href="{{ route('detail', encodeRequestData($product->productInventory->id)) }}" title="Compare">
                                                                                    <i class="fa fa-signal"></i>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tag new"><span>new</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @if (empty($search))
            <span style="color: red;">No Product Found!</span>
        @else
            No matching results for <span style="color: red;">{{ $search }}</span>
        @endif
    @endif

    <div id="brands-carousel" class="logo-slider wow fadeInUp">
        <div class="logo-slider-inner">
            <div id="brand-slider" class="owl-carousel brand-slider custom-carousel owl-theme">
                <div class="item m-t-15">
                    <a href="#" class="image"> <img
                            data-echo="{{ asset('assets/images/brands/brand1.png') }}"
                            src="{{ asset('assets/images/blank.gif') }}" alt=""> </a>
                </div>
                <!--/.item-->

                <div class="item m-t-10">
                    <a href="#" class="image"> <img
                            data-echo="{{ asset('assets/images/brands/brand2.png') }}"
                            src="{{ asset('assets/images/blank.gif') }}" alt=""> </a>
                </div>
                <!--/.item-->

                <div class="item">
                    <a href="#" class="image"> <img
                            data-echo="{{ asset('assets/images/brands/brand3.png') }}"
                            src="{{ asset('assets/images/blank.gif') }}" alt=""> </a>
                </div>
                <!--/.item-->

                <div class="item">
                    <a href="#" class="image"> <img
                            data-echo="{{ asset('assets/images/brands/brand4.png') }}"
                            src="{{ asset('assets/images/blank.gif') }}" alt=""> </a>
                </div>
                <!--/.item-->

                <div class="item">
                    <a href="#" class="image"> <img
                            data-echo="{{ asset('assets/images/brands/brand5.png') }}"
                            src="{{ asset('assets/images/blank.gif') }}" alt=""> </a>
                </div>
                <!--/.item-->

                <div class="item">
                    <a href="#" class="image"> <img
                            data-echo="{{ asset('assets/images/brands/brand6.png') }}"
                            src="{{ asset('assets/images/blank.gif') }}" alt=""> </a>
                </div>
                <!--/.item-->

                <div class="item">
                    <a href="#" class="image"> <img
                            data-echo="{{ asset('assets/images/brands/brand2.png') }}"
                            src="{{ asset('assets/images/blank.gif') }}" alt=""> </a>
                </div>
                <!--/.item-->

                <div class="item">
                    <a href="#" class="image"> <img
                            data-echo="{{ asset('assets/images/brands/brand4.png') }}"
                            src="{{ asset('assets/images/blank.gif') }}" alt=""> </a>
                </div>
                <!--/.item-->

                <div class="item">
                    <a href="#" class="image"> <img
                            data-echo="{{ asset('assets/images/brands/brand1.png') }}"
                            src="{{ asset('assets/images/blank.gif') }}" alt=""> </a>
                </div>
                <!--/.item-->

                <div class="item">
                    <a href="#" class="image"> <img
                            data-echo="{{ asset('assets/images/brands/brand5.png') }}"
                            src="{{ asset('assets/images/blank.gif') }}" alt=""> </a>
                </div>
                <!--/.item-->
            </div>
            <!-- /.owl-carousel #logo-slider -->
        </div>
        <!-- /.logo-slider-inner -->

    </div>
      </div>
    </div>
@endsection
