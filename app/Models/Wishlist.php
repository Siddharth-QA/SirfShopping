<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    protected $table = 'auth_wishlist';

    
    public function pdt_img()
    {
        return $this->hasOne(ProductImage::class, 'inventory_id');
    }

    public function pdt()
    {
        return $this->belongsTo(ProductInventory::class, 'inventory_id');
    }
    
    public static function saveData($dataVal, $product, $id = null)
    {
        $saveData = ($id) ? Wishlist::find($id) : new Wishlist;
        $auth = auth()->user();
        $authEmail = $auth->email;
        $authUser = AuthUser::where('email', $authEmail)->first();
        $uniqueId = generateUniqueId();
        $saveData->id = $uniqueId;
        $saveData->user_id = $authUser->id;
        $saveData->product_name = $product->title;
        $saveData->mrp = $product->mrp;
        $saveData->sale_price = $product->sale_price;
        $saveData->domain = url('/');
        $saveData->inventory_id  = $dataVal['pdtId'];
        $saveData->save();
        return $saveData;
    }

}
