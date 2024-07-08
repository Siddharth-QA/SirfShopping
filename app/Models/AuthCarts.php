<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthCarts extends Model
{
    use HasFactory;
    protected $table = 'auth_carts';


    public function pdt_img()
    {
        return $this->hasOne(ProductImage::class, 'inventory_id');
    }

    public function pdt()
    {
        return $this->belongsTo(ProductInventory::class, 'inventory_id');
    }

    public static function saveData($dataVal, $product, $orderValue, $id = null)
    {
        $saveData = ($id) ? AuthCarts::find($id) : new AuthCarts;
        $auth = auth()->user();
        $authEmail = $auth->email;
        $authUser = AuthUser::where('email', $authEmail)->first();
        $uniqueId = generateUniqueId();
        $saveData->id = $uniqueId;
        $saveData->user_id = $authUser->id;
        $saveData->hsn = $product->Product->hsn;
        $saveData->description = $product->title;
        $saveData->price = $product->sale_price;
        if (empty($dataVal->qty)) :
            $saveData->qty = ($dataVal['qty']) ? $dataVal['qty'] : 1;
        else :
            $saveData->qty =($dataVal->qty)? $dataVal->qty :1 ;
        endif;
        $saveData->sub_total = $orderValue['subTotalVal'];
        $saveData->discount = $orderValue['dicPer'];
        $saveData->discount_value = $orderValue['discountVal'];
        $saveData->taxable_val = $orderValue['taxableVal'];
        $saveData->gst = $product->product->gst;
        $saveData->gst_val = $orderValue['gstVal'];
        $saveData->total = $orderValue['totalVal'];
        $saveData->cart_type = url('/');
        $saveData->save_later = 0;
        if (empty( $dataVal->pdtId)) :
            $saveData->inventory_id = $dataVal['pdtId'];
        else :
            $saveData->inventory_id = $dataVal->pdtId;
        endif;
        $saveData->batch = $product->batch;
        $saveData->batch_val = $product->batch_val;
        $saveData->expiry = $product->expiry;
        $saveData->expiry_date = $product->expiry_date;
        $saveData->currency_code = "INR";
        $saveData->save();
        return $saveData;
    }

    public static function updateData($dataVal, $product, $orderValue, $id = null)
    {
        $saveData = AuthCarts::find($id);
        $saveData->price = $product->sale_price;
        $saveData->qty = ($dataVal->qty) ? $dataVal->qty : 1;
        $saveData->sub_total = $orderValue['subTotalVal'];
        $saveData->discount = $orderValue['dicPer'];
        $saveData->discount_value = $orderValue['discountVal'];
        $saveData->taxable_val = $orderValue['taxableVal'];
        $saveData->gst = $product->product->gst;
        $saveData->gst_val = $orderValue['gstVal'];
        $saveData->total = $orderValue['totalVal'];
        $saveData->save();
        return $saveData;
    }


    public static function getTotal($user_id)
    {
        return AuthCarts::where('user_id', $user_id)->selectRaw('SUM(total) as total_price')->first();
    }
}
