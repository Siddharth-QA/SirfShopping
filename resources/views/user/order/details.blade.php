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
                        @if($orders->invoice_no)
                        <div class="row">
                            <div class="col-12 text-right">
                                <a class="btn btn-warning" href="">Download Invoice</a>
                            </div>
                        </div>
                        @endif
                        <div class="row mt-3">
                            <div class="col-sm-4">
                                <p><strong>Order Id:</strong> {{ $orders->id }}</p>
                                <p><strong>Order Date:</strong> {{ $orders->order_date }}</p>
                                <p><strong>Order Value:</strong> ₹ {{ $orders->total }}</p>
                                <p><strong>Order Type:</strong> {{ $orders->order_type }}</p>
                                {{-- <p><strong>TXN ID:</strong> {{ $orders->order_type }}</p> --}}
                                <p><strong>Invoice Id:</strong> {{ ($orders->invoice_no)?$orders->invoice_no :"NA"  }}</p>
                            </div>
                            <div class="col-sm-4">
                                @if($orders->customer_company == 'NA') {{ $orders->customer_name }} @else {{ $orders->customer_company }} @endif
                                <p><strong>Billing Address:</strong></p>
                                <p><i class="fa fa-user"></i> {{ $orders->customer_name }}</p>
                                <p><i class="fa fa-phone"></i> {{ $orders->customer_phone }}</p>
                                <p><i class="fa fa-address-card-o"></i> {{ $orders->customer_address }} - {{ $orders->country }}</p>
                            </div>
                            <div class="col-sm-4">
                                @if($orders->customer_company == 'NA') {{ $orders->customer_name }} @else {{ $orders->customer_company }} @endif
                                <p><strong>Shipping Address:</strong></p>
                                @if($orders->same_shipped)
                                <p><i class="fa fa-user"></i> {{ $orders->customer_name }}</p>
                                <p><i class="fa fa-phone"></i> {{ $orders->customer_phone }}</p>
                                <p><i class="fa fa-address-card"></i> {{ $orders->customer_address }} - {{ $orders->country }}</p>
                                @else
                                <p><i class="fa fa-user"></i> {{ $orders->customer_name }}</p>
                                <p><i class="fa fa-phone"></i> {{ $orders->customer_phone }}</p>
                                <p><i class="fa fa-address-card"></i> {{ $orders->shipped_address->address }} - {{ $orders->shipped_address->country }}</p>
                                @endif
                            </div>
                        </div>    
                        <div class="row mt-3">
                            <div class="col-12">
                                <table class="table table-striped w-100">
                                    <tbody>
                                        @foreach($orders->orderDetails as $detail)
                                        <tr>
                                            <td colspan="4">
                                                @if (!empty($detail->ProductInventory->Product_image))
                                                <img  width="60" src="{{ img_url($detail->ProductInventory->Product_image->image) }}" alt="Product Image">
                                                @endif
                                            </td>
                                            <td class="text-left">
                                                   <p>{{ $detail->product_name }}   @if($detail->batch)(<strong>Batch</strong> : {{ $detail->batch_val }})@endif  @if($detail->expiry) <strong>Expiry</strong> : {{ \Carbon\Carbon::parse($detail->expiry_date)->format('d M Y') }}  @endif</p>
                                                <p><strong>Amount : </strong>₹{{ $detail->total }}</p>
                                                <p><strong>Quantity  : </strong>{{ $detail->qty }}</p>
                                                <p><strong>Order Status : </strong><span class="text-success">{{$detail->sts}}</span></p>
                                                {{-- <p><strong>Material No.</strong>456789876556</p> --}}
                                            </td>
                                            <td>
                                                @if($detail->sts == 'Placed')
                                                    <button class="bg-transparent btn-danger text-white order-action border-0" title="Cancel" 
                                                            data-toggle="modal" data-target="#actionModal" 
                                                            data-id="{{ $detail->id }}" data-invId="{{ $detail->ProductInventory->id }}" data-qty="{{ $detail->qty }}" data-action="Cancelled">Cancel</button>
                                                @elseif($detail->sts == 'Delivered')
                                                    <button class="btn-warning text-white order-action" title="Return"
                                                            data-toggle="modal" data-target="#actionModal" 
                                                            data-id="{{ $detail->id }}" data-invId="{{ $detail->ProductInventory->id }}" data-qty="{{ $detail->qty }}"  data-action="Return Requested">Return</button>
                                                @else 
                                                    {{ $detail->sts }} 
                                                @endif
                                            </td>
                                            
                                            
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
