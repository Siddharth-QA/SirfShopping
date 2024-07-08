@extends('layouts.app')

@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li class='active'>Password Change</li>
                </ul>
            </div>
            <!-- /.breadcrumb-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.breadcrumb -->
    <div class="body-content outer-top-xs" id="top-banner-and-menu">
        <div class="container p-3 bg-white">
            <div class="row">
                @include('user.sidebar')

                <div class="col-xs-12 col-sm-12 col-lg-9">
                    <div class="detail-block p-3 border">

                        @if(session('success'))
                        <div class="alert alert-custom alert-success show" role="alert">
                            <div class="alert-icon">
                                <span class="flaticon2-check-mark"></span>
                            </div>
                            <div class="alert-text"> {{ session('success') }} </div>
                            <div class="alert-close"></div>
                        </div>
                        
                        @endif
                        @if(session('failed'))
                        <div class="alert alert-custom alert-danger show" role="alert">
                            <div class="alert-icon">
                                <en class="flaticon2-check-mark"></en>
                            </div>
                            <div class="alert-text"> {{ session('failed') }} </div>
                            <div class="alert-close"></div>
                        </div>
                        @endif

                        <form method="post" id="email-form" action="{{ route('rest.pass') }}" autocomplete="off">
                            @csrf
                            <div class="row">
                                <!-- /.col-md-6 -->
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="info-title" for="exampleInputEmail2">Current Password<span>*</span></label>
                                        <input type="password" name="current_password" value="@if(old('current_password')){{ old('current_password') }}@endif" class="form-control unicase-form-control text-input" id="current_password" readonly>
                                        @if ($errors->has('current_password'))
                                        <div class="invalid-feedback">{{ $errors->first('current_password') }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="info-title" for="exampleInputEmail2">Password<span>*</span></label>
                                        <input type="password" name="password" value="@if(old('password')){{ old('password') }}@endif" class="form-control unicase-form-control text-input" id="password" readonly>
                                        @if ($errors->has('password'))
                                        <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                        @enderror
                                    </div>
                                </div>
                        
                            </div>
                        
                            <div class="row">
                                <!-- /.col-md-6 -->
                                
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="info-title" for="exampleInputEmail2">Confirm Password<span>*</span></label>
                                        <input type="password" name="con_password" value="@if(old('con_password')){{ old('con_password') }}@endif" class="form-control unicase-form-control text-input" id="con_password" readonly>
                                        @if ($errors->has('con_password'))
                                        <div class="invalid-feedback">{{ $errors->first('con_password') }}</div>
                                        @enderror
                                    </div>
                                </div>
                        
                            </div>
                        
                            <div class="d-flex justify-content-end">
                                <div class="d-flex">
                                    <button type="button" class="btn btn-primary outer-left-xs mr-2" onclick="toggleEdit()">Edit</button>
                                    <button type="submit" class="btn btn-primary outer-left-xs mr-2" style="display: none;">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="brands-carousel" class="logo-slider wow fadeInUp">
            <div class="logo-slider-inner">
                <div id="brand-slider" class="owl-carousel brand-slider custom-carousel owl-theme">
                    <div class="item m-t-15">

                    </div>
                    <!--/.item-->
                </div>
                <!-- /.owl-carousel #logo-slider -->
            </div>
            <!-- /.logo-slider-inner -->
        </div>
    </div>
@endsection
