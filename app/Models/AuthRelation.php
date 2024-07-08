<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use app\helper;

class AuthRelation extends Model
{
    use HasFactory;
    protected $table = 'auth_relation';
    public $timestamps = false;

    public static function saveData($authUser,$infoId, $id = null)
    {
        $saveData = $id ? AuthRelation::find($id) : new AuthRelation;
        $domain = AuthProfile::where('user_id',userId())->first();
        $saveData->id = rand(105481447527,999999999999);
        $saveData->business_info_id = $domain->website_id;
        $saveData->info_id = $infoId;
        $saveData->relation = 'Supplier';
        $saveData->is_active = true;
        $saveData->parent_id = userId();
        $saveData->user_id =  $authUser->id;
        $saveData->owner_id = userId();
        $saveData->created_on = Carbon::now();
        $saveData->updated_on = Carbon::now();
        $saveData->source = 'Signup';
        $saveData->save();
        $address = AuthAddress::where('user_id', userId())->first();
        self::address_relaction($saveData,$infoId, $address, $authUser);
        return $saveData;
    }
    
    public static function address_relaction($domain,$infoId, $address, $authUser)
    {
        $newSaveData = new AuthRelation;
        $newSaveData->id = rand(105481447527,999999999999);
        $newSaveData->business_info_id = $infoId;
        $newSaveData->info_id = $domain->website_id;
        $newSaveData->relation = 'Customer';
        $newSaveData->is_active = true;
        $newSaveData->parent_id = $authUser->id;
        $newSaveData->user_id =  userId();
        $newSaveData->created_on = Carbon::now();
        $newSaveData->updated_on = Carbon::now();
        $newSaveData->primary_id = $address->id;
        $newSaveData->owner_id = $authUser->id;
        $newSaveData->source = 'Signup';
        $newSaveData->save();
    }
}    
