@extends('layouts.app')

@section('content')
<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="{{ route('index') }}">Home</a></li>
                <li class='active'>Address</li>
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
            <div class="col-xs-12 col-sm-12 col-lg-9 pt-3 pt-lg-0">
                <div class="detail-block p-3">
                    <form method="post" id="address-form" action="@if($id){{route('address.update', $id)}}@else{{route('address.store')}}@endif" autocomplete="off">
                        @if($id) @method('PATCH') @endif
                        <input type="hidden" name="_token" id="csrf_token" value="{{ Session::token() }}" />
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail2">Address<span>*</span></label>
                                    <input type="text" name="address" value="@if(old('address')){{ old('address') }}@elseif($id){{ $data->address }}@endif" class="form-control unicase-form-control text-input" id="address">
                                    @if ($errors->has('address'))
                                    <div class="invalid-feedback">{{ $errors->first('address') }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.col-md-6 -->
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail2">Mobile<span>*</span></label>
                                    <input type="text" name="mobile" value="@if(old('mobile')){{ old('mobile') }}@elseif($id){{ $data->mobile }}@endif" class="form-control unicase-form-control text-input" id="">
                                    @if ($errors->has('mobile'))
                                    <div class="invalid-feedback">{{ $errors->first('mobile') }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail2">Label<span>*</span></label>
                                    <input type="text" name="label" value="@if(old('label')){{ old('label') }}@elseif($id){{ $data->label }}@endif" class="form-control unicase-form-control text-input" id="">
                                    @if ($errors->has('label'))
                                    <div class="invalid-feedback">{{ $errors->first('label') }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail2">Country<span>*</span></label>
                                <select name="country" class="form-control unicase-form-control text-input country" id="country" onchange="getstate()">
                                        @foreach ($adds as $add )
                                        <option value="{{ $add->id }}">{{ $add->title }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('country'))
                                    <div class="invalid-feedback">{{ $errors->first('country') }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail2">State<span>*</span></label>
                                    <select name="state" class="form-control unicase-form-control text-input state" id="state"></select>
                                    @if ($errors->has('state'))
                                    <div class="invalid-feedback">{{ $errors->first('state') }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail2">City<span>*</span></label>
                                    <input type="text" name="city" value="@if(old('city')){{ old('city') }}@elseif($id){{ $data->city }}@endif" class="form-control unicase-form-control text-input" id="city">
                                    @if ($errors->has('city'))
                                    <div class="invalid-feedback">{{ $errors->first('city') }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail2">Pin Code<span>*</span></label>
                                    <input type="text" name="pincode" value="@if(old('pincode')){{ old('pincode') }}@elseif($id){{ $data->pin_code }}@endif" class="form-control unicase-form-control text-input" id="">
                                    @if ($errors->has('pincode'))
                                    <div class="invalid-feedback">{{ $errors->first('pincode') }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Repeat the above form fields as needed -->
                        </div>
                        <!-- /.row -->

                        <div class="d-flex justify-content-end">
                            <div class="d-flex">
                                <button type="submit" class="btn btn-primary outer-left-xs mr-2">Submit</button>
                                <a href="{{ route('address') }}" class="btn btn-danger" href="">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.detail-block -->
            </div>
            <!-- /.col-xs-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</div>
<!-- /.body-content -->

<div id="brands-carousel" class="logo-slider wow fadeInUp">
    <div class="logo-slider-inner">
        <div id="brand-slider" class="owl-carousel brand-slider custom-carousel owl-theme">
            <div class="item m-t-15">
                <!-- Placeholder for logo slider item -->
            </div>
            <!--/.item-->
        </div>
        <!-- /.owl-carousel #logo-slider -->
    </div>
    <!-- /.logo-slider-inner -->
</div>
<!-- /#brands-carousel -->
@endsection
