<div class="shopping-cart">
    @if (count($items['carts']) == 0)
    <div class="empty-cart " id="empCart">
        <img width="200" src="{{ asset('/assets/images/cart-empty.png')}}">
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
                </thead><!-- /thead -->
                <tbody class="cart-tr">
                    @foreach ($items['carts'] as $cart)
                    <tr >
                        <td class="cart-image">
                            <a class="entry-thumbnail"
                                href="{{ route('detail', encodeRequestData($cart->pdt->id)) }}">
                                @if (!empty($cart->pdt->pdt_img))
                                <img src="{{ img_url($cart->pdt->pdt_img->image) }}" alt="">
                                @endif
                            </a>
                        </td>
                        <td class="cart-product-name-info">
                            <h4 class='cart-product-description'><a
                                    href="{{ route('detail', encodeRequestData($cart->pdt->id)) }}">{{
                                    $cart->pdt->title }}</a>
                            </h4>
                        </td>
                        <td class="cart-quantity">
                            <div class="quant-input">
                                <div class="arrows">
                                    <div class="arrow plus gradient" onclick="changeQuantity(this, 'plus')">
                                        <span class="ir"><i class="icon fa fa-sort-asc"></i></span>
                                    </div>
                                    <div class="arrow minus gradient" onclick="changeQuantity(this, 'minus')">
                                        <span class="ir"><i class="icon fa fa-sort-desc"></i></span>
                                    </div>
                                </div>
                                <input type="text" class="qty-input" value="{{ $cart->qty }}">
                                <input type="hidden" class="id-input" value="{{ $cart->id }}">
                            </div>
                        </td>
                        <td class="cart-product-sub-total"><span class="cart-sub-total-price">₹{{
                                $cart->price }}</span>
                        </td>
                        <td class="cart-product-grand-total"><span class="cart-grand-total-price">₹{{
                                $cart->total }}</span>
                        </td>
                        <td class="romove-item">
                            <div>
                                <a data-pdtid="" onclick="removeCart({{ $cart->id }})" style="color: #e31212;"
                                    title="cancel" class="icon"><i class="fa fa-trash-o"></i>
                                </a>
                                <a class="save_later" onclick="save_later({{ $cart->id }})" style="color: #fdd922"
                                    title="save Later" class="icon"><i class="fa fas fa-save fas-icon"></i>
                                </a>
                            </div>

                        </td>
                    </tr>
                    @endforeach
                </tbody><!-- /tbody -->
            </table><!-- /table -->
            <hr>
            <tfoot>
                <tr>
                    <td colspan="">
                        <div class="shopping-cart-btn">
                            <span class="">
                                <a href="{{ route('index') }}"
                                    class="btn btn-upper btn-primary outer-left-xs">Continue
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
    </div>
    @endif
</div>