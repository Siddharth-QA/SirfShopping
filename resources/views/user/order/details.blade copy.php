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
                    <div class="col-lg-12 bill-manage">
                        <div class="border overflow-hidden">
                            <div class="row">
                                @if($orders->invoice_no)
                                <div class="col-12 text-right">
                                    <a class="btn btn-warning" href="">Download Invoice</a>
                                    {{-- {{ route('order.download-pdf', ['order' => $orders->id]) }} --}}
                                </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-sm-7 py-2">
                                    <p class="mb-0 px-2">
                                        <strong>Order Date</strong>: {{ $orders->order_date }}
                                    </p>
                                    <p class="mb-0 px-2">
                                        <strong>@if($orders->inv_prefix) Invoice No. @else Status @endif</strong>: @if($orders->inv_prefix) {{ $orders->inv_prefix }} @else <span class="font-weight-bold @if($orders->ord_sts == 'Delivered') text-success @elseif($orders->ord_sts == 'Partially Cancelled') text-danger @endif text-warning">{{ $orders->ord_sts }}</span> @endif
                                    </p>
                                </div>
                                <div class="col-sm-5 py-2 d-flex justify-content-end">
                                    <div>
                                        <p class="mb-0 px-2">
                                            <strong>Invoice Date</strong>: {{ $orders->order_date }}
                                        </p>
                                        <p class="mb-0 px-2">
                                            <strong>@if($orders->inv_prefix) Invoice No. @else Status @endif</strong>: @if($orders->inv_prefix) {{ $orders->inv_prefix }} @else <span class="font-weight-bold @if($orders->ord_sts == 'Delivered') text-success @elseif($orders->ord_sts == 'Partially Cancelled') text-danger @endif text-warning">{{ $orders->ord_sts }}</span> @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7 order-bill-sec">
                                    <div class="order-bill pr-md-0">
                                        <strong>Billed To :</strong> @if($orders->customer_company == 'NA') {{ $orders->customer_name }} @else {{ $orders->customer_company }} @endif
                                        <br>
                                        <strong>Address :</strong>
                                        <span>
                                            {{ $orders->customer_address }}
                                    </div>
                                </div>
                                <div class="col-md-5 order-bill-sec">
                                    <div class="order-bill px-md-0">
                                        <strong>Shipped To:</strong>
                                        @if($orders->customer_company == 'NA') {{ $orders->customer_name }} @else {{ $orders->customer_company }} @endif
                                        <br>
                                        <strong>Address :</strong>
                                        @if($orders->same_shipped)
                                        <span>{{ $orders->customer_address }}</span>
                                        <!-- Same -->
                                        @else
                                        <!-- Def -->
                                        <span>{{ $orders->shipped_address->address }} {{ $orders->shipped_address->city }} {{ $orders->shipped_address->pincode }}
                                            {{ $orders->shipped_address->country }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive border-0">
                                <table class="table-striped table" style="margin-bottom: 0px; font-size: 12px;">
                                    <caption style="display: none;">Item Description</caption>
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0 product-name" colspan="2">Product Name</th>
                                            <th class="border-bottom-0">Rate</th>
                                            <th class="border-bottom-0">QTY</th>
                                            <th class="border-bottom-0">Discount</th>
                                            <th class="border-bottom-0">Taxable Value</th>
                                            <th class="border-bottom-0">CGST</th>
                                            <th class="border-bottom-0">SGST</th>
                                            <th class="border-bottom-0">IGST</th>
                                            <th class="border-bottom-0">Status</th>
                                            <th class="border-bottom-0">Total Amount</th>
                                            <th class="border-bottom-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders->orderDetails as $detail)
                                        <tr>
                                            <td>
                                                @if (!empty($detail->ProductInventory->Product_image))
                                                <img src="{{ img_url($detail->ProductInventory->Product_image->image) }}" width="40" alt="Product six">
                                                @endif
                                            </td>
                                            <td>
                                                {{ $detail->product_name }} @if($detail->batch)
                                                <br>
                                                <strong>Batch</strong> : {{ $detail->batch_val }} @endif @if($detail->expiry)
                                                <br>
                                                <strong>Expiry</strong> : {{ \Carbon\Carbon::parse($detail->expiry_date)->format('d M Y') }} @endif
                                            </td>
                                            <td>{{ $detail->price }}</td>
                                            <td align="center">{{ $detail->qty }}</td>
                                            <td>₹{{ $detail->discount_value }}</td>
                                            <td>₹{{ $detail->taxable_val }}</td>
                                            <td>₹{{ ($orders->cgst)?$orders->cgst:0.00 }}</td>
                                            <td>₹{{ ($orders->sgst)?$orders->sgst:0.00 }}</td>
                                            <td>₹{{ ($orders->igst)?$orders->igst:0.00 }}</td>
                                            <td>{{$detail->sts}}</td>
                                            <td>₹{{ $detail->total }}</td>
                                            <td align="center">
                                                @if($detail->sts == 'Placed')
                                                <!-- Placed -->
                                                <button class="bg-transparent btn-danger text-white order-cancel border-0" title="Cancle" id="cancelBtn{{ $detail->id }}" onclick="funCancel('{{ $detail->id }}', 'Cancelled');">Cancle</i></button>
                                                <!-- Delivered -->
                                                @elseif($detail->sts == 'Delivered')
                                                <button class="btn-warning text-white" id="cancelBtn{{ $detail->id }}" onclick="funCancel('{{ $detail->id }}', 'Return Requested');">Return</button>
                                                <!-- Other -->
                                                @else {{ $detail->sts }} @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="9" class="text-right">Sub Total</td>
                                            <td colspan="4" class="text-right">₹{{ $orders->sub_total }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="9" class="text-right">Discount</td>
                                            <td colspan="4" class="text-right">₹@if($orders->discount_value){{ $orders->discount_value }}@else 0.00 @endif</td>
                                        </tr>
                                        <tr>
                                            <td colspan="9" class="text-right">Taxable Value</td>
                                            <td colspan="4" class="text-right">₹{{ $orders->taxable_val }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="9" class="text-right">CGST</td>
                                            <td colspan="4" class="text-right">₹{{ $orders->cgst }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="9" class="text-right">SGST/UGST</td>
                                            <td colspan="4" class="text-right">₹{{ $orders->sgst }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="9" class="text-right">IGST</td>
                                            <td colspan="4" class="text-right">₹{{ $orders->igst }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="9" class="text-right">
                                                <strong>Grand Total</strong>
                                            </td>
                                            <td colspan="4" class="text-right">₹{{ $orders->total }}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
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