@if (!empty($sessionItems['cartItems']))
<div class="shopping-cart">
    @if ($sessionItems['qty'] == 0)
    <div class="empty-cart " id="empCart">
        <img src="{{ asset('/assets/images/cart-empty.png') }}">
        <h3 class="class-text-center">Your cart is empty!</h3>
        <p>Add items to it now.</p><a class="btn btn-upper btn-primary outer-left-xs" href="/">Shop Now</a>
    </div>
    @else
    <div class="shopping-cart-table ">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th class="cart-description item">Image</th>
                        <th class="cart-product-name item">Product Name</th>
                        <th class="cart-qty item">Quantity</th>
                        <th class="cart-sub-total item">Price</th>
                        <th class="cart-total last-item">Total</th>
                        <th class="cart-romove item">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sessionItems['cartItems'] as $cart)
                    <tr>
                        <td class="cart-image">
                            <a class="entry-thumbnail"
                                href="{{ route('detail', encodeRequestData($cart->attributes->product)) }}">
                                <img src="{{ img_url($cart->attributes->image) }}" alt="">
                            </a>
                        </td>
                        <td class="cart-product-name-info">
                            <h4 class='cart-product-description'>
                                <a href="{{ route('detail', encodeRequestData($cart->attributes->product)) }}">{{
                                    $cart->name }}</a>
                            </h4>
                        </td>
                        <td class="cart-quantity">
                            <div class="quant-input">
                                <div class="arrows">
                                    <div class="arrow plus gradient" onclick="changeQuantity(this, 'plus')">
                                        <span class="ir"><i class="icon fa fa-sort-asc"></i></span>
                                    </div>
                                    <div class="arrow minus gradient"
                                        onclick="changeQuantity(this, 'minus')">
                                        <span class="ir"><i class="icon fa fa-sort-desc"></i></span>
                                    </div>
                                </div>
                                <input type="text" class="qty-input" value="{{ $cart->quantity }}">
                                <input type="hidden" class="id-input" value="{{ $cart->attributes->product }}">
                            </div>
                        </td>
                        <td class="cart-product-sub-total">
                            <span class="cart-sub-total-price">₹{{ number_format($cart->price, 2) }}</span>
                        </td>
                        <td class="cart-product-grand-total">
                            <span class="cart-grand-total-price">₹{{ number_format($cart->quantity * $cart->price, 2)
                                }}</span>
                        </td>
                        <td class="romove-item">
                            <a onclick="removeCart({{ $cart->id }})" style="color: #e31212" title="cancel" class="icon">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
            <hr>
            <tfoot>
                <tr>
                    <td colspan="">
                        <div class="shopping-cart-btn">
                            <span class="">
                                <a href="{{ route('index') }}" class="btn btn-upper btn-primary outer-left-xs">Continue
                                    Shopping</a>
                                <a href="{{ Auth::user() ? route('check-out') : route('login.index') }}"
                                    class="btn  btn-upper btn-warning pull-right outer-right-xs">Proceed
                                    To Buy</a>
                            </span>
                        </div><!-- /.shopping-cart-btn -->
                    </td>
                </tr>
            </tfoot>
        </div>
    </div><!-- /.shopping-cart-table -->
    @endif
    <!-- /.cart-shopping-total -->
</div>
@endif