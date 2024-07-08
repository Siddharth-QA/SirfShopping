<?php

namespace App\Http\Controllers;

use App\Models\AuthCarts;
use App\Models\AuthUser;
use App\Models\ProductInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\CommonMark\Extension\CommonMark\Node\Block\ListData;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $auth = auth()->user();
        if (!$auth) :
            $product = ProductInventory::with('Product', 'Product_image')->where('id', $request->pdtId)->first();
            if ($request->qty > $product->inv_qty) :
                return response()->json([
                    'sts' => false,
                    'msg' => "The requested quantity (" . $request->qty . ") exceeds the available stock (" . $product->inv_qty . ")."
                ]);
            endif;

            $cartItems = \Cart::get($product->id);
            if ($cartItems) :
                $request['qty'] = $cartItems->quantity + 1;
            endif;
            $orderValue = $this->orderCalculation((!empty($request->coupon)) ? $request->coupon : "", $request, $product);
            $cartItem = $this->sessionaddToCart($request, $product, $orderValue);
            $items = sessionItems();
            if ($cartItem) :
                return response()->json([
                    'sts' => 'session',
                    'msg' => "Product added successfully",
                    'items' => $items
                ]);
            else :
                return response()->json([
                    'sts' => false,
                    'msg' => "Failed to add product to cart"
                ]);
            endif;
        endif;
        $authEmail = $auth->email;
        $authUser = AuthUser::where('email', $authEmail)->first();

        if (AuthCarts::where('user_id', $authUser->id)->where('inventory_id', $request->pdtId)->where('save_later', 0)->where('cart_type', url('/'))->exists()) :
            return response()->json([
                'sts' => false,
                'msg' => "This product is already added to the cart"
            ]);
        endif;
        $inventory = ProductInventory::find($request->pdtId);
        if ($request->qty > $inventory->inv_qty) :
            return response()->json([
                'sts' => false,
                'msg' => "The requested quantity (" . $request->qty . ") exceeds the available stock (" . $inventory->inv_qty . ")."
            ]);
        endif;
        $cartItem = insert_To_db($request);
        $items = items();

        if ($cartItem) {
            return response()->json([
                'sts' => true,
                'msg' => "Product added successfully",
                'items' => $items
            ]);
        } else {
            return response()->json([
                'sts' => false,
                'msg' => "Failed to add product to cart"
            ]);
        }
    }

    public function save_later(Request $request)
    {
        $id = $request->cartId;
        $authUser = AuthUser::where('email', Auth::user()->email)->first();
        $query = AuthCarts::with('pdt.pdt_img')->where('cart_type', url('/'))->where('user_id', $authUser->id)->orderBy('id', 'desc');
        $items = items();

        $cart = AuthCarts::find($id);
        if ($cart->save_later == 0) :
            $cart->save_later = 1;
        else :
            $cart->save_later = 0;
        endif;
        $cart->save();

        if ($cart->save_later == 0) :
            $msg = "Product Added Cart Successfully";
        else :
            $msg = "Product Added Save later Successfully";
        endif;
        return response()->json([
            'sts' => true,
            'items' => $items,
            'msg' =>  $msg
        ]);
    }

    public function orderCalculation($cpnId, $request, $items)
    {
        $coupon = '';
        $subTotalVal =  $discountVal = $taxableVal = $gstVal = $totalVal = $dicPer = 0;
        $subTotal = $items->sale_price *  $request->qty;
        $subTotalVal += $subTotal;
        $valGst = gstVal($subTotal, $items->pdt->gst);
        $taxableVal += $valGst['total'];
        $gstVal += $valGst['gst'];
        $totalVal += $subTotal;
        // if ($cpnId) :
        //     $coupon = Coupon::find($cpnId);
        //     if ($coupon && $coupon->start_date <= now() && $coupon->end_date >= now()) :
        //         if ($totalVal >= $coupon->min_value) :
        //             if ($coupon->dis_type == 'Rupees') :
        //                 $dicPer = round((($coupon->dis_value * 100) / $taxableVal), 2);
        //                 $discountVal = round($coupon->dis_value, 2);
        //             else :
        //                 $dicPer = $coupon->dis_value;
        //                 $discountVal = round((($taxableVal * $dicPer) / 100), 2);
        //             endif;
        //             $gstVal = round($gstVal - (($gstVal * $dicPer) / 100), 2);
        //             $totalVal = ($taxableVal - $discountVal) + $gstVal;
        //         endif;
        //     endif;
        // endif;
        $totalVal = round($totalVal);
        return compact('subTotalVal', 'taxableVal', 'dicPer', 'discountVal', 'gstVal', 'totalVal', 'coupon');
    }

    public function remove(Request $request)
    {
        if (Auth::user()) :
            $authCart =  AuthCarts::find($request->pdtId);
            if ($authCart) :
                $authCart->delete();
                $items = items();
                $html = view('user.ajax.checkOutOrderSummery', compact('items'))->render();
                $cartSummery = view('user.ajax.cartSummery', compact('items'))->render();
                return response()->json([
                    'sts' => true,
                    'msg' => 'Item removed successfully',
                    'items' => $items,
                    'html' =>$html,
                    'cartSummery'=>$cartSummery
                ], 200);
            else :
                return response()->json([
                    'sts' => false,
                    'msg' => 'Item not found or already removed'
                ], 404);
            endif;
        else :
            return  $this->removSessionCart($request);
        endif;
    }

    public function updateCart(Request $request)
    {
        $sts = true;
        if (!Auth::user()) :
              $cartItems = \Cart::get($request['id']);
              $product = ProductInventory::with('Product', 'Product_image')->where('id', $request['id'])->first();
              $orderValue = $this->orderCalculation((!empty($request->coupon)) ? $request->coupon : "", $request, $product);
              $cartItem = $this->sessionupdateCart($request, $product, $orderValue);
              $sessionItems = sessionItems();
              $html = view('user.ajax.sessionCartList', compact('sessionItems'))->render();
              return response()->json([
                  'sts' => 'session',
                  'msg' => "Products Updated successfully",
                  'html' =>  $html,
                  'items' =>$sessionItems
              ]);
  
          endif;
        $authCart = AuthCarts::find($request->id);
        $inventory = ProductInventory::find($authCart->inventory_id);
        if ($request->qty > $inventory->inv_qty) :
            return response()->json([
                'sts' => false,
                'msg' => "The requested quantity (" . $request->qty . ") exceeds the available stock (" . $inventory->inv_qty . ")."
            ]);
        endif;
        $product = ProductInventory::with('product', 'Product_image')->where('id', $authCart->inventory_id)->first();
        $orderValue = $this->orderCalculation((!empty($request->coupon)) ? $request->coupon : "", $request, $product);
        AuthCarts::updateData($request, $product, $orderValue, $request->id);
        $items = items();
        $html = view('user.ajax.checkOutOrderSummery', compact('items'))->render();
        $cartSummery = view('user.ajax.cartSummery', compact('items'))->render();
        return response()->json(["sts" => $sts,'items' => $items,'html'=> $html,'cartSummery'=>$cartSummery]);
    }

    public function sessionaddToCart($dataVal, $product, $orderValue, $id = null)
    {
        $productId = $product->id;
        $productTitle = $product->title;
        $salePrice = $product->sale_price;
        $quantity = !empty($dataVal['qty']) ? $dataVal['qty'] : 1;
        $gst = $product->Product->gst;
        $hsn = $product->Product->hsn;
        $sku = $product->Product->sku;
        $image = ($product->Product_image)?$product->Product_image->image : '';

        $cartItems = \Cart::get($productId);
        if ($cartItems) :
            \Cart::update($productId, [
                'quantity' => [
                    'relative' => false,
                    'value' =>  $quantity
                ],
                'attributes' => [
                    'product' => $productId,
                    'gst' => $gst,
                    'hsn' => $hsn,
                    'sku' => $sku,
                    'image' => $image,
                    'variant' => $dataVal['variant'] ?? '',
                    'sub_total' => $orderValue['subTotalVal'],
                    'discount' => $orderValue['dicPer'],
                    'discount_value' => $orderValue['discountVal'],
                    'taxable_val' => $orderValue['taxableVal'],
                    'gst_val' => $orderValue['gstVal'],
                    'total' => $orderValue['totalVal'],
                ]
            ]);
        else :
            \Cart::add([
                'id' => $productId,
                'name' => $productTitle,
                'price' => $salePrice,
                'quantity' => $quantity,
                'attributes' => [
                    'product' => $productId,
                    'gst' => $gst,
                    'hsn' => $hsn,
                    'sku' => $sku,
                    'image' => $image,
                    'variant' => $dataVal['variant'] ?? '',
                    'sub_total' => $orderValue['subTotalVal'],
                    'discount' => $orderValue['dicPer'],
                    'discount_value' => $orderValue['discountVal'],
                    'taxable_val' => $orderValue['taxableVal'],
                    'gst_val' => $orderValue['gstVal'],
                    'total' => $orderValue['totalVal'],
                ]
            ]);
        endif;
        return \Cart::getContent();
    }

    public function removSessionCart(Request $request)
    {
        $productId = $request->input('pdtId');
        if (\Cart::get($productId)) {
            \Cart::remove($productId);
            $sessionItems = sessionItems();
            $html = view('user.ajax.sessionCartList', compact('sessionItems'))->render();
            return response()->json([
                'sts' => 'session',
                'msg' => 'Item removed successfully from session cart',
                'html' =>$html,
                'items' =>$sessionItems
            ], 200);
        } else {
            return response()->json([
                'sts' => false,
                'msg' => 'Item not found in session cart or already removed'
            ], 404);
        }
    }

    public function sessionupdateCart($dataVal, $product, $orderValue, $id = null)
    {
        $productId = $product->id;
        $gst = $product->pdt->gst;
        $hsn = $product->pdt->hsn;
        $sku = $product->pdt->sku;
        $image = ($product->pdt_img)?$product->pdt_img->image:"";

        \Cart::update($productId, [
            'quantity' => [
                'relative' => false,
                'value' => $dataVal['qty']
            ],
            'attributes' => [
                'product' => $productId,
                'gst' => $gst,
                'hsn' => $hsn,
                'sku' => $sku,
                'image' => $image,
                'variant' => $dataVal['variant'] ?? '',
                'sub_total' => $orderValue['subTotalVal'],
                'discount' => $orderValue['dicPer'],
                'discount_value' => $orderValue['discountVal'],
                'taxable_val' => $orderValue['taxableVal'],
                'gst_val' => $orderValue['gstVal'],
                'total' => $orderValue['totalVal'],
            ]
        ]);
        return \Cart::getContent();
    }
}
