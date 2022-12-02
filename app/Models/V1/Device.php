<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $table = 'devices';
    
    public static function getDeviceByMobile($mobile){
        return Device::where("mobile", $mobile)->first();
    }
    // public static function check_device_exist_by_mobile_and_uuid($request){
    //     return Device::where(["mobile"=>$request['mobile'],"uuid"=>$request['uuid']])->count();
    // }
    
    public static function check_device_exist_by_mobile_and_uuid($mobile,$uuid){
        return Device::where(["mobile"=>$mobile, "uuid"=>$uuid])->first();
    }
}
