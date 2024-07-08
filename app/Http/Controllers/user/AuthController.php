<?php

namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller;
use App\Models\AuthCarts;
use App\Models\AuthInfo;
use App\Models\AuthProfile;
use App\Models\AuthRelation;
use App\Models\AuthUser;
use App\Models\User;
use App\MsgApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        if (!Auth::user()) :
            return view('auth.index');
        endif;
        return redirect('/');
    }

    public function register()
    {
        if (!Auth::user()) :
            return view('auth.register');
        endif;
        return redirect('/');
    }

    public function reg(Request $request)
    {
        $request->validate(
            [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email',
                'password' => 'required|string|min:8',
                'confirm_password' => 'required|same:password',
                'mobile' => 'required|string',
            ],
            [
                'required' => ':attribute is required.',
                'email.unique' => 'The email has already been taken.',
                'confirm_password.same' => 'The confirmation password does not match.',
            ],
            [
                'email' => 'Email',
                'password' => 'Password',
                'first_name' => 'First Name',
                'last_name' => 'Last Name',
                'confirm_password' => 'Confirmation Password',
                'mobile' => 'Mobile Number',
            ]
        );
        
        $authUser = AuthUser::saveData($request);
        $infoId = AuthInfo::saveData($request, $authUser);
        AuthProfile::saveData($request, $infoId,$authUser);
        AuthRelation::saveData($authUser,$infoId);
        $user = User::saveData($request);
        if ($user) :
            return redirect('/auth')->with('success', 'Registration successful!');
        endif;
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                'log_email' => 'required|string|email',
                'log_password' => 'required',
            ],
            [
                'required' => ':attribute is required.',
            ],
            [
                "log_email" => 'Email',
                "log_password" => 'Password'
            ]
        );

        if (Auth::attempt(['email' => $request->log_email, 'password' => $request->log_password,'domain' => url('/')])) :
            if(Auth::user()->domain != url('/')):
                Auth::logout();
                return Redirect::back()->with('failed', 'Sorry email and password does not match.')->withInput($request->all());
            endif;
            $authUser = AuthUser::where('email', Auth::user()->email)->first();
            $request->session()->regenerate();
            $count = \Cart::getContent()->count();

            if ($count > 0):
                $data = \Cart::getContent();
                $req = [];
                foreach ($data as $item):
                    $request_parameters = [
                        "pdtId" => $item->attributes['product'],
                        "qty" => $item->quantity
                    ];
                    $req[] = $request_parameters;
                endforeach;
                foreach ($req as $request):
                    if (AuthCarts::where('user_id', $authUser->id)
                        ->where('inventory_id', $request['pdtId'])
                        ->where('cart_type', url('/'))
                        ->where('save_later', 0)
                        ->exists()):
                    update_To_db($request);
                    else :
                        insert_To_db($request);
                    endif;
                endforeach;
                \Cart::clear();
            endif;

            return Redirect::back()->with('success', "Login Successfully");
        endif;
        return Redirect::back()->with('failed', 'Sorry email and password does not match.')->withInput($request->all());
    }

    public function change_password()
    {

        $items = items();
        $user = USer::find(Auth::user()->id);
        return view('user.change_password', compact('user', 'items'));
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Logged out successfully!');
    }

    public function reset_pass(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'current_password' => 'required',
                'password' => 'required|same:con_password',
                'con_password' => 'required',
            ],
            [
                'required' => ':attribute is required.',
                'same' => 'Password and confirm password do not match.',
            ],
            [
                'current_password' => 'Current Password',
                'password' => 'Password',
                'con_password' => 'Confirm Password',
            ],
        );

        if ($validator->fails()) :
            return Redirect::back()->withErrors($validator)->withInput($request->all());
        endif;

        $user = User::find(Auth::user()->id);
        if (!Hash::check($request->current_password, $user->password)) :
            return Redirect::back()->with('failed', 'Current Password is incorrect.');
        endif;

        $user->password = Hash::make($request->password);
        $user->save();

        $authUser =  AuthUser::where('email', $user->email)->first();
        if ($authUser) :
            $authUser->password = Hash::make($request->password);
            $authUser->save();
        endif;
        return Redirect::back()->with('success', 'Password has been successfully updated.');
    }
}
