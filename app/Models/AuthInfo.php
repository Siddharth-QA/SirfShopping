<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthInfo extends Model
{
    use HasFactory;
    protected $table = 'auth_info';

    public function address()
    {
        return $this->hasOne(AuthAddress::class, 'info_id');
    }
    
    public static function saveData($dataVal,$authUser, $id = null)
    {
        $saveData = ($id)? AuthInfo::find($id): new AuthInfo;
        $check = AuthInfo::where('email',$dataVal->email);
        if($check->exists()):
            return $check->first()->id;
        endif;
        $id = rand(105481447527,999999999999);
        $saveData->id = $id;
        $saveData->user_id  = $authUser->id;
        $saveData->mobile = $dataVal->mobile;
        $saveData->email = $dataVal->email;
        $saveData->email = $dataVal->email;
        $saveData->gst_sts  = 0;
        $saveData->credit_day  = 0;
        $saveData->credit_amt  = 0;
        $saveData->sez = 0;
        $saveData->opening_bal = 0;
        $saveData->term_condition = 'Na';
        $saveData->is_default = true;
        $saveData->save();
        return $id;
    }
}
