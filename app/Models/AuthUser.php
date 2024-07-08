<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Exists;

class AuthUser extends Model
{
    protected $table = 'auth_user';
    public $timestamps = false;

        use HasFactory;

        public function address()
        {
            return $this->hasOne(AuthAddress::class, 'user_id');
        }
        public function info()
        {
            return $this->hasOne(AuthInfo::class, 'user_id');
        }
        public function bank()
        {
            return $this->hasOne(BankAccount::class, 'user_id');
        }

        public static function saveData($dataVal, $id = null)
        {
            $saveData = ($id)? AuthUser::find($id): new AuthUser;
            $check = AuthUser::where('email',$dataVal->email);
            if($check->exists()):
                return $check->first();
            endif;
            $saveData->first_name = $dataVal->first_name;
            $saveData->last_name = $dataVal->last_name;
            $saveData->email = $dataVal->email;
            $saveData->username  = $dataVal->email;
            $saveData->is_superuser = 0;
            $saveData->is_staff = 0;
            $saveData->is_active = 1;
            $saveData->last_login = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s.u');
            $saveData->date_joined = Carbon::now('Asia/Kolkata')->format('Y-m-d H:i:s.u');
            $saveData->password = Hash::make($dataVal->password);
            $saveData->save();
            return $saveData;
        }
}
