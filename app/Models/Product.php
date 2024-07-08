<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';

    public function productInv()
    {
        $query = $this->hasMany(ProductInventory::class, 'product_id')
            ->where('is_active', 1)
            ->where('parent', 0)
            ->where('enable_e_com', 1)
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('inventory', 0)
                        ->where('inv_qty', '>=', 0);
                })
                ->orWhere(function ($query) {
                    $query->where('inventory', 1)
                        ->where('inv_qty', '>', 0);
                });
            })
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('batch', 0)
                        ->whereNull('batch_val');
                })
                ->orWhere(function ($query) {
                    $query->where('batch', 1)
                        ->whereNotNull('batch_val');
                });
            })
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('expiry', 0)
                        ->whereNull('expiry_date');
                })
                ->orWhere(function ($query) {
                    $query->where('expiry', 1)
                        ->where('expiry_date', '>',  now());
                });
            });
            
            if (AuthUser::find(userId())->is_superuser != 1):
                $query->where('user_id', userId());
            endif;
            
            return $query;
    }

    public function productInventory()
    {
        $query = $this->hasOne(ProductInventory::class, 'product_id')
            ->where('is_active', 1)
            ->where('parent', 0)
            ->where('enable_e_com', 1)
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('inventory', 0)
                        ->where('inv_qty', '>=', 0);
                })
                ->orWhere(function ($query) {
                    $query->where('inventory', 1)
                        ->where('inv_qty', '>', 0);
                });
            })
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('batch', 0)
                        ->whereNull('batch_val');
                })
                ->orWhere(function ($query) {
                    $query->where('batch', 1)
                        ->whereNotNull('batch_val');
                });
            })
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('expiry', 0)
                        ->whereNull('expiry_date');
                })
                ->orWhere(function ($query) {
                    $query->where('expiry', 1)
                        ->where('expiry_date', '>',  now());
                });
            });
            
            if (AuthUser::find(userId())->is_superuser != 1):
                $query->where('user_id', userId());
            endif;
            
            return $query;
    }
}
