@if (count($items['carts']) == 0)
<div class="empty-cart" id="empCart">
    <img width="100" src="{{ asset('/assets/images/cart-empty.png')}}">
    <h3 class="class-text-center">Your cart is empty!</h3>
    <p>Add items to it now.</p><a class="btn btn-upper btn-primary outer-left-xs" href="/">Shop Now</a>
</div>
@else
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th class="cart-description item">Image</th>
                <th class="cart-product-name item">Product Name</th>
                <th class="cart-qty item">Quantity</th>
                <th class="cart-total item">Total</th>
                <th class="cart-remove item">Remove</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items['carts'] as $cart)
            <tr>
                <td class="cart-image">
                    <a class="entry-thumbnail"
                        href="{{ route('detail', encodeRequestData($cart->pdt->id)) }}">
                        @if (!empty($cart->pdt->pdt_img))
                        <img style="width: 50px"
                            src="{{ img_url($cart->pdt->pdt_img->image) }}" alt="">
                        @endif
                    </a>
                </td>
                <td class="cart-product-name-info">
                    <h4 class='cart-product-description' style="font-size:13px"><a
                            href="{{ route('detail', encodeRequestData($cart->pdt->id)) }}">{{
                            $cart->pdt->title }}</a>
                    </h4>
                </td>
                <td class="cart-quantity">
                    <div class="quant-input">
                        <div class="arrows checkout-arrows">
                            <div class="arrow plus gradient check_out" onclick="updateCart({{ $cart->id }}, {{ $cart->qty }} + 1)">
                                <span class="ir"><i class="icon fa fa-sort-asc"></i></span>
                            </div>
                            <input type="text" class="text-center" style="width: 40px" id="qty-{{ $cart->id }}" value="{{ $cart->qty }}" onchange="updateCart({{ $cart->id }}, this.value)">
                            <input type="hidden" id="id-{{ $cart->id }}" value="{{ $cart->pdt->id }}">
                            <div class="arrow minus gradient" onclick="updateCart({{ $cart->id }}, {{ $cart->qty }} - 1)">
                                <span class="ir"><i class="icon fa fa-sort-desc"></i></span>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="cart-total"><span class="cart-grand-total-price">₹{{
                        $cart->total }}</span>
                </td>
                <td class="cart-remove">
                    <a onclick="removeCart({{ $cart->id }})" title="cancel"><i
                            class="fa fa-trash-o"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<hr class="hr">
<button type="button" data-toggle="collapse"
    class="collapsed btn-upper btn btn-primary checkout-page-button checkout-continue"
    data-parent="#accordion" href="#collapseFour">Continue</button>
@endif