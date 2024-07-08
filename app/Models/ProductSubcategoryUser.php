<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSubcategoryUser extends Model
{
    use HasFactory;
    protected $table = 'product_subcategory_user';

    public function subcategory()
    {
        return $this->belongsTo(ProductSubCategory::class, 'subcategory_id');
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'sub_category_id');
    }

    public static function getCatPro($catId, $userIid)
    {
        return ProductSubcategoryUser::join('product_sub_category','product_sub_category.id', '=', 'product_subcategory_user.subcategory_id')->select('product_subcategory_user.*','product_sub_category.title as title')->where('category_id',  $catId)->where('user_id', $userIid);
    }
}
