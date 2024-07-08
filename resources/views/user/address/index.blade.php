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
            <div class="col-xs-12 col-sm-12 col-lg-9 pt-3 pt-lg-0 table-address">
                <div class="detail-block h-100">
                    <div class="add-address">
                        <a href="{{ route('address.create') }}" class="btn btn-upper outer-left-xs" title="Add New Address" id="plus-btn">
                            <en class="fa fa-plus pr-2"></en> Add New Address
                        </a>
                    </div>
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
                    @if (count($adds) == 0)
                    <div class="table-responsive border-0">
                        <table class="table table-striped " id="address-tbl">
                            <caption>No Address Found!</caption>
                        </table>
                    </div>
                    @else
                    <div class="table-responsive border-0">
                        <table class="table table-striped " id="address-tbl">
                            <caption>Address List</caption>
                            <thead>
                                <tr>
                                    <th class="address-list-one">Address</th>
                                    <th class="address-list">Label</th>
                                    <th class="address-list">Mobile</th>
                                    <th class="address-list">State</th>
                                    <th scope="col">City</th>
                                    <th class="address-list">Pin Code</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($adds as $add )
                                <tr id="add-tr-{{ $add->id }}">
                                    <td> {{ $add->address }}</td>
                                    <td> {{ $add->label }}</td>
                                    <td> {{ $add->mobile }}</td>
                                    <td> {{ $add->state }}</td>
                                    <td> {{ $add->city }} </td>
                                    <td> {{ $add->pin_code }}</td>
                                    <td align="center" class="d-flex">
                                        <div style="display:flex">
                                        <a href="{{route('address.edit',encodeRequestData($add->id)) }}" style=" padding-right:10px"><en class="fa fa-edit text-success"></en></a>
                                        <a data-add_id="{{ $add->id }}" class="add_remove"><en class="fa fa-trash text-danger"></en></a>
                                    </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
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