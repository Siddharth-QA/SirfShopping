<?php

namespace App\Http\Controllers;

use App\Models\AuthState;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function get_state(Request $request){

        $country_id = $request->input('country_id');
        $countries = AuthState::where('country_id', $country_id)->get();

        return response()->json(['countries' => $countries]);
    }
}
