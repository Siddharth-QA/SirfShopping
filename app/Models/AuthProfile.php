<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthProfile extends Model
{
    use HasFactory;
    protected $table = 'auth_profile';

    public static function saveData($dataVal,$infoId,$authUser, $id = null)
    {
        $saveData = ($id)? AuthProfile::find($id): new AuthProfile;
        $check = AuthProfile::where('website_id', $infoId);
        if($check->where('user_id', $authUser->id)->exists()):
            return $check->first();
        endif;
        if($check->where('mobile',$dataVal->mobile)->exists()):
            return $check->first();
        endif;
        $saveData->id = rand(10000000000,999999999999);
        $saveData->website_id  = $infoId;
        $saveData->user_id  = $authUser->id;
        $saveData->mobile = $dataVal->mobile;
        $saveData->environment = 0;
        $saveData->save();
        return $saveData;
    }
}
