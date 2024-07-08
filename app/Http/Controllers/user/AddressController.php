<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\AuthAddress;
use App\Models\AuthCountry;
use App\Models\AuthInfo;
use App\Models\AuthUser;
use App\MsgApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class AddressController extends Controller
{
    public function index()
    {
        $items = items();
        $auth = auth()->user();
        $authUser = AuthUser::where('email', $auth->email)->first();
        $authInfo = AuthInfo::where('user_id', userId())->first();
        $adds = AuthAddress::where('user_id', $authUser->id)
            ->where('info_id', $authInfo->id)
            ->leftJoin('auth_state', 'auth_address.state_id', '=', 'auth_state.id')
            ->select('auth_address.*', 'auth_state.title as state')->get();
        return view('user.address.index', compact('adds', 'items'));
    }

    public function create()
    {
        $items = items();
        $id = null;
        $adds =  AuthCountry::get();
        return view('user.address.create', compact('adds', 'id', 'items'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'address' => MsgApp::REQ,
                'mobile' => MsgApp::MOBILE,
                'label' => MsgApp::REQ,
                'country' => MsgApp::REQ,
                'state' => MsgApp::REQ,
                'city' => MsgApp::REQ,
                'pincode' => MsgApp::REQ,
            ],
            [
                'required' => ':attribute is required.',
                'regex' => ':attribute is invalid.',
            ],
        );
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput($request->all());
        }
        $auth = auth()->user();
        $authUser = AuthUser::where('email', $auth->email)->first();
        $authInfo = AuthInfo::where('user_id', userId())->first();
        AuthAddress::saveData($request, $authInfo->id, $authUser->id);
        return redirect('/user/address')->with('success', MsgApp::SUCCESS_ADDED);
    }

    public function add_remove(Request $request)
    {
        $address =  AuthAddress::find($request->add_id);
        if ($address) {
            $address->delete();
            return response()->json([
                'sts' => true,
                'msg' => 'Address removed successfully'
            ], 200);
        } else {
            return response()->json([
                'sts' => false,
                'msg' => 'Address not found or already removed'
            ], 404);
        }
    }

    public function edit($id)
    {
        $id = decodeRequestData($id);
        $items = items();
        $data =  AuthAddress::find($id);
        $adds =  AuthCountry::get();
        return view('user.address.create', compact('adds', 'data', 'id', 'items'));
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'address' => MsgApp::REQ,
                'mobile' => MsgApp::MOBILE,
                'label' => MsgApp::REQ,
                'country' => MsgApp::REQ,
                'state' => MsgApp::REQ,
                'city' => MsgApp::REQ,
                'pincode' => MsgApp::REQ,
            ],
            [
                'required' => ':attribute is required.',
                'regex' => ':attribute is invalid.',
            ],
        );
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput($request->all());
        }
        $auth = auth()->user();
        $authUser = AuthUser::where('email', $auth->email)->first();
        $authInfo = AuthInfo::where('user_id', userId())->first();
        AuthAddress::saveData($request, $authInfo->id, $authUser->id, $id);
        return redirect('/user/address')->with('success', MsgApp::SUCCESS_UPD);
    }
    //check-out
    public function add_edit(Request $request)
    {
        $data =  AuthAddress::find($request->addId);
        return compact('data');
    }

    public function address_update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'address' => MsgApp::REQ,
                'mobile' => MsgApp::MOBILE,
                'label' => MsgApp::REQ,
                'country' => MsgApp::REQ,
                'state' => MsgApp::REQ,
                'city' => MsgApp::REQ,
                'pincode' => MsgApp::REQ,
            ],
            [
                'required' => ':attribute is required.',
                'regex' => ':attribute is invalid.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'sts' => false,
                'errors' => $validator->errors()->toArray()
            ], 200);
        }

        $auth = auth()->user();
        $authUser = AuthUser::where('email', $auth->email)->first();
        $authInfo = AuthInfo::where('user_id', userId())->first();
        AuthAddress::saveData($request, $authInfo->id, $authUser->id, $request->id);

        $adds = AuthAddress::where('user_id', $authUser->id)
            ->where('info_id', $authInfo->id)
            ->leftJoin('auth_state', 'auth_address.state_id', '=', 'auth_state.id')
            ->select('auth_address.*', 'auth_state.title as state')->get();
        $html = view('user.ajax.checkoutAddress', compact('adds'))->render();

        return response()->json([
            'sts' => true,
            'msg' => ($request->id != '') ? MsgApp::SUCCESS_UPD : MsgApp::SUCCESS_ADDED,
            'data' => $adds,
            'first_name' => $auth->first_name,
            'last_name' => $auth->last_name,
            'html' => $html,
        ]);
    }

    public function address_status(Request $request){

        $authUser = AuthUser::where('email', Auth::user()->email)->first();
        $authInfo = AuthInfo::where('user_id', userId())->first();

        $adds = AuthAddress::where('user_id', $authUser->id)
            ->where('info_id', $authInfo->id)
            ->leftJoin('auth_state', 'auth_address.state_id', '=', 'auth_state.id')
            ->select('auth_address.*', 'auth_state.title as state')->get();
            $count =AuthAddress::where('user_id', $authUser->id)->where('info_id', $authInfo->id)->count();
        $html = view('user.ajax.checkoutShippingAddress', compact('adds'))->render();

        return response()->json([
            'sts' => true,
            'html' => $html,
            'count' => $count,
        ]);
    }
    
}
