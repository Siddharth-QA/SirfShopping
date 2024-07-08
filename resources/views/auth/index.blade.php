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
        <div class="container" style="display: flex; justify-content: center; align-items: center;">
   
            <div class="sign-in-page-login col-md-5 col-sm-5 mx-auto" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,.08);padding: 20px;overflow: hidden;background-color:white">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('failed'))
                <div class="alert alert-danger" role="alert" style="height: 34px; padding-top: 9px;">
                    {{ session('failed') }}
                </div>
            @endif <!-- Center the form -->
                <div class="row">
                    <!-- Sign-in -->
                    <div class="col-md-12 col-sm-12 sign-in">
                        <h4 class="">Sign in</h4>
                        <p class="">Hello, Welcome to your account.</p>
                        <form class="register-form outer-top-xs" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="info-title" for="exampleInputEmail1">Email Address <span>*</span></label>
                                <input type="email" name="log_email" class="form-control unicase-form-control text-input" id="">
                                @if ($errors->has('log_email'))
                                    <div class="invalid-feedback">{{ $errors->first('log_email') }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="exampleInputPassword1">Password <span>*</span></label>
                                <input type="password" name="log_password" class="form-control unicase-form-control text-input" id="">
                                @if ($errors->has('log_password'))
                                    <div class="invalid-feedback">{{ $errors->first('log_password') }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn-upper btn btn-primary checkout-page-button col-md-12 col-sm-12">Login</button>
                            <div class="text-left" style="margin-top: 70px">
                                <span href="#" class="forgot-password"style="color: unset">Forgot Password?</span><a href="{{ route('register') }}"> Reset Now</a>
                                <br>
                                <span href="#" class="forgot-password" style="color: unset">Don't have an account?</span><a href="{{ route('register') }}"> Register Now</a>
                                <br>
                            </div>
                        </form>
                    </div>
                    <!-- Sign-in -->
                </div><!-- /.row -->
            </div><!-- /.sign-in-page -->
        </div><!-- /.container -->
        
    </div><!-- /.sigin-in-->
    <!-- ============================================== BRANDS CAROUSEL ============================================== -->
    <div id="brands-carousel" class="logo-slider wow fadeInUp">

        <div class="logo-slider-inner">
            <div id="brand-slider" class="owl-carousel brand-slider custom-carousel owl-theme">
                <div class="item m-t-15">
                    <a href="#" class="image">
                        <img data-echo="assets/images/brands/brand1.png" src="assets/images/blank.gif"
                            alt="">
                    </a>
                </div><!--/.item-->

                <div class="item m-t-10">
                    <a href="#" class="image">
                        <img data-echo="assets/images/brands/brand2.png" src="assets/images/blank.gif"
                            alt="">
                    </a>
                </div><!--/.item-->

                <div class="item">
                    <a href="#" class="image">
                        <img data-echo="assets/images/brands/brand3.png" src="assets/images/blank.gif"
                            alt="">
                    </a>
                </div><!--/.item-->

                <div class="item">
                    <a href="#" class="image">
                        <img data-echo="assets/images/brands/brand4.png" src="assets/images/blank.gif"
                            alt="">
                    </a>
                </div><!--/.item-->

                <div class="item">
                    <a href="#" class="image">
                        <img data-echo="assets/images/brands/brand5.png" src="assets/images/blank.gif"
                            alt="">
                    </a>
                </div><!--/.item-->

                <div class="item">
                    <a href="#" class="image">
                        <img data-echo="assets/images/brands/brand6.png" src="assets/images/blank.gif"
                            alt="">
                    </a>
                </div><!--/.item-->

                <div class="item">
                    <a href="#" class="image">
                        <img data-echo="assets/images/brands/brand2.png" src="assets/images/blank.gif"
                            alt="">
                    </a>
                </div><!--/.item-->

                <div class="item">
                    <a href="#" class="image">
                        <img data-echo="assets/images/brands/brand4.png" src="assets/images/blank.gif"
                            alt="">
                    </a>
                </div><!--/.item-->

                <div class="item">
                    <a href="#" class="image">
                        <img data-echo="assets/images/brands/brand1.png" src="assets/images/blank.gif"
                            alt="">
                    </a>
                </div><!--/.item-->

                <div class="item">
                    <a href="#" class="image">
                        <img data-echo="assets/images/brands/brand5.png" src="assets/images/blank.gif"
                            alt="">
                    </a>
                </div><!--/.item-->
            </div><!-- /.owl-carousel #logo-slider -->
        </div><!-- /.logo-slider-inner -->

    </div><!-- /.logo-slider -->
    <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->
</div><!-- /.container -->
</div><!-- /.body-content -->
@endsection
