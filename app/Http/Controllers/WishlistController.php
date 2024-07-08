<?php

namespace App\Http\Controllers;

use App\Models\AuthUser;
use App\Models\ProductInventory;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function wishlist(Request $request)
    {
        $auth = auth()->user();
        if (!$auth) :
            return response()->json([
                'sts' => false,
                'login' => false,
            ]);
        endif;

        $authEmail = $auth->email;
        $authUser = AuthUser::where('email', $authEmail)->first();

        if (Wishlist::where('user_id', $authUser->id)->where('inventory_id', $request->pdtId)->exists()) {
            return response()->json([
                'sts' => false,
                'msg' => "This product is already added to the wishlist"
            ]);
        }

        $product = ProductInventory::with('pdt')->where('id', $request->pdtId)->first();
        $cartItem = Wishlist::saveData($request, $product);
        if ($cartItem) {
            return response()->json([
                'sts' => true,
                'msg' => "Product added to wishlist successfully",
            ]);
        } else {
            return response()->json([
                'sts' => false,
                'msg' => "Failed to add product to wishlist"
            ]);
        }
    }

    public function wishlist_remove(Request $request)
    {
        $authCart =  Wishlist::find($request->pdtId);
        if ($authCart) {
            $authCart->delete();
            return response()->json([
                'sts' => true,
                'msg' => 'Item removed successfully'
            ], 200);
        } else {
            return response()->json([
                'sts' => false,
                'msg' => 'Item not found or already removed'
            ], 404);
        }
    }

}
