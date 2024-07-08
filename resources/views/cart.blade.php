@extends('layouts.app')

@section('content')
<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="#">Home</a></li>
                <li class='active'>Shopping Cart</li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content outer-top-xs">
    <div class="container">
        <div class="row cart-list myCart" id="myCart">
            @if (!empty($sessionItems['cartItems']))
            <div class="shopping-cart">
                @if ($sessionItems['qty'] == 0)
                <div class="empty-cart " id="empCart">
                    <img width="200" src="{{ asset('/assets/images/cart-empty.png') }}">
                    <h3 class="class-text-center">Your cart is empty!</h3>
                    <p>Add items to it now.</p><a class="btn btn-upper btn-primary outer-left-xs" href="/">Shop Now</a>
                </div>
                @else
                <div class="shopping-cart-table ">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="cart-description item">Image</th>
                                    <th class="cart-product-name item">Product Name</th>
                                    <th class="cart-qty item">Quantity</th>
                                    <th class="cart-sub-total item">Price</th>
                                    <th class="cart-total last-item">Total</th>
                                    <th class="cart-romove item">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sessionItems['cartItems'] as $cart)
                                <tr>
                                    <td class="cart-image">
                                        <a class="entry-thumbnail"
                                            href="{{ route('detail', encodeRequestData($cart->attributes->product)) }}">
                                            <img src="{{ img_url($cart->attributes->image) }}" alt="">
                                        </a>
                                    </td>
                                    <td class="cart-product-name-info">
                                        <h4 class='cart-product-description'>
                                            <a
                                                href="{{ route('detail', encodeRequestData($cart->attributes->product)) }}">{{
                                                $cart->name }}</a>
                                        </h4>
                                    </td>
                                    <td class="cart-quantity">
                                        <div class="quant-input">
                                            <div class="arrows">
                                                <div class="arrow plus gradient" onclick="changeQuantity(this, 'plus')">
                                                    <span class="ir"><i class="icon fa fa-sort-asc"></i></span>
                                                </div>
                                                <div class="arrow minus gradient"
                                                    onclick="changeQuantity(this, 'minus')">
                                                    <span class="ir"><i class="icon fa fa-sort-desc"></i></span>
                                                </div>
                                            </div>
                                            <input type="text" class="qty-input" value="{{ $cart->quantity }}">
                                            <input type="hidden" class="id-input" value="{{ $cart->attributes->product }}">
                                        </div>
                                    </td>
                                    
                                    <td class="cart-product-sub-total">
                                        <span class="cart-sub-total-price">₹{{ number_format($cart->price, 2) }}</span>
                                    </td>
                                    <td class="cart-product-grand-total">
                                        <span class="cart-grand-total-price">₹{{ number_format($cart->quantity *
                                            $cart->price, 2) }}</span>
                                    </td>
                                    <td class="romove-item">
                                        <a onclick="removeCart({{ $cart->id }})" style="color: #e31212" title="cancel"
                                            class="icon">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <hr>
                        <tfoot>
                            <tr>
                                <td colspan="">
                                    <div class="shopping-cart-btn">
                                        <span class="">
                                            <a href="{{ route('index') }}"
                                                class="btn btn-upper btn-primary outer-left-xs">Continue
                                                Shopping</a>
                                            <a href="{{ Auth::user() ? route('check-out') : route('login.index') }}"
                                                class="btn  btn-upper btn-warning pull-right outer-right-xs">Proceed
                                                To Buy</a>
                                        </span>
                                    </div><!-- /.shopping-cart-btn -->
                                </td>
                            </tr>
                        </tfoot>
                    </div>
                </div><!-- /.shopping-cart-table -->
                @endif
                <!-- /.cart-shopping-total -->
            </div>
            @else
            <div class="shopping-cart">
                @if (count($items['carts']) == 0)
                <div class="empty-cart " id="empCart">
                    <img width="200" src="{{ asset('/assets/images/cart-empty.png') }}">
                    <h3 class="class-text-center">Your cart is empty!</h3>
                    <p>Add items to it now.</p><a class="btn btn-upper btn-primary outer-left-xs" href="/">Shop Now</a>
                </div>
                @else
                <div class="shopping-cart-table ">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="cart-description item">Image</th>
                                    <th class="cart-product-name item">Product Name</th>
                                    <th class="cart-qty item">Quantity</th>
                                    <th class="cart-sub-total item">Price</th>
                                    <th class="cart-total last-item">Total</th>
                                    <th class="cart-romove item">Action</th>
                                </tr>
                            </thead><!-- /thead -->
                            <tbody class="cart-tr">
                                @foreach ($items['carts'] as $cart)
                                <tr>
                                    <td class="cart-image">
                                        <a class="entry-thumbnail"
                                            href="{{ route('detail', encodeRequestData($cart->pdt->id)) }}">
                                            @if (!empty($cart->pdt->pdt_img))
                                            <img src="{{ img_url($cart->pdt->pdt_img->image) }}" alt="">
                                            @endif
                                        </a>
                                    </td>
                                    <td class="cart-product-name-info">
                                        <h4 class='cart-product-description'><a
                                                href="{{ route('detail', encodeRequestData($cart->pdt->id)) }}">{{
                                                $cart->pdt->title }}</a>
                                        </h4>
                                    </td>
                                    <td class="cart-quantity">
                                        <div class="quant-input">
                                            <div class="arrows">
                                                <div class="arrow plus gradient" onclick="changeQuantity(this, 'plus')">
                                                    <span class="ir"><i class="icon fa fa-sort-asc"></i></span>
                                                </div>
                                                <div class="arrow minus gradient"
                                                    onclick="changeQuantity(this, 'minus')">
                                                    <span class="ir"><i class="icon fa fa-sort-desc"></i></span>
                                                </div>
                                            </div>
                                            <input type="text" class="qty-input" value="{{ $cart->qty }}">
                                            <input type="hidden" class="id-input" value="{{ $cart->id }}">
                                        </div>
                                    </td>
                                    <td class="cart-product-sub-total"><span class="cart-sub-total-price">₹{{
                                            $cart->price }}</span>
                                    </td>
                                    <td class="cart-product-grand-total"><span class="cart-grand-total-price">₹{{
                                            $cart->total }}</span>
                                    </td>
                                    <td class="romove-item">
                                        <div>
                                            <a onclick="removeCart({{ $cart->id }})" style="color: #e31212;"
                                                title="cancel" class="icon"><i class="fa fa-trash-o"></i>
                                            </a>
                                            <a class="save_later" onclick="save_later({{ $cart->id }})"
                                                style="color: #fdd922" title="save Later" class="icon"><i
                                                    class="fa fas fa-save fas-icon"></i>
                                            </a>
                                        </div>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody><!-- /tbody -->
                        </table><!-- /table -->
                        <hr>
                        <tfoot>
                            <tr>
                                <td colspan="">
                                    <div class="shopping-cart-btn">
                                        <span class="">
                                            <a href="{{ route('index') }}"
                                                class="btn btn-upper btn-primary outer-left-xs">Continue
                                                Shopping</a>
                                            <a href="{{ Auth::user() ? route('check-out') : route('login.index') }}"
                                                class="btn  btn-upper btn-warning pull-right outer-right-xs">Proceed
                                                To Buy</a>
                                        </span>
                                    </div><!-- /.shopping-cart-btn -->
                                </td>
                            </tr>
                        </tfoot>
                    </div>
                </div>
                @endif
            </div>
            @endif
        </div>
        <br>
        <br>
        @if (empty($sessionItems['cartItems']))
        <div class="row save_later-list" id="laterCart">
            @if (count($items['save_later']) != 0)
            <div class="shopping-cart">
                <div class="shopping-cart-table ">
                    <h5 style="font-weight: bold">Saved for Later ({{ count($items['save_later']) }})</h5 class="bold">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="cart-description item">Image</th>
                                    <th class="cart-product-name item">Product Name</th>
                                    <th class="cart-qty item">Quantity</th>
                                    <th class="cart-sub-total item">Price</th>
                                    <th class="cart-total last-item">Total</th>
                                    <th class="cart-romove item">Action</th>
                                </tr>
                            </thead><!-- /thead -->
                            <tbody class="save_later-tr">
                                @foreach ($items['save_later'] as $cart)
                                <tr>
                                    <td class="cart-image">
                                        <a class="entry-thumbnail"
                                            href="{{ route('detail', encodeRequestData($cart->pdt->id)) }}">
                                            @if (!empty($cart->pdt->pdt_img))
                                            <img src="{{ img_url($cart->pdt->pdt_img->image) }}" alt="">
                                            @endif
                                        </a>
                                    </td>
                                    <td class="cart-product-name-info">
                                        <h4 class='cart-product-description'><a
                                                href="{{ route('detail', encodeRequestData($cart->pdt->id)) }}">{{
                                                $cart->pdt->title }}</a>
                                        </h4>
                                    </td>
                                    <td class="cart-quantity">
                                        <div class="quant-input">
                                            <div class="arrows">
                                                <div class="arrow plus gradient" onclick="changeQuantity(this, 'plus')">
                                                    <span class="ir"><i class="icon fa fa-sort-asc"></i></span>
                                                </div>
                                                <div class="arrow minus gradient"
                                                    onclick="changeQuantity(this, 'minus')">
                                                    <span class="ir"><i class="icon fa fa-sort-desc"></i></span>
                                                </div>
                                            </div>
                                            <input type="text" class="qty-input" value="{{ $cart->qty }}">
                                            <input type="hidden" class="id-input" value="{{ $cart->id }}">
                                        </div>
                                    </td>
                                    <td class="cart-product-sub-total"><span class="cart-sub-total-price">₹{{
                                            $cart->price }}</span>
                                    </td>
                                    <td class="cart-product-grand-total"><span class="cart-grand-total-price">₹{{
                                            $cart->total }}</span>
                                    </td>
                                    <td class="romove-item">
                                        <div>
                                            <a onclick="removeCart({{ $cart->id }})" style="color: #e31212;"
                                                title="cancel" class="icon"><i class="fa fa-trash-o"></i>
                                            </a>
                                            <a class="save_later" onclick="save_later({{ $cart->id }})"
                                                style="color: #fdd922" title="Add To Cart" class="icon"><i
                                                    class="fa fa-shopping-cart fas-icon"></i>
                                            </a>
                                        </div>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody><!-- /tbody -->
                        </table><!-- /table -->
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endif
        <!-- /.row -->
        <!-- ============================================== BRANDS CAROUSEL ============================================== -->
        <div id="brands-carousel" class="logo-slider wow fadeInUp">

            <div class="logo-slider-inner">
                <div id="brand-slider" class="owl-carousel brand-slider custom-carousel owl-theme">
                    <div class="item m-t-15">
                        <a href="#" class="image">
                            <img data-echo="assets/images/brands/brand1.png" src="assets/images/blank.gif" alt="">
                        </a>
                    </div>
                    <!--/.item-->

                    <div class="item m-t-10">
                        <a href="#" class="image">
                            <img data-echo="assets/images/brands/brand2.png" src="assets/images/blank.gif" alt="">
                        </a>
                    </div>
                    <!--/.item-->

                    <div class="item">
                        <a href="#" class="image">
                            <img data-echo="assets/images/brands/brand3.png" src="assets/images/blank.gif" alt="">
                        </a>
                    </div>
                    <!--/.item-->

                    <div class="item">
                        <a href="#" class="image">
                            <img data-echo="assets/images/brands/brand4.png" src="assets/images/blank.gif" alt="">
                        </a>
                    </div>
                    <!--/.item-->

                    <div class="item">
                        <a href="#" class="image">
                            <img data-echo="assets/images/brands/brand5.png" src="assets/images/blank.gif" alt="">
                        </a>
                    </div>
                    <!--/.item-->

                    <div class="item">
                        <a href="#" class="image">
                            <img data-echo="assets/images/brands/brand6.png" src="assets/images/blank.gif" alt="">
                        </a>
                    </div>
                    <!--/.item-->

                    <div class="item">
                        <a href="#" class="image">
                            <img data-echo="assets/images/brands/brand2.png" src="assets/images/blank.gif" alt="">
                        </a>
                    </div>
                    <!--/.item-->

                    <div class="item">
                        <a href="#" class="image">
                            <img data-echo="assets/images/brands/brand4.png" src="assets/images/blank.gif" alt="">
                        </a>
                    </div>
                    <!--/.item-->

                    <div class="item">
                        <a href="#" class="image">
                            <img data-echo="assets/images/brands/brand1.png" src="assets/images/blank.gif" alt="">
                        </a>
                    </div>
                    <!--/.item-->

                    <div class="item">
                        <a href="#" class="image">
                            <img data-echo="assets/images/brands/brand5.png" src="assets/images/blank.gif" alt="">
                        </a>
                    </div>
                    <!--/.item-->
                </div><!-- /.owl-carousel #logo-slider -->
            </div><!-- /.logo-slider-inner -->

        </div><!-- /.logo-slider -->
        <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->
    </div>
</div><!-- /.body-content -->


@endsection