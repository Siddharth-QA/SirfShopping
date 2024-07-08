<?php

namespace App\Http\Controllers;

use App\Models\AuthAddress;
use App\Models\AuthInfo;
use App\Models\AuthProfile;
use App\Models\AuthUser;
use App\Models\ProductCategory;
use App\Models\ProductCategoryUser;
use App\Models\ProductSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{

    public function test()
    {
        $domain = AuthProfile::where('domain', url('/'))->first();
        $authId = AuthUser::find($domain->user_id)->id;
        $info = AuthInfo::select('mobile', 'email')->where('user_id', $authId)->first();
        $address = AuthAddress::select('address')->where('user_id', $authId)->first();
        $catQuery = ProductCategoryUser::with(['ProductSubcategoryUser' => function ($query) {
            $query->with(['product' => function ($query) {
                $query->withCount(['productInv as inventory_count' => function ($query) {
                    $query->where('is_active', 1)
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
                }]);
            }])
                ->join('product_sub_category', 'product_sub_category.id', '=', 'product_subcategory_user.subcategory_id')
                ->select('product_subcategory_user.*', 'product_sub_category.title', 'product_sub_category.id as subCategoryId');
        }])
            ->join('product_category', 'product_category.id', '=', 'product_category_user.category_id')->select('product_category_user.*', 'product_category.title', 'product_category.id as categoryId', 'product_category.image');

        if (AuthUser::find($domain->user_id)->is_superuser == 1) :
            $categories = $catQuery->get();
        else :
            $categories = $catQuery->where('user_id', $domain->user_id)->get();
        endif;

        $data['categories'] = $categories;

        return $data;
        return 'ok';
        $path = public_path('stmt.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
        return "done";
    }
}
