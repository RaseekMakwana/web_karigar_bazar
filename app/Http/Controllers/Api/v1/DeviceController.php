<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\V1\Device;

class DeviceController extends Controller
{
    public function check_device_exist_by_mobile_and_uuid(Request $request){
        $rules = array(
            'mobile' => "required",
            'uuid' => "required",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){
            // p('sdfsdf');

            $input = $request->input();
            
            $check_user_device = Device::check_device_exist_by_mobile_and_uuid($input['mobile'],$input['uuid']);
            $device = "0";
            if(!empty($check_user_device)){
                $device = "1";
            } 

            $response['status'] = '1';
            $response['message'] = config('constant_api.massage.data_get_successfully');
            $response['data'] = $device;

            _response($response);
        } else {
            
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }
    }
}
