<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\AuthAddress;
use App\Models\AuthCarts;
use App\Models\AuthInfo;
use App\Models\AuthUser;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductInventory;
use App\MsgApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        return $items = items();
        // return view('user.order.index',compact('items'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'shippingId' => MsgApp::REQ,
                'billingId' => MsgApp::REQ,
                'payMode' =>  MsgApp::REQ,
            ],
            [
                'required' => ':attribute Not Selected',
            ],
            ['shippingId' => 'Shipping Address', 'billingId' => 'Billing Address', 'payMode' => 'Payment Mode']
        );

        if ($validator->fails()) {
            return response()->json([
                'sts' => false,
                'errors' => $validator->errors()->all()
            ], 200);
        }

        if ($request->input('payMode') !== "Cod") {
            return response()->json([
                'sts' => false,
                'msg' => 'Only Cash on Delivery (Cod) payment mode is available at this time.',
                'error' => 'Cod'
            ]);
        }
        $customer = AuthUser::with('info')->where('email', Auth::user()->email)->first();
        $bllingAddress = AuthAddress::join('auth_country', 'auth_address.country_id', '=', 'auth_country.id')->join('auth_state', 'auth_address.state_id', '=', 'auth_state.id')->select('auth_address.*', 'auth_country.title as country', 'auth_state.title as state')->where('auth_address.id', $request->billingId)->first();

        $shippingAddress = AuthAddress::join('auth_country', 'auth_address.country_id', '=', 'auth_country.id')->join('auth_state', 'auth_address.state_id', '=', 'auth_state.id')->select('auth_address.*', 'auth_country.title as country', 'auth_state.title as state')->where('auth_address.id', $request->shippingId)->first();

        $cartItems = AuthCarts::where('user_id', $customer->id)->where('auth_carts.cart_type', url('/'))->where('auth_carts.save_later', 0)->get();
        if ($cartItems->isEmpty()) :
            return response()->json(['sts' => false, 'msg' => 'Your Cart Is Empty']);
        endif;

        $quantityErrors = [];
        foreach ($cartItems as $cartItem) :
            $inventory = ProductInventory::find($cartItem->inventory_id);
            if ($cartItem->qty > $inventory->inv_qty) :
                $quantityErrors[] = 'Quantity in cart (' . $cartItem->qty . ') exceeds available stock (' . $inventory->inv_qty . ') for item: ' . $inventory->title;
            endif;
        endforeach;
        if (!empty($quantityErrors)) :
            return response()->json([
                'sts' => false,
                'errors' => $quantityErrors
            ]);
        endif;

        if (AuthUser::find(userId())->is_superuser == 1) :
            $entries = AuthCarts::join('product_inventory', 'auth_carts.inventory_id', '=', 'product_inventory.id')
                ->select('product_inventory.user_id', DB::raw('COUNT(product_inventory.user_id) as entries'))
                ->where('auth_carts.cart_type', url('/'))
                ->where('auth_carts.save_later', 0)
                ->where('auth_carts.user_id', $customer->id)
                ->groupBy('product_inventory.user_id')
                ->get();

            foreach ($entries as $entry) :
                $supplier  = AuthUser::with('address', 'info', 'bank')->where('id', $entry->user_id)->first();
                $items = AuthCarts::join('product_inventory', 'auth_carts.inventory_id', '=', 'product_inventory.id')
                    ->select('auth_carts.*', 'product_inventory.title', 'product_inventory.user_id as user', 'product_inventory.sku')
                    ->where('auth_carts.user_id', $customer->id)
                    ->where('auth_carts.save_later', 0)
                    ->where('auth_carts.cart_type', url('/'))
                    ->where('product_inventory.user_id', $entry->user_id)
                    ->get();

                $orderValue = $this->orderCalculation((!empty($request->coupon)) ? $request->coupon : "", $items);

                $order = Order::place_order($customer, $bllingAddress, $shippingAddress, $supplier, $orderValue);

                foreach ($items as $item) :
                    OrderDetail::saveData($item, $order);
                endforeach;
            endforeach;
        endif;
        $supplier  = AuthUser::with('address', 'info', 'bank')->where('id', userId())->first();
        $items = AuthCarts::join('product_inventory', 'auth_carts.inventory_id', '=', 'product_inventory.id')->select('auth_carts.*', 'product_inventory.title', 'product_inventory.user_id as user', 'product_inventory.sku')->where('auth_carts.user_id', $customer->id)->where('auth_carts.save_later', 0)->where('auth_carts.cart_type', url('/'))->get();

        $orderValue = $this->orderCalculation((!empty($requestData['coupon'])) ? $requestData['coupon'] : "", $items);
        // $total = AuthCarts::getTotal( $authUser->id);
        $order = Order::place_order($customer, $bllingAddress, $shippingAddress, $supplier, $orderValue);
        foreach ($items as $items) :
            OrderDetail::saveData($items, $order);
        endforeach;

        foreach ($cartItems as $cartItem) {
            $inventory = ProductInventory::find($cartItem->inventory_id);
            $newQty = $inventory->inv_qty - $cartItem->qty;
            $inventory->inv_qty = $newQty;
            $inventory->save();
        }

        $items = AuthCarts::where('user_id', $customer->id)->where('save_later', 0)->where('cart_type', url('/'))->delete();
        return response()->json([
            'sts' => true,
        ]);
    }

    public function orderCalculation($cpnId, $items)
    {
        $coupon = '';
        $subTotalVal =  $discountVal = $taxableVal = $gstVal = $totalVal = $dicPer = 0;
        foreach ($items as $item) :
            $subTotal = $item->price * $item->qty;
            $subTotalVal += $subTotal;
            $valGst = gstVal($subTotal, $item->gst);
            $taxableVal += $valGst['total'];
            $gstVal += $valGst['gst'];
            $totalVal += $subTotal;
        endforeach;
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

    public function thankYou()
    {
        return view('user.order.thankYou');
    }
    public function updateStatus(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'reason' => MsgApp::REQ,
                'details' => MsgApp::REQ,
            ],
            [
                'required' => ':attribute is required',
            ],
            ['reason' => 'Reason', 'details' => 'Reason details']
        );

        if ($validator->fails()) {
            return response()->json([
                'sts' => false,
                'errors' => $validator->errors()->all()
            ], 200);
        }

        $msg = '';;
        $msg = '';
        if ($request->status == 'Cancelled') :
            $msg = 'Your order has been successfully cancelled. We are sorry to see you go, but appreciate your feedback. If there was any issue, please let us know how we can improve.';
        elseif ($request->status == 'Return Requested') :
            $msg = 'Your return request has been successfully submitted. Our team will review your request and get back to you shortly. Thank you for your patience.';
        endif;
        $orderList = OrderDetail::find($request->orderId);
        $orderList->sts = $request->status;
        $orderList->reason = $request->reason;
        $orderList->detail_reason = $request->details;
        $orderList->save();

        $inventory = ProductInventory::find($request->inventoryId);
        $newQty = $inventory->inv_qty + $request->quantity;
        $inventory->inv_qty = $newQty;
        $inventory->save();

        return response()->json([
            'sts' => true,
            'msg' => $msg
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $customer = AuthUser::where('email', Auth::user()->email)->first();
        $cartQuery = AuthCarts::where('user_id', $customer->id)
            ->where('auth_carts.cart_type', url('/'))
            ->where('auth_carts.save_later', 0);
            // ->sum('total');

        $total = $cartQuery->sum('total');    
    
        $coupon = Coupon::where('title', $request->coupon)->first();
    
        if (!$coupon) {
            return response()->json([
                'sts' => false,
                'msg' => 'Coupon not found!'
            ]);
        }
    
        if (now()->lt($coupon->start_date) || now()->gt($coupon->end_date)) {
            return response()->json([
                'sts' => false,
                'msg' => 'Coupon is not valid!'
            ]);
        }
    
        if ($coupon->min_value > $total) {
            return response()->json([
                'sts' => false,
                'msg' => 'Total amount is less than the minimum required to apply this coupon!'
            ]);
        }
    
        return response()->json([
            'sts' => true,
            'msg' => 'Coupon applied successfully!',
            'discount' => $coupon->dis_value,
            'newTotal' => $total - $coupon->discount
        ]);
    }
    
}
