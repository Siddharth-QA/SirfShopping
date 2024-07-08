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
                                <p>Place order to it now.</p><a class="btn btn-upper btn-primary outer-left-xs"
                                    href="/">Shop Now</a>
                            </div>
                        @else
                            <div class="table-responsive h-100">
                                @foreach ($orders as $order)
                                    <table class="table table-striped border bg-white w-100 order-table-section">
                                        <tbody>
                                            <tr>
                                                <td colspan="2" class="text-left">
                                                    <strong>Order Id:</strong>  {{ $order->id }}
                                                    <a href="{{ route('orderDetails',encodeRequestData($order->id))  }}" class=" btn-primary text-white ml-5">View
                                                        Details</a>
                                                </td>
                                                <td colspan="" class="m-0">
                                                    <strong>Order Value:</strong> {{ $order->total }}
                                                </td>
                                                <td colspan="3">
                                                    <strong>Order Date:</strong> {{ $order->order_date }}
                                                </td>
                                            </tr>
                                            @foreach($order->orderDetails as $detail)
                                            <tr>
                                                <td>
                                                    @if (!empty($detail->ProductInventory->Product_image))
                                                    <img src="{{ img_url($detail->ProductInventory->Product_image->image) }}"width="40" alt="image" class="img-fluid">
                                                    @endif
                                                </td>
                                                <td>
                                                  {{ $detail->product_name }} @if($detail->batch)
                                                        <br>
                                                        <strong>Batch</strong> : {{ $detail->batch_val }} @endif @if($detail->expiry)
                                                        <br>
                                                        <strong>Expiry</strong> : {{ \Carbon\Carbon::parse($detail->expiry_date)->format('d M Y') }} @endif
                                                </td>
                                                <td> ₹{{ $detail->total }}</td>
                                                <td>{{$detail->sts}}</td>
                                                @if ($detail->sts != 'Delivered')
                                                <td>{{ $detail->reason }}</td>
                                                @else
                                                <td></td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                @endforeach
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
