<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInventory extends Model
{
    use HasFactory;
    protected $table = 'product_inventory';

    public function Product_image()
    {
        return $this->hasOne(ProductImage::class, 'inventory_id');
    }
    public function Pdt_img()
    {
        return $this->hasOne(ProductImage::class, 'inventory_id');
    }

    public function Product_imges()
    {
        return $this->hasMany(ProductImage::class, 'inventory_id');
    }

    public function Product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function pdt()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public static function getAll(){
        return  ProductInventory::with('Product_image')->join('product', 'product_inventory.product_id', '=', 'product.id')
        ->where('product_inventory.enable_e_com', 1)
        ->where('product_inventory.is_active', 1)
        ->where('product_inventory.parent', 0)
        ->where('product.is_sale', 1)
        ->where(function($query) {
            $query->where('product_inventory.inventory', 0)
                ->orWhere(function($query) {
                    $query->where('product_inventory.inventory', 1)
                        ->where('product_inventory.inv_qty', '>', 0);
                })
                ->orWhere('product_inventory.negative_inv', 1);
        })
        // ->where(function($query) {
        //     $query->where('product_inventory.batch', 0)
        //         ->orWhere(function($query) {
        //             $query->where('product_inventory.batch', 1)
        //                 ->whereNull('product_inventory.batch_val');
        //         });
        // })
        ->where(function($query) {
            $query->where('product_inventory.expiry', 0)
                ->orWhere(function($query) {
                    $query->where('product_inventory.expiry', 1)
                        ->where(function($query) {
                            $query->where('product_inventory.expiry_date', '>', now())
                                ->orWhereNull('product_inventory.expiry_date');
                        });
                });
        });

    }

}
