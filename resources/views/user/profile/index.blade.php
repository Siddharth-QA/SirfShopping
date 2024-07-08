@extends('layouts.app')

@section('content')
<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="{{ route('index') }}">Home</a></li>
                <li class='active'>Profile</li>
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

                    <form method="post" id="email-form" action="{{ route('profile.update') }}" autocomplete="off">
                        @csrf
                        <div class="row">
                            <!-- /.col-md-6 -->
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail2">First Name<span>*</span></label>
                                    <input type="text" name="first_name" value="@if(old('first_name')){{ old('first_name') }}@elseif($user){{ $user->first_name }}@endif" class="form-control unicase-form-control text-input" id="first_name" readonly>
                                    @if ($errors->has('first_name'))
                                    <div class="invalid-feedback">{{ $errors->first('first_name') }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail2">Last Name<span>*</span></label>
                                    <input type="text" name="last_name" value="@if(old('last_name')){{ old('last_name') }}@elseif($user){{ $user->last_name }}@endif" class="form-control unicase-form-control text-input" id="last_name" readonly>
                                    @if ($errors->has('last_name'))
                                    <div class="invalid-feedback">{{ $errors->first('last_name') }}</div>
                                    @enderror
                                </div>
                            </div>
                    
                        </div>
                    
                        <div class="row">
                            <!-- /.col-md-6 -->
                            
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail2">Email<span>*</span></label>
                                    <input type="text" name="email" value="@if(old('email')){{ old('email') }}@elseif($user){{ $user->email }}@endif" class="form-control unicase-form-control text-input" id="email" readonly>
                                    @if ($errors->has('email'))
                                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
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