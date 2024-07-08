@extends('layouts.app')

@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li class='active'>Orders</li>
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
                    <div class="detail-block p-3 border">
                        @if (count($orders) == 0)
                        <div class="empty-cart " id="empCart">
                            <img width="100" src="{{ asset('/assets/images/cart-empty.png') }}">
                            <h3 class="class-text-center">No Order Found!</h3>
                            <p>Place order to it now.</p><a class="btn btn-upper btn-primary outer-left-xs" href="/">Shop Now</a>
                        </div>
                        @else
                        <div class="table-responsive h-100">
                            <table class="table table-striped" id="address-tbl">
                                <caption>Order List</caption>
                                <thead>
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Order No.</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr id="add-tr-{{ $order->id }}">
                                            <td class="text-nowrap">{{ $order->order_date }}</td>
                                            <td><a href="{{ route('orderDetails',encodeRequestData($order->id))  }}"> {{ $order->id }} </a></td>
                                            <td>{{ $order->total }}</td>
                                            <td
                                                class="font-weight-bold {{ $order->ord_sts == 'Delivered' ? 'text-success' : ($order->ord_sts == 'Partially Cancelled' ? 'text-danger' : 'text-warning') }}">
                                                {{ $order->ord_sts }}
                                            </td>
                                            <td><a class="pl-2" href="{{ route('orderDetails',encodeRequestData($order->id))  }}"><i class="fa fa-eye text-warning"
                                                        title="view" aria-hidden="true"></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-between">
                            @if ($orders->onFirstPage())
                                <span class="btn btn-primary mr-2 disabled">Previous</span>
                            @else
                                <a href="{{ $orders->previousPageUrl() }}" class="btn btn-primary mr-2">Previous</a>
                            @endif

                            @if ($orders->hasMorePages())
                                <a href="{{ $orders->nextPageUrl() }}" class="btn btn-primary">Next</a>
                            @else
                                <span class="btn btn-primary disabled">Next</span>
                            @endif
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
