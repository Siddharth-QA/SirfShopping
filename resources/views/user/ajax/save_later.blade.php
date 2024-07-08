@if (count($items['save_later']) != 0)
<div class="shopping-cart">              
    <div class="shopping-cart-table ">
        <h5 style="font-weight: bold">Saved for Later ({{ count($items['save_later'])}})</h5 class="bold">
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
                <tbody class="save_later-tr">
                    @foreach ($items['save_later'] as $cart)
                    <tr>
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
                                <a  onclick="removeCart({{ $cart->id }})" style="color: #e31212;"
                                    title="cancel" class="icon"><i class="fa fa-trash-o"></i>
                                </a>
                                <a class="save_later" onclick="save_later({{ $cart->id }})" style="color: #fdd922"
                                    title="Add To Cart" class="icon"><i class="fa fa-shopping-cart fas-icon"></i>
                                </a>
                            </div>

                        </td>
                    </tr>
                    @endforeach
                </tbody><!-- /tbody -->
            </table><!-- /table -->
        </div>
    </div>
</div>
@endif