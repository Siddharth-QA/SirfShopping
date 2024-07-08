@extends('layouts.app')

@section('content')
<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="home.html">Home</a></li>
                <li class='active'>Login</li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
    <div class="container" style="display: flex; justify-content: center; align-items:flex-start;margin-bottom:40px">

        <div class="sign-in-page col-sm-12 col-lg-6" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,.08);padding: 20px;overflow: hidden;background-color:white">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            @if (session('failed'))
            <div class="alert alert-danger  " role="alert" style="height: 34px; padding-top: 9px;">
                {{ session('failed') }}
            </div>
            @endif
            <div class="row">
                <!-- create a new account -->
                <div class="col-md-12 col-sm-12 col-lg-12 create-new-account" >
                    <h4 class="checkout-subtitle">Create a new account</h4>
                    <form action="{{ route('reg') }}" method="POST" class="register-form outer-top-xs">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label class="info-title" for=""> First Name <span>*</span></label>
                                    <input type="text" value="{{ old('first_name') }}" name="first_name"
                                        class="form-control unicase-form-control text-input" id="">
                                    @if ($errors->has('first_name'))
                                    <div class="invalid-feedback">{{ $errors->first('first_name') }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label class="info-title" for=""> Last Name <span>*</span></label>
                                    <input type="text" name="last_name"
                                        class="form-control unicase-form-control text-input" value="{{ old('last_name') }}" id="">
                                    @if ($errors->has('last_name'))
                                    <div class="invalid-feedback">{{ $errors->first('last_name') }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail2">Email Address
                                        <span>*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control unicase-form-control text-input" id="">
                                    @if ($errors->has('email'))
                                    <div class="invalid-feedback">{{ $errors->first('email') }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail2">Mobile
                                        <span>*</span></label>
                                    <input type="text" name="mobile" value="{{ old('mobile') }}"
                                        class="form-control unicase-form-control text-input" id="">
                                    @if ($errors->has('mobile'))
                                    <div class="invalid-feedback">{{ $errors->first('mobile') }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label class="info-title" for="">Password <span>*</span></label>
                                    <input type="Password" name="password" {{ old('password') }}
                                        class="form-control unicase-form-control text-input" id="">
                                    @if ($errors->has('password'))
                                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label class="info-title" for="">Conform Password <span>*</span></label>
                                    <input type="Password" name="confirm_password" value="{{ old('confirm_password') }}"
                                        class="form-control unicase-form-control text-input" id="">
                                    @if ($errors->has('confirm_password'))
                                    <div class="invalid-feedback">{{ $errors->first('confirm_password') }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="col-md-12 col-sm-12 col-lg-12 btn-upper btn btn-primary checkout-page-button">Sign
                            Up</button>
                            <div class="text-left" style="margin-top: 45px">
                                <span href="#" class="forgot-password" style="color: unset">Already have an account?</span><a href="{{ route('login.index') }}"> Sign in Now</a>
                                <br>
                                <span href="#" class="forgot-password"style="color: unset">Forgot Password?</span><a href="{{ route('register') }}"> Reset Now</a>
                            </div>
                    </form>

                </div>
                <!-- create a new account -->
            </div><!-- /.row -->
        </div><!-- /.sigin-in-->
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
    </div><!-- /.container -->
</div><!-- /.body-content -->
@endsection