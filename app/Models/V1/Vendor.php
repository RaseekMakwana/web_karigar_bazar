<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $table = 'vendor_master';

    public static function getVendorDetailByMobile($mobile_number){
        return Vendor::where("mobile",$mobile_number)->first();
    }

    public static function getVendorDetailByUserId($user_id){
        $attributes = array(
            "vm.business_name",
            "vm.state_id",
            "sm.state_name",
            "vm.city_id",
            "cm.city_name",
        );
        return Vendor::select($attributes)
                    ->from("vendor_master as vm")
                    ->where("user_id",$user_id)
                    ->leftJoin("state_master as sm","sm.state_id","=","vm.state_id")
                    ->leftJoin("city_master as cm","cm.city_id","=","vm.city_id")
                    ->first();
    }

    public static function get_business_profile_detail($request){
        return Vendor::from("vendor_master as vm")
                    ->leftJoin("state_master as sm","sm.state_id","=","vm.state_id")
                    ->leftJoin("city_master as cm","cm.city_id","=","vm.city_id")
                    ->where("user_id",$request['user_id'])->first();
    }

    public static function update_business_profile_detail($request){
        $updateData = array(
            "business_name" => $request['business_name'],
            "state_id" => $request['state_id'],
            "city_id" => $request['city_id'],
            // "area_id" => $request['area_id'],
            "pin_code" => $request['pin_code'],
        );
        Vendor::where("user_id", $request['user_id'])->update($updateData);


        $updateData = array(
            "state_id" => $request['state_id'],
            "city_id" => $request['city_id'],
        );
        VendorService::where("user_id", $request['user_id'])->update($updateData);
    }
}
