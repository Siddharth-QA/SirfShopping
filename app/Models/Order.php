<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class,'order_id');
    }

    public static function place_order($customer,$bllingAddress,$shippingAddress, $supplier,$orderValue)
    {
        $id = rand(299977970564,999999999999);
        $saveData = new Order;
        $saveData->id = $id; 
        $saveData->inv_prefix = $supplier->info->inv_prefix;
        $saveData->pi_prefix = $supplier->info->pi_prefix;
        $saveData->pinv_prefix = $supplier->info->pinv_prefix;
        $saveData->pord_prefix = $supplier->info->pord_prefix;
        $saveData->order_date = date('Y-m-d');
        $saveData->supplier_name = $supplier->first_name.' '.$supplier->last_name;
        $saveData->supplier_company = $supplier->info->company_name;
        $saveData->supplier_email = $supplier->info->email;
        $saveData->supplier_phone =  $supplier->info->mobile;
        $saveData->supplier_address = $supplier->address->address;
        $saveData->supplier_state_code = $supplier->address->pin_code;
        $saveData->supplier_gstin = $supplier->info->gstin;
        $saveData->customer_name = $customer->first_name.' '.$customer->last_name;
        $saveData->customer_company = $customer->info->company_name;
        $saveData->customer_email = $customer->info->email;
        $saveData->customer_phone = $customer->info->mobile;
        $saveData->customer_address = $bllingAddress->address;
        $saveData->customer_state_code = $bllingAddress->pin_code;
        $saveData->customer_gstin = ($customer->info->gstin)?$customer->info->gstin: 'NA';
        $saveData->sale_type = 'Sale';
        if ($bllingAddress->address == $shippingAddress->address):
            $saveData->same_shipped = 1;
            $saveData->shipped_address = '{}';
            $saveData->order_type = 'Online';
        else:
            $saveData->same_shipped = 0;
            $saveData->shipped_address = json_encode([
                'name' => $customer->first_name . ' ' . $customer->last_name,
                'address' => $shippingAddress->address,
                'city' => $shippingAddress->city,
                'pincode' => $shippingAddress->pin_code,
                'country' => $shippingAddress->country,
                'state' => $shippingAddress->state,
            ]);
        endif;
        $saveData->order_via = url('/');
        $igst = $sgst = 0;
        $gst = $orderValue['taxableVal'];
        if ($supplier->address->state_id == $shippingAddress->state_id):
            $sgst = $gst/2;
        else:
            $igst = $gst;
        endif;
        $saveData->sub_total = $orderValue['subTotalVal'];
        $saveData->discount_value =  $orderValue['discountVal'];
        $saveData->taxable_val = $orderValue['taxableVal'];
        $saveData->cgst = $sgst;
        $saveData->sgst = $sgst;
        $saveData->igst =  $igst;
        $saveData->total = $orderValue['totalVal'];
        $saveData->note = 'Web';
        $saveData->term_condition =  $supplier->info->term_condition;
        $saveData->attachment = 'NA';
        $saveData->is_active = true;
        if($supplier->bank):
        $saveData->account_name = $supplier->bank->account_name;
        $saveData->account_no = $supplier->bank->account_no;
        $saveData->branch = $supplier->bank->branch;
        $saveData->ifsc = $supplier->bank->ifsc;
        endif;
        $saveData->inv_sts ='Paid';
        $saveData->ord_sts = 'Placed';
        $saveData->pmt_rcvd = $orderValue['totalVal'];
        $saveData->customer_id_id = $customer->id;
        $saveData->customer_info_id = $customer->info->id;
        $saveData->supplier_id_id  = $supplier->id;
        $saveData->supplier_info_id  = $supplier->info->id;
        $saveData->country_id  = 353676346433;
        $saveData->currency_code = 1;
        $saveData->sts = 'Placed';
        // $saveData->domain = url('/');
        // $saveData->is_tds = null;
        // $saveData->tds_rate = null;
        // $saveData->tds_amt = null;
        // $saveData->tds_paid = null;
        // $saveData->tds_sts = null;
        // $saveData->purchase_no = null;
        // $saveData->invoice_no = null;
        // $saveData->logistic = null;
        // $saveData->tracking_id = null;
        // $saveData->owner_id  = null;
        // $saveData->ice = null;
        // $saveData->qr = null;
        // $saveData->swft_code = null; 
        // $saveData->vpa = null;
        // $saveData->bank_name = null; 
        $saveData->save();
        return $id;
    }
}
