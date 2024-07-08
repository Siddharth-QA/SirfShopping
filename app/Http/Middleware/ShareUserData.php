<?php

namespace App\Http\Middleware;

use App\Models\AuthCarts;
use App\Models\AuthProfile;
use App\Models\AuthUser;
use Closure;
use Illuminate\Support\Facades\Auth;

class ShareUserData
{
    public function handle($request, Closure $next)
    {
        $data = [];
        $currentUrl = url('/');
        $domain = AuthProfile::where('domain', $currentUrl)->first();

        if ($domain) {
            $auth = Auth::user();
            if ($auth) {
                $authEmail = $auth->email;
                $authUser = AuthUser::where('email', $authEmail)->first();
                $qty = AuthCarts::where('user_id', $authUser->id)->count();
                $data['qty'] = $qty;
            } else {
                $data['qty'] = 0; // Set default quantity to 0 if user is not authenticated
            }
            view()->share('contents', $data);
        }

        return $next($request);
    }
}
