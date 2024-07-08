<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table ="order_detail";
    protected $primery_key = 'id';

    public function ProductInventory(){
        return $this->belongsTo(ProductInventory::class,'inventory_id');
    }

    public static function saveData($item,$orderId, $id = null)
    {
        $OrdeDetailId = rand(299977970564,999999999999);
        $saveData = ($id)? OrderDetail::find($id): new OrderDetail;
        $saveData->id =$OrdeDetailId;
        $saveData->description = $item->description;
        $saveData->sku = ($item->sku)?$item->sku : "Null";
        $saveData->product_name =  $item->title;
        $saveData->hsn = $item->hsn;
        $saveData->price = $item->price;
        $saveData->qty =$item->qty;
        $saveData->open_qty = 1;
        $saveData->sub_total = $item->sub_total;
        $saveData->discount = $item->discount;
        $saveData->discount_value = $item->discount_value;
        $saveData->taxable_val = $item->taxable_val;
        $saveData->gst = $item->gst;
        $saveData->gst_val = $item->gst_val;
        $saveData->total = $item->total;
        $saveData->batch =$item->batch ;
        $saveData->expiry = $item->expiry;
        $saveData->batch_val = $item->batch_val;
        $saveData->expiry_date = $item->expiry_date;
        $saveData->created_at = now();
        $saveData->updated_at = now();
        $saveData->inventory_id  = $item->inventory_id ;
        $saveData->order_id  = $orderId;
        $saveData->is_del = 1;
        $saveData->sts = 'Placed';
        $saveData->detail_reason = null;
        $saveData->reason = null;
        $saveData->currency_code = 'INR';
        $saveData->save();
        return $saveData;
    }
}
