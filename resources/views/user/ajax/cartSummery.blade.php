<div class="panel panel-default">
    @if ($items['qty'] == 0)
    <div class="empty-cart " id="empCart">
        <img width="100" src="{{ asset('/assets/images/cart-empty.png')}}">
        <h3 class="class-text-center">Your cart is empty!</h3>
        <p>Add items to it now.</p><a class="btn btn-upper btn-primary outer-left-xs" href="/">Shop Now</a>
    </div>
    @else
    <div class="panel-heading">
        <h4 class="unicase-checkout-title">Cart Summary ({{ $items['qty'] }})</h4>
    </div>
    <div class="panel-body">
        <ul class="nav nav-checkout-progress list-unstyled">
            <li>
                <span class="summary-key">Price:</span>
                <span class="summary-value" id="amount">{{ $items['taxable_val'] }}</span>
            </li>
            <hr>
            <li>
                <span class="summary-key">Discount:</span>
                <span class="summary-value" id="discount">{{ $items['discount'] }}</span>
            </li>
            <hr>
            <li>
                <span class="summary-key">GST:</span>
                <span class="summary-value" id="gst">{{ $items['gst'] }}</span>
            </li>
            <hr>
            <li>
                <span class="summary-key">Shipping Charge:</span>
                <span class="summary-value" id="shipping">FREE</span>
            </li>
            <hr>
            <li>
                <span class="summary-key total-amount-key">Pay Amount:</span>
                <span class="summary-value total-amount-value" id="total">{{ $items['total']
                    }}</span>
            </li>
        </ul>
    </div>
    @endif
</div>