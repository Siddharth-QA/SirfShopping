@extends('layouts.app')
@section('content')
<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="#">Home</a></li>
                <li class='active'>Checkout</li>
            </ul>
        </div>
        <!-- /.breadcrumb-inner -->
    </div>
    <!-- /.container -->
</div>
<!-- /.breadcrumb -->

<div class="body-content">
    <div class="container">
        <div class="checkout-box ">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel-group checkout-steps" id="accordion">
                        <!-- checkout-step-01  -->
                        <div class="panel panel-default checkout-step-01">
                            @if (session('success'))
                            <div class="alert alert-custom alert-success show" role="alert">
                                <div class="alert-icon">
                                    <span class="flaticon2-check-mark"></span>
                                </div>
                                <div class="alert-text"> {{ session('success') }} </div>
                                <div class="alert-close"></div>
                            </div>

                            @endif
                            @if (session('failed'))
                            <div class="alert alert-custom alert-danger show" role="alert">
                                <div class="alert-icon">
                                    <en class="flaticon2-check-mark"></en>
                                </div>
                                <div class="alert-text"> {{ session('failed') }} </div>
                                <div class="alert-close"></div>
                            </div>
                            @endif
                            <!-- panel-heading -->
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <h4 class="unicase-checkout-title">
                                            <a>
                                                <span>1</span>LOGIN
                                            </a>
                                        </h4>
                                    </div>
                                    <div class="col-xs-6 text-right" style="padding-top: 5px;">
                                        <a data-toggle="collapse" class="btn-center btn btn-primary change"
                                            data-parent="#accordion" href="#collapseOne">
                                            Change
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- panel-heading -->

                            <div id="collapseOne" class="panel-collapse collapse in">

                                <!-- panel-body  -->
                                <div class="panel-body">
                                    <div class="row">
                                        @if (Auth::user())
                                        <div class="col-md-12 col-sm-12 guest-login">
                                            <h4 class="checkout-subtitle">Name : {{ Auth::user()->first_name }}
                                                {{ Auth::user()->last_name }}</h4>
                                            <p class="text title-tag-line">Email : {{ Auth::user()->email }}</p>
                                            <button type="button" data-toggle="collapse"
                                                class="collapsed btn-upper btn btn-primary checkout-page-button checkout-continue"
                                                data-parent="#accordion" href="#collapseTwo">Continue</button>
                                        </div>
                                        @else
                                        <div class="col-md-12 col-sm-12 already-registered-login">
                                            <form class="register-form outer-top-xs" action="{{ route('login') }}"
                                                method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label class="info-title" for="exampleInputEmail1">Email Address
                                                        <span>*</span></label>
                                                    <input type="email" name="log_email"
                                                        class="form-control unicase-form-control text-input" id="">
                                                    @if ($errors->has('log_email'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('log_email') }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label class="info-title" for="exampleInputPassword1">Password
                                                        <span>*</span></label>
                                                    <input type="password" name="log_password"
                                                        class="form-control unicase-form-control text-input" id="">
                                                    @if ($errors->has('log_password'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('log_password') }}</div>
                                                    @enderror
                                                </div>
                                                <button type="submit"
                                                    class="btn-upper btn btn-primary checkout-page-button">Login</button>
                                                <div class="text-right">
                                                    <a href="#" class="forgot-password">Forgot your
                                                        Password?</a> / <a href="{{ route('register') }}">Register</a>
                                                </div>
                                            </form>
                                        </div>
                                        @endif

                                    </div>
                                </div>
                                <!-- panel-body  -->

                            </div>
                            <!-- row -->
                        </div>
                        <!-- checkout-step-02  -->
                        <div class="panel panel-default checkout-step-02">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <h4 class="unicase-checkout-title">
                                            <a>
                                                <span>2</span>Billing Address
                                            </a>
                                        </h4>
                                    </div>
                                    <div class="col-xs-6 text-right" style="padding-top: 5px;">
                                        <a data-toggle="collapse" class="collapsed btn-upper btn btn-primary change"
                                            data-parent="#accordion" href="#collapseTwo">
                                            Change
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse">
                                <div class="col-xs-12 text-right" style="padding:10px 0;">
                                    <a style="cursor: pointer" class="btn-sm btn-primary add cursor-pointer">Add</a>
                                </div>
                                <div class="panel-body checkout-body" id="checkoutAdd">
                                    @foreach ($adds as $add)
                                    <div class="row align-items-center list">
                                        <div class="col-md-1 col-sm-1">
                                            <input type="checkbox" class="pr-2 billingCheckbox" value="{{ $add->id }}"
                                                name="billingId">
                                        </div>
                                        <div class="col-md-10 col-sm-10">
                                            <span><span class="head">{{ Auth::user()->first_name }}
                                                    {{ Auth::user()->last_name }} - {{ $add->mobile }}</span>
                                                <br> {{ $add->address }} {{ $add->label }}
                                                {{ $add->city }} {{ $add->state }}
                                                {{ $add->pin_code }}</span>
                                        </div>
                                        <div class="col-md-1 col-sm-1 text-right edit">
                                            <a href="#">Edit</a>
                                        </div>
                                    </div>
                                    <hr class="hr">
                                    @endforeach
                                    <button type="button" data-toggle="collapse"
                                        class="collapsed btn-upper btn btn-primary checkout-page-button checkout-deliver checkout-continue"
                                        data-parent="#accordion" href="#collapseFive">Continue
                                    </button>

                                </div>
                                <form method="post" class="address-form" id="Billing_address" autocomplete="off">
                                    <input type="hidden" name="_token" id="csrf_token" value="{{ Session::token() }}" />
                                    <input type="hidden" name="id" id="id" value="" />
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="info-title" for="address">Address<span>*</span></label>
                                                <input type="text" name="address"
                                                    class="form-control unicase-form-control text-input address">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="info-title" for="mobile">Mobile<span>*</span></label>
                                                <input type="text" name="mobile"
                                                    class="form-control unicase-form-control text-input mobile">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="info-title" for="label">Label<span>*</span></label>
                                                <input type="text" name="label"
                                                    class="form-control unicase-form-control text-input label-2">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="info-title" for="country">Country<span>*</span></label>
                                                <select name="country"
                                                    class="form-control unicase-form-control text-input country"
                                                    onchange="getstate()">
                                                    @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}">
                                                        {{ $country->title }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="info-title" for="state">State<span>*</span></label>
                                                <select name="state"
                                                    class="form-control unicase-form-control text-input state"></select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="info-title" for="city">City<span>*</span></label>
                                                <input type="text" name="city"
                                                    class="form-control unicase-form-control text-input city">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="info-title" for="pincode">Pin
                                                    Code<span>*</span></label>
                                                <input type="text" name="pincode"
                                                    class="form-control unicase-form-control text-input pin_code">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <div class="d-flex">
                                            <button type="submit"
                                                class="btn btn-primary outer-left-xs mr-2 update-btn">Submit</button>
                                            <button type="button" class="btn btn-danger cancle">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- checkout-step-05  -->
                        <div class="panel panel-default checkout-step-05">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <h4 class="unicase-checkout-title">
                                            <a>
                                                <span>3</span>shipping Address
                                            </a>
                                        </h4>
                                    </div>
                                    <div class="col-xs-6 text-right" style="padding-top: 5px;">
                                        <a data-toggle="collapse" class="collapsed btn-upper btn btn-primary change"
                                            data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                                            Change
                                        </a>
                                    </div>
                                </div>

                            </div>
                            <div id="collapseFive" class="panel-collapse collapse">
                                <div class="panel-body checkout-body" id="shippingAddress">
                                    @foreach ($adds as $add)
                                    <div class="row align-items-center list">
                                        <div class="col-md-1 col-sm-1">
                                            <input type="checkbox" class="pr-2 shippingCheckbox" value="{{ $add->id }}"
                                                name="shippingId">
                                        </div>
                                        <div class="col-md-10 col-sm-10">
                                            <span> <span class="head">{{ Auth::user()->first_name }}
                                                    {{ Auth::user()->last_name }} - {{ $add->mobile }}</span>
                                                <br> {{ $add->address }} {{ $add->label }} {{ $add->city }}
                                                {{ $add->state }} {{ $add->pin_code }}</span>
                                        </div>
                                        <div class="col-md-1 col-sm-1 text-right edit">
                                            {{-- <a href="#">Edit</a> --}}
                                        </div>
                                    </div>
                                    <hr class="hr">
                                    @endforeach
                                    <button type="button" data-toggle="collapse"
                                        class="collapsed btn-upper btn btn-primary checkout-page-button checkout-deliver checkout-continue"
                                        data-parent="#accordion" href="#collapseThree">Deliver Here
                                    </button>
                                    <form method="post" class="address-form" id="shipping_address" autocomplete="off">
                                        <input type="hidden" name="_token" id="csrf_token"
                                            value="{{ Session::token() }}" />
                                        <input type="hidden" name="id" class="id" value="" />
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="info-title"
                                                        for="exampleInputEmail2">Address<span>*</span></label>
                                                    <input type="text" name="address" value=""
                                                        class="form-control unicase-form-control text-input address">
                                                    @if ($errors->has('address'))
                                                    <div class="invalid-feedback">{{ $errors->first('address') }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- /.col-md-6 -->
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="info-title"
                                                        for="exampleInputEmail2">Mobile<span>*</span></label>
                                                    <input type="text" name="mobile" value=""
                                                        class="form-control unicase-form-control text-input mobile">
                                                    @if ($errors->has('mobile'))
                                                    <div class="invalid-feedback">{{ $errors->first('mobile') }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="info-title"
                                                        for="exampleInputEmail2">Label<span>*</span></label>
                                                    <input type="text" name="label" value=""
                                                        class="form-control unicase-form-control text-input label-2">
                                                    @if ($errors->has('label'))
                                                    <div class="invalid-feedback">{{ $errors->first('label') }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="info-title"
                                                        for="exampleInputEmail2">Country<span>*</span></label>
                                                    <select name="country"
                                                        class="form-control unicase-form-control text-input country"
                                                        onchange="getstate()">
                                                        @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}">{{ $country->title }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('country'))
                                                    <div class="invalid-feedback">{{ $errors->first('country') }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="info-title"
                                                        for="exampleInputEmail2">State<span>*</span></label>
                                                    <select name="state"
                                                        class="form-control unicase-form-control text-input state"></select>
                                                    @if ($errors->has('state'))
                                                    <div class="invalid-feedback">{{ $errors->first('state') }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="info-title"
                                                        for="exampleInputEmail2">City<span>*</span></label>
                                                    <input type="text" name="city" value=""
                                                        class="form-control unicase-form-control text-input city">
                                                    @if ($errors->has('city'))
                                                    <div class="invalid-feedback">{{ $errors->first('city') }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="info-title" for="exampleInputEmail2">Pin
                                                        Code<span>*</span></label>
                                                    <input type="text" name="pincode" value=""
                                                        class="form-control unicase-form-control text-input pin_code">
                                                    @if ($errors->has('pincode'))
                                                    <div class="invalid-feedback">{{ $errors->first('pincode') }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- Repeat the above form fields as needed -->
                                        </div>
                                        <!-- /.row -->

                                        <div class="d-flex justify-content-end">
                                            <div class="d-flex">
                                                <button type="submit"
                                                    class="btn btn-primary outer-left-xs mr-2">Update</button>
                                                <button type="button" class="btn btn-danger cancle"
                                                    href="">Cancel</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>
                        <!-- checkout-step-03  -->
                        <div class="panel panel-default checkout-step-03">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <h4 class="unicase-checkout-title">
                                            <a>
                                                <span>4</span>Order Summary
                                            </a>
                                        </h4>
                                    </div>
                                    <div class="col-xs-6 text-right" style="padding-top: 5px;">
                                        <a data-toggle="collapse" class="collapsed btn-upper btn btn-primary change"
                                            data-parent="#accordion" href="#collapseThree">
                                            Change
                                        </a>
                                    </div>
                                </div>

                            </div>
                            <div id="collapseThree" class="panel-collapse collapse">
                                <div class="panel-body" id="summeryList">
                                    @if (count($items['carts']) == 0)
                                    <div class="empty-cart " id="empCart">
                                        <img width="100" src="{{ asset('/assets/images/cart-empty.png') }}">
                                        <h3 class="class-text-center">Your cart is empty!</h3>
                                        <p>Add items to it now.</p><a class="btn btn-upper btn-primary outer-left-xs"
                                            href="/">Shop
                                            Now</a>
                                    </div>
                                    @else
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="cart-description item">Image</th>
                                                    <th class="cart-product-name item">Product Name</th>
                                                    <th class="cart-qty item">Quantity</th>
                                                    <th class="cart-total item">Total</th>
                                                    <th class="cart-remove item">Remove</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($items['carts'] as $cart)
                                                <tr>
                                                    <td class="cart-image">
                                                        <a class="entry-thumbnail"
                                                            href="{{ route('detail', encodeRequestData($cart->pdt->id)) }}">
                                                            @if (!empty($cart->pdt->pdt_img))
                                                            <img style="width: 50px"
                                                                src="{{ img_url($cart->pdt->pdt_img->image) }}" alt="">
                                                            @endif
                                                        </a>
                                                    </td>
                                                    <td class="cart-product-name-info">
                                                        <h4 class='cart-product-description' style="font-size:13px"><a
                                                                href="{{ route('detail', encodeRequestData($cart->pdt->id)) }}">{{
                                                                $cart->pdt->title }}</a>
                                                        </h4>
                                                    </td>
                                                    <td class="cart-quantity">
                                                        <div class="quant-input">
                                                            <div class="arrows checkout-arrows">
                                                                <div class="arrow plus gradient check_out"
                                                                    onclick="updateCart({{ $cart->id }}, {{ $cart->qty }} + 1)">
                                                                    <span class="ir"><i
                                                                            class="icon fa fa-sort-asc"></i></span>
                                                                </div>
                                                                <input type="text" class="text-center"
                                                                    style="width: 40px" id="qty-{{ $cart->id }}"
                                                                    value="{{ $cart->qty }}"
                                                                    onchange="updateCart({{ $cart->id }}, this.value)">
                                                                <input type="hidden" id="id-{{ $cart->id }}"
                                                                    value="{{ $cart->pdt->id }}">
                                                                <div class="arrow minus gradient"
                                                                    onclick="updateCart({{ $cart->id }}, {{ $cart->qty }} - 1)">
                                                                    <span class="ir"><i
                                                                            class="icon fa fa-sort-desc"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="cart-total"><span class="cart-grand-total-price">₹{{
                                                            $cart->total }}</span>
                                                    </td>
                                                    <td class="cart-remove">
                                                        <a onclick="removeCart({{ $cart->id }})" title="cancel"><i
                                                                class="fa fa-trash-o"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr class="hr">
                                    <button type="button" data-toggle="collapse"
                                        class="collapsed btn-upper btn btn-primary checkout-page-button checkout-continue"
                                        data-parent="#accordion" href="#collapseFour">Continue</button>
                                    @endif

                                </div>
                            </div>

                        </div>
                        <!-- checkout-step-04  -->
                        <div class="panel panel-default checkout-step-04">
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a>
                                        <span>5</span>Payment Information
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <input type="text" name="address"
                                                    class="form-control unicase-form-control text-input coupon" id="coupon" placeholder="Apply Coupon">
                                                <div class="invalid-feedback inv-coupon"></div>
                                                <div class="text-success sus-coupon"></div>

                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <div class="form-group">
                                                <button class="btn btn-primary form-control unicase-form-control applyCoupon">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center list">
                                        <div class="col-md-1 col-sm-1">
                                            <input type="checkbox" class="pr-2 cod" value="Cod" name="Cod">
                                        </div>
                                        <div class="col-md-10 col-sm-10">
                                            <span>Cash On Delivery</span>
                                        </div>
                                    </div>
                                    <hr>
                                    <button type="submit"
                                        class=" btn-upper btn btn-primary checkout-page-button pay-now">Order
                                        Now</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.checkout-steps -->
                </div>
                <div class="col-md-4">
                    <!-- checkout-progress-sidebar -->
                    @if (Auth::user())
                    <div class="checkout-progress-sidebar">
                        <div class="panel-group" id="cartSummery">
                            <div class="panel panel-default">
                                @if ($items['qty'] == 0)
                                <div class="empty-cart " id="empCart">
                                    <img width="100" src="{{ asset('/assets/images/cart-empty.png') }}">
                                    <h3 class="class-text-center">Your cart is empty!</h3>
                                    <p>Add items to it now.</p><a class="btn btn-upper btn-primary outer-left-xs"
                                        href="/">Shop
                                        Now</a>
                                </div>
                                @else
                                <div class="panel-heading">
                                    <h4 class="unicase-checkout-title">Cart Summary ({{ $items['qty'] }})</h4>
                                </div>
                                <div class="panel-body">
                                    <ul class="nav nav-checkout-progress list-unstyled">
                                        <li>
                                            <span class="summary-key">Price:</span>
                                            <span class="summary-value" id="amount">{{ $items['taxable_val'] }}</span>
                                        </li>
                                        <hr>
                                        <li>
                                            <span class="summary-key">Discount:</span>
                                            <span class="summary-value" id="discount">{{ $items['discount'] }}</span>
                                        </li>
                                        <hr>
                                        <li>
                                            <span class="summary-key">GST:</span>
                                            <span class="summary-value" id="gst">{{ $items['gst'] }}</span>
                                        </li>
                                        <hr>
                                        <li>
                                            <span class="summary-key">Shipping Charge:</span>
                                            <span class="summary-value" id="shipping">FREE</span>
                                        </li>
                                        <hr>
                                        <li>
                                            <span class="summary-key total-amount-key">Pay Amount:</span>
                                            <span class="summary-value total-amount-value" id="total">{{ $items['total']
                                                }}</span>
                                        </li>
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="checkout-progress-sidebar">
                        <div class="panel-group">
                            Please login First
                        </div>
                    </div>
                    @endif

                    <!-- checkout-progress-sidebar -->
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.checkout-box -->
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
                </div>
                <!-- /.owl-carousel #logo-slider -->
            </div>
            <!-- /.logo-slider-inner -->

        </div>
        <!-- /.logo-slider -->
        <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->
    </div>
    <!-- /.container -->
</div>
@endsection