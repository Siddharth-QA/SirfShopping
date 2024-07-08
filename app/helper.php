<?php

use App\Models\AuthCarts;
use App\Models\AuthProfile;
use App\Models\AuthUser;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCategoryUser;
use App\Models\ProductInventory;
use App\Models\ProductSubCategory;
use App\Models\ProductSubcategoryUser;
use App\Models\ProductType;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

const KEY = 'ACC62A67A3D055E6AF68BD9D3ED9A519';
const IV = '608538a015674f17';

if (!function_exists('img_url')) {
    function img_url($img)
    {
        // return "https://sandbox.nipunbycsg.com/media/$img";
        // return "http://192.168.1.20:9000/media/$img";
        // return "http://192.168.1.29/my.nipunbycsg.com/media/$img";
    }
}

if (!function_exists('gstVal')) {
    function gstVal($taxableValue, $tax)
    {
        $gst = $total = 0;
        $tax100 = 1 + ($tax / 100);
        $total = round(($taxableValue / $tax100), 2);
        $gst = round($taxableValue - $total, 2);
        return compact('gst', 'total');
    }
}

if (!function_exists('generateUniqueId')) {
    function generateUniqueId()
    {
        $randomNumber = mt_rand(100000000000, 999999999999);
        return (string)$randomNumber;
    }
}

if (!function_exists('items')) {
    function items()
    {
        $auth = Auth::user();
        if ($auth) :
            $authEmail = $auth->email;
            $authUser = AuthUser::where('email', $authEmail)->first();
            $carts = AuthCarts::with('pdt.pdt_img')->where('cart_type',url('/'))->where('save_later',0)->where('user_id', $authUser->id)->orderBy('id', 'desc')->get();
            $save_later = AuthCarts::with('pdt.pdt_img')->where('cart_type',url('/'))->where('save_later',1)->where('user_id', $authUser->id)->orderBy('id', 'desc')->get();
            $subtotal = $carts->sum('sub_total');
            $subtotal = number_format($subtotal, 2, '.', '');
            $price = $carts->sum('price');
            $taxable_val = $carts->sum('taxable_val');
            $discount = $carts->sum('discount_value');
            $gst = $carts->sum('gst_val');
            $total = $carts->sum('total');
            $total = number_format($total, 2, '.', '');
            $qty = AuthCarts::where('user_id', $authUser->id)->where('cart_type',url('/'))->where('save_later',0)->count();
            return compact('carts','save_later', 'subtotal', 'total', 'qty', 'price', 'discount', 'gst', 'taxable_val');
        endif;
    }
}

if (!function_exists('sessionItems')) {
    function sessionItems()
    {
        $cartItems = \Cart::getContent();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        $subtotal = number_format($subtotal, 2, '.', '');

        $price = $cartItems->sum(function ($item) {
            return $item->price;
        });

        $taxable_val = $cartItems->sum(function ($item) {
            return $item->attributes->taxable_val;
        });

        $discount = $cartItems->sum(function ($item) {
            return $item->attributes->discount_value;
        });

        $gst = $cartItems->sum(function ($item) {
            return $item->attributes->gst_val;
        });

        $total = $cartItems->sum(function ($item) {
            return $item->attributes->total;
        });
        $total = number_format($total, 2, '.', '');

        $qty = \Cart::getContent()->count();

        return compact('cartItems', 'subtotal', 'total', 'qty', 'price', 'discount', 'gst', 'taxable_val');
    }
}

if (!function_exists('wishlist')) {
    function wishlist()
    {
        $auth = Auth::user();
        if ($auth) :
            $authEmail = $auth->email;
            $authUser = AuthUser::where('email', $authEmail)->first();
            $carts = Wishlist::with('pdt.pdt_img')->where('user_id', $authUser->id)->where('domain',url('/'))->orderBy('id', 'desc')->get();
            return $carts;
        endif;
    }
}

if (!function_exists('userId')) {
    function userId()
    {
        $currentUrl = url('/');
        $domain = AuthProfile::where('domain', $currentUrl)->first();
        return $domain->user_id;
    }
}

if (!function_exists('encodeRequestData')) {
    function encodeRequestData($data)
    {
        $encryptedData = openssl_encrypt($data, 'aes-256-cbc', KEY, 0, IV);
        $encodedData = urlencode(base64_encode($encryptedData));
        return $encodedData;
    }
}

if (!function_exists('decodeRequestData')) {
    function decodeRequestData($data = 'aGJaWTlScEE4YzNqTUhpUndBcHp2Zz09')
    {
        $decodedData = base64_decode(urldecode($data));
        return openssl_decrypt($decodedData, 'aes-256-cbc', KEY, 0, IV);
    }
}

if (!function_exists('insert_To_db')) {
    function insert_To_db($request)
    {
        $product = ProductInventory::with('pdt')->where('id', $request['pdtId'])->first();
        $orderValue = orderCalculation((!empty($request->coupon)) ? $request->coupon : "", $request, $product);
        $cartItem = AuthCarts::saveData($request, $product, $orderValue);
        return $cartItem;
    }
}

if (!function_exists('update_To_db')) {
    function update_To_db($request)
    {
        $auth = auth()->user();
        $authEmail = $auth->email;
        $authUser = AuthUser::where('email', $authEmail)->first();
        $authCart =  AuthCarts::where('user_id', $authUser->id)->where('inventory_id', $request['pdtId'])->where('cart_type',url('/'))->where('save_later',0)->first();
        $product = ProductInventory::with('pdt')->where('id', $request['pdtId'])->first();
        $orderValue = orderCalculation((!empty($request->coupon)) ? $request->coupon : "", $request, $product);
        $cartItem = AuthCarts::saveData($request, $product, $orderValue, $authCart->id);
        return $cartItem;
    }
}

function orderCalculation($cpnId, $request, $items)
{
    $coupon = '';
    $subTotalVal =  $discountVal = $taxableVal = $gstVal = $totalVal = $dicPer = 0;
    $subTotal = $items->sale_price * (!empty($request->qty) ? $request->qty : 1);
    $subTotalVal += $subTotal;
    $valGst = gstVal($subTotal, $items->pdt->gst);
    $taxableVal += $valGst['total'];
    $gstVal += $valGst['gst'];
    $totalVal += $subTotal;
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

if (!function_exists('userId')) {
    function userId()
    {
        $currentUrl = url('/');
        $domain = AuthProfile::where('domain', $currentUrl)->first();
        if (!$domain) :
            return collect();
        endif;
        return $domain->user_id;
    }
}

// products fatch

if (!function_exists('query')) {
    function query($product = null)
    {
        $query = ProductInventory::with('Product_image')->where('is_active', 1)->where('parent', 0)->where('enable_e_com', 1)
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
                            ->where('expiry_date', '>', '2024-06-04');
                    });
            });
        if ($product != null) :
            $query->where('product_id', $product->id);
        endif;
        return $query;
    }
}

// if (!function_exists('AllProduct')) {
//     function AllProduct()
//     {
//         $data = [];
//         $category = ProductCategoryUser::join('product_category','product_category.id', '=', 'product_category_user.category_id')->select('product_category_user.*','product_category.title as title')->where('user_id', userId())->get();
//         foreach($category as $cat):
//             $checkCat =  ProductInventory::getAll()->where('product.category_id', $cat->id)->get();
//             $name = [];
//             $product = [];
//             if ($checkCat):
//                 $name[] = ["name"=>"all", "id"=>"all"];
//                 $product[] = $checkCat;
//                 $checkSubCat =  ProductSubcategoryUser::getCatPro($cat->id, userId())->get();
//                 foreach($checkSubCat as $sub):
//                     $checkSub  = ProductInventory::getAll()->where('product.sub_category_id', $cat->id)->get();
//                     if ($checkSub):
//                         $idv = "id" . $sub->id;
//                         $name[] = ["name"=>$sub->title, "id"=>$idv];
//                         $product[] = $checkSub;
//                     endif;
//                 endforeach;
//                 $data[] = ['key_val'=> $cat->title, 'id'=> $cat->id,'name'=> $name, 'product'=> $product];
//             endif;
//         endforeach;
//         return $data;
//     }
// }

if (!function_exists('AllProduct')) {
    function AllProduct()
    {
        $productsCollection = collect();
        if (AuthUser::find(userId())->is_superuser == 1) :
            $productTypes = ProductType::get();

            foreach ($productTypes as $productType) :
                $categoryData = [
                    'category' => $productType,
                    'subcategories' => collect(),
                    'products' => collect()
                ];
    
                if (ProductCategoryUser::where('product_type_id', $productType->id)->exists()) :
                    $categories = ProductCategoryUser::join('product_category', 'product_category_user.category_id', '=', 'product_category.id')
                    ->where('product_type_id', $productType->id)
                    ->select('product_category_user.id', 'product_category.title')
                    ->get();
    
                    foreach ($categories as $category) :
                        $subcategoryData = [
                            'subcategory' => $category,
                            'products' => collect()
                        ];
    
                        if (Product::where('category_id', $category->id)->exists()) :
                            $products = Product::with('productInventory.Product_image')->where('category_id', $category->id)->get();
                            $subcategoryData['products'] = $subcategoryData['products']->merge($products);
                        endif;
                        $categoryData['subcategories']->push($subcategoryData);
                    endforeach;
                endif;
    
                // if (Product::where('category_id', $category->id)->exists()) :
                //     $products = Product::with('productInventory.Product_image')->where('category_id', $category->id)->get();
                //     $subcategoryData['products'] = $subcategoryData['products']->merge($products);
                // endif;
    
                $productsCollection->push($categoryData);
            endforeach;
    
            return $productsCollection;

        endif;
        $categories = ProductCategoryUser::join('product_category', 'product_category_user.category_id', '=', 'product_category.id')
            ->select('product_category_user.id', 'product_category.title')
            ->where('user_id', userId())
            ->get();

        foreach ($categories as $category) :
            $categoryData = [
                'category' => $category,
                'subcategories' => collect(),
                'products' => collect()
            ];

            if (ProductSubcategoryUser::where('category_id', $category->id)->exists()) :
                $subcategories = ProductSubcategoryUser::where('category_id', $category->id)
                    ->join('product_sub_category', 'product_subcategory_user.subcategory_id', '=', 'product_sub_category.id')
                    ->select('product_subcategory_user.id', 'product_sub_category.title')
                    ->where('user_id', userId())
                    ->get();

                foreach ($subcategories as $subcategory) :
                    $subcategoryData = [
                        'subcategory' => $subcategory,
                        'products' => collect()
                    ];

                    if (Product::where('sub_category_id', $subcategory->id)->exists()) :
                        $products = Product::with('productInventory.Product_image')->where('sub_category_id', $subcategory->id)->get();
                        $subcategoryData['products'] = $subcategoryData['products']->merge($products);
                    endif;
                    $categoryData['subcategories']->push($subcategoryData);
                endforeach;
            endif;

            if (Product::where('category_id', $category->id)->exists()) :
                $products = Product::with('productInventory.Product_image')->where('category_id', $category->id)->get();
                $subcategoryData['products'] = $subcategoryData['products']->merge($products);
            endif;

            $productsCollection->push($categoryData);
        endforeach;

        return $productsCollection;
    }
}


if (!function_exists('ProductInventoryByID')) {
    function ProductInventoryByID($id)
    {
        $mergedProducts = collect();
        $catUser = ProductCategoryUser::with('category')->where('category_id', $id)->first();

        if (!$catUser) :
            return $mergedProducts;
        endif;

        $catId = $catUser->id;
        $products = Product::where('category_id', $catId)->get();

        foreach ($products as $product) :
            $query = query($product);

            if (AuthUser::find(userId())->is_superuser == 1) :
                $mergedProducts = $mergedProducts->merge($query->get());
            else :
                $mergedProducts = $mergedProducts->merge($query->where('user_id', userId())->get());
            endif;
        endforeach;

        return $mergedProducts;
    }
}
