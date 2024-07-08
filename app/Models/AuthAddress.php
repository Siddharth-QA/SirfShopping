<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthAddress extends Model
{
    use HasFactory;
    protected $table = 'auth_address';

    public static function saveData($dataVal, $info_id,$user_id,  $id = null)
    {
        $saveData = ($id)? AuthAddress::find($id): new AuthAddress;
        if(!$id):
            $saveData->id = rand(1000000000, 99999999999);
        endif; 
        $saveData->address = $dataVal->address;
        $saveData->label = $dataVal->label;
        $saveData->default = 1;
        $saveData->country_id = $dataVal->country;
        $saveData->state_id = $dataVal->state;
        $saveData->city = $dataVal->city;
        $saveData->pin_code = $dataVal->pincode;
        $saveData->mobile = $dataVal->mobile;
        $saveData->info_id = $info_id;
        $saveData->user_id = $user_id;
        $saveData->save();
    }
}
