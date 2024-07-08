<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryUser extends Model
{
    use HasFactory;
    protected $table = 'product_category_user';

    public function ProductSubcategoryUser()
    {
        return $this->hasMany(ProductSubcategoryUser::class, 'category_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
    
}
