<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\AuthUser;
use App\Models\User;
use App\MsgApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $items = items();
        $user = Auth::user();
        return view('user.profile.index', compact('user','items'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => MsgApp::VAL_NAME,
                'last_name' =>  MsgApp::VAL_NAME,
                'email' =>  MsgApp::EMAIL,
            ],
            [
                'required' => ':attribute is required.',
            ],
            [
                'first_name' => 'First Name',
                'email' => 'Email',
                'last_name' => 'Last Name',
            ]
        );

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput($request->all());
        }

        $user = User::find(Auth::user()->id);
        $authUser =  AuthUser::where('email', $user->email)->first();
        if ($authUser) {
            $authUser->first_name = $request->first_name;
            $authUser->last_name = $request->last_name;
            $authUser->username = $request->email;
            $authUser->email = $request->email;
            $authUser->save();
        }
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->save();

        return Redirect::back()->with('success', 'Profile has been successfully updated.');
    }
}
