<?php

namespace App\Models\V1;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class User extends Model
{
    use HasFactory;

    protected $table = 'user_master';

    public static function checkToken($token){
        return User::where('token', $token)->count();
    }

    public static function getUserByUserId($user_id){
        return User::where('user_id', '=', $user_id)->first();
    }

    public static function get_token(){
        return Str::random(60);
    }

    public static function getUserByMobile($mobile){
        return User::where('mobile', '=', $mobile)->first();
    }

    public static function getUserByUserIdAndMobile($userId, $mobile){
        return User::where(["user_id"=>$userId, "mobile"=>$mobile])->first();
    }

    public static function getVendorLoginDetail($mobile){
        return User::from("user_master as lm")
                ->select("lm.token","lm.user_id","lm.name","lm.mobile","lm.user_type","vm.business_name","vm.email","vm.birthdate","vm.state_id","sm.state_name","vm.city_id","cm.city_name","vm.area_id","am.area_name")
                ->where("lm.mobile",$mobile)
                ->leftJoin("vendor_master as vm","vm.user_id","=","lm.user_id")
                ->leftJoin("state_master as sm","sm.state_id","=","vm.state_id")
                ->leftJoin("city_master as cm","cm.city_id","=","vm.city_id")
                ->leftJoin("area_master as am","am.area_id","=","vm.area_id")
                ->first();
    }

    public static function getAttributesByUserId($attribute, $user_id){
        return User::select($attribute)->where("user_id",$user_id)->first();
    }

    public static function update_user_profile_detail($request){
        $updateData = array(
            "name" => $request['user_name'],
            "email" => $request['email'],
            "birth_date" => $request['birth_date']
        );
        User::where("user_id", $request['user_id'])->update($updateData);
    }
    
    /**
     * API: Check User Is Active
     * Request: Mobile
     * Return: 1,0 
     */
    public static function getActiveUserByMobile($mobile){
        return User::where(["mobile"=>$mobile, "status"=>"1"])->first();
    }
}
