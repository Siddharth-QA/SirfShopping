<?php

namespace App\Http\Controllers;

use App\Models\AuthAddress;
use App\Models\AuthCarts;
use App\Models\AuthCountry;
use App\Models\AuthInfo;
use App\Models\AuthUser;
use App\Models\Banner;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductCategoryUser;
use App\Models\ProductInventory;
use App\Models\ProductSubcategoryUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index(Request $req)
    {
        $items = null;
        $sessionItems = null;
        if (Auth::user()) :
            $items = items();
        else :
            $sessionItems = sessionItems();
        endif;
        $banners = Banner::where('user_id', userId())->get();

        if ($req->query('id')) :
            $id = decodeRequestData($req->query('id'));
            $products =  ProductInventoryByID($id);
            return view('index', compact('products', 'banners', 'items', 'sessionItems'));
        endif;
        $product_type = AllProduct();
        return view('index', compact('product_type', 'banners', 'items', 'sessionItems'));
    }

    public function login()
    {
        $items = items();
        return view('auth.index', compact('items'));
    }

    public function category(Request $request, $id)
    {
        $search = $request->search;
        $items = null;
        $sessionItems = null;
        if (Auth::user()) :
            $items = items();
        else :
            $sessionItems = sessionItems();
        endif;
        $id = decodeRequestData($id);

        $categoryQuery = ProductCategoryUser::join('product_category', 'product_category.id', '=', 'product_category_user.category_id')->select('product_category_user.id', 'product_category.title');

        $subcategoryQuery = ProductSubcategoryUser::join('product_sub_category', 'product_sub_category.id', '=', 'product_subcategory_user.subcategory_id')->select('product_subcategory_user.id', 'product_sub_category.title');

        if (!empty($search)) :
            if (AuthUser::find(userId())->is_superuser == 1) :
                $category = $categoryQuery->where('product_category.title', 'like', "%$search%")->first();
                $subcategory = $subcategoryQuery->where('product_sub_category.title', 'like', "%$search%")->first();
            else :
                $category = $categoryQuery->where('product_category.title', 'like', "%$search%")->where('user_id', userId())->first();
                $subcategory = $subcategoryQuery->where('product_sub_category.title', 'like', "%$search%")->where('user_id', userId())->first();
            endif;
        else :
            $category = $categoryQuery->where('category_id', decodeRequestData($request->id))->first();
            $subcategory = $subcategoryQuery->where('subcategory_id', decodeRequestData($request->id))->first();
        endif;

        if ($category) :
            $products =  Product::with('productInventory.Product_image')->where('category_id', $category->id)->get();
            return view('category', compact('category', 'products',  'items', 'sessionItems'));
        elseif ($subcategory) :
            $products = Product::with('productInventory.Product_image')->where('sub_category_id', $subcategory->id)->get();
            return view('category', compact('subcategory', 'products',  'items', 'sessionItems'));
        endif;

        if (!empty($search)) :
            $products = Product::with('productInventory.product_image')->where('product_name', 'like', "%{$search}%")->get();
            $productInventories = ProductInventory::with('product_image')->where('title', 'like', "%{$search}%")->where('user_id', userId())->get();
            if (AuthUser::find(userId())->is_superuser == 1) :
                $productInventories = ProductInventory::with('product_image')->where('title', 'like', "%{$search}%")->get();
            endif;

            if ($products->isNotEmpty()) :
                return view('category', compact('subcategory', 'products', 'search', 'items', 'sessionItems'));
            endif;
            if ($productInventories->isNotEmpty()) :
                return view('category', compact('subcategory', 'productInventories', 'products', 'search', 'items', 'sessionItems'));
            endif;
        endif;
        if ($search == null) :
            $products = Product::with('productInventory.product_image')->get();
            return view('category', compact('subcategory', 'products', 'search', 'items', 'sessionItems'));
        endif;
        $products = !empty($search) ? $products : collect();
        return view('category', compact('subcategory', 'products', 'search', 'items', 'sessionItems'));
    }

    public function detail($id)
    {
        $items = null;
        $sessionItems = null;

        if (Auth::user()) {
            $items = items();
        } else {
            $sessionItems = sessionItems();
        }

        $id = decodeRequestData($id);
        $auth = auth()->user();
        $count = 0;

        if ($auth) {
            $authEmail = $auth->email;
            $authUser = AuthUser::where('email', $authEmail)->first();
            $count = AuthCarts::where('user_id', $authUser->id)->where('inventory_id', $id)->count();
        }

        $rel_pdts = collect();
        $product = ProductInventory::with('Product', 'Product_imges')->where('id', $id)->first();

        if (!$product) {
            return redirect()->back()->withErrors('Product not found');
        }

        $relatedProducts = Product::where('sub_category_id', $product->Product->sub_category_id)->get();

        foreach ($relatedProducts as $relatedProduct) {
            $query = query($relatedProduct);

            if (AuthUser::find(userId())->is_superuser == 1) {
                $rel_pdts = $rel_pdts->merge($query->get());
            } else {
                $rel_pdts = $rel_pdts->merge($query->where('user_id', userId())->get());
            }
        }

        return view('detail', compact('product', 'rel_pdts', 'items', 'sessionItems', 'count'));
    }

    public function check_out()
    {
        if(!Auth::user()):
            return redirect('/auth');
        endif;
        $items = items();
        $authUser = AuthUser::where('email', Auth::user()->email)->first();
        $authInfo = AuthInfo::where('user_id', userId())->first();
        $adds = AuthAddress::where('user_id', $authUser->id)
            ->where('info_id', $authInfo->id)
            ->leftJoin('auth_state', 'auth_address.state_id', '=', 'auth_state.id')
            ->select('auth_address.*', 'auth_state.title as state')->get();
        $countries =  AuthCountry::get();
        return view('check_out', compact('items', 'adds', 'countries'));
    }

    public function cart()
    {
        if (Auth::user()) :
            $items = items();
            return view('cart', compact('items'));
        endif;
        $sessionItems = sessionItems();
        return view('cart', compact('sessionItems'));
    }

    function reload_cart($type)
    {
        $save_later = null;
        $sts = false;
        $html = '';

        if ($type == 'later') :
            $items = items();
            $sts = true;
            $html = view('user.ajax.save_later', compact('items'))->render();
        else :
            $items = items();
            $sts = true;
            $html = view('user.ajax.cart_list', compact('items'))->render();
        endif;
        return response()->json(['html' => $html, "sts" => $sts, 'items' => $items]);
    }

    public function order()
    {
        $items = items();
        $customer = AuthUser::with('address', 'info')->where('email', Auth::user()->email)->first();
        $supplier  = AuthUser::with('address', 'info', 'bank')->where('id', userId())->first();
        $orders = Order::with('orderDetails.ProductInventory.Product_image')
            ->where('supplier_id_id', $supplier->id)
            ->where('customer_id_id', $customer->id)
            ->where('order_via', url('/'))
            ->orderBy('order_date', 'desc')
            ->get();
        foreach ($orders as $order) :
            if ($order->shipped_address) :
                $order->shipped_address = json_decode($order->shipped_address);
            endif;
        endforeach;
        return view('user.order.index', compact('orders', 'items'));
    }

    public function orderDetails($id)
    {
        $id = decodeRequestData($id);
        $items = items();
        $customer = AuthUser::with('address', 'info')->where('email', Auth::user()->email)->first();
        $supplier  = AuthUser::with('address', 'info', 'bank')->where('id', userId())->first();
        $orders = Order::join('auth_country', 'order.country_id', '=', 'auth_country.id')->select('order.*', 'auth_country.title as country')->with('orderDetails.ProductInventory.Product_image')
            ->where('order.id', $id)
            ->where('order.supplier_id_id', $supplier->id)
            ->where('order.customer_id_id', $customer->id)
            ->orderBy('order.order_date', 'desc')
            ->first();
        if ($orders->shipped_address) :
            $orders->shipped_address = json_decode($orders->shipped_address);
        endif;
        return view('user.order.details', compact('orders', 'items', 'supplier'));
    }

    public function wishlist()
    {
        $wishlists = wishlist();
        $items = items();
        return view('wishlist', compact('items', 'wishlists'));
    }

    public function blog()
    {
        $items = items();
        return view('blog', compact('items'));
    }

    public function faq()
    {
        $items = items();
        return view('faq', compact('items'));
    }

    public function blog_details()
    {
        $items = items();
        return view('blog_details', compact('items'));
    }

    public function page_404()
    {
        $items = items();
        return view('page_404', compact('items'));
    }

    public function cat_list($id)
    {
        $mergedProducts = [];
        $catUser = ProductCategoryUser::with('category')->where('category_id', $id)->first();
        $catId = $catUser->id;
        $pdts = Product::where('category_id', $catId)->get();
        foreach ($pdts as $pdt) {
            $mergedProducts[] = ProductInventory::with('pdt', 'pdt_img')->where('product_id', $pdt->id)->get()->toArray();
        }
        return array_merge(...$mergedProducts);
    }

    public function category_product($category)
    {
        $productsCollection = collect();
        $items = null;
        $sessionItems = null;
        if (Auth::user()) :
            $items = items();
        else :
            $sessionItems = sessionItems();
        endif;

        $products =  Product::with('productInventory.Product_image')->where('category_id', $category->id)->get();

        return view('category', compact('products', 'catUser', 'items', 'sessionItems'));
    }
}
