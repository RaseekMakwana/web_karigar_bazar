<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\V1\User;
use App\Models\V1\Vendor;
use App\Models\V1\Device;
use App\Models\V1\UserLoginLog;

class UserController extends Controller
{

    public function otp_verification(Request $request){

        $rules = array(
            'type' => "required",
            'mobile_number' => "required",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $input = $request->input();
            if($input['type'] == "send"){
                $otp_number = mt_rand(111111, 999999);
                $url = "https://storage.karigarbazar.com/sms/index.php";
                $postData = array(
                    "mobile_number" => $input['mobile_number'],
                    "message_body" => "Your OTP is ".$otp_number." Login - Karigar Bazar (https://karigarbazar.com)",
                );
                curl($url, $postData);

                $response['status'] = '1';
                $response['message'] = config('constant_api.massage.data_get_successfully');
                $response['data'] = $otp_number;

                _response($response);
            }

        } else {
            $response = array();
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }

    }

    public function user_registration(Request $request){
        $rules = array(
            'user_name' => "required",
            'mobile' => "required",
            'uuid' => "required",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $input = $request->input();

            $checkDevice = Device::check_device_exist_by_mobile_and_uuid($input['mobile'], $input['uuid']);
            if(empty($checkDevice)){
                $user_detail = User::getUserByMobile($input['mobile']);
                if(empty($user_detail)){
                    $user_id = md5(time().$input['mobile']);
                    $user = new User();
                    $user->user_id = $user_id;
                    $user->name = $input['user_name'];
                    $user->mobile = $input['mobile'];
                    $user->user_type = "customer";
                    $user->save();

                    $device = new Device();
                    $device->user_id = $user_id;
                    $device->mobile = $input['mobile'];
                    $device->token = User::get_token();
                    $device->uuid = $input['uuid'];
                    $device->save();
                } else {
                    $updateData = array(
                        "uuid" => $input['uuid'],
                        "token" => User::get_token()
                    );
                    Device::where(["mobile" => $input['mobile']])->update($updateData);
                }
                $response['status'] = '1';
                $response['message'] = config('constant_api.massage.date_saved_successfully');
                _response($response);
            }
        } else {
            $response = array();
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }
    }

    /**
     * API: Login Success
     * Request: mobile, uuid
     * Return:
     *         201: Login Faild.
     *         202: 
     * 
     * 
     */

    public function login_success(Request $request){
        $rules = array(
            'mobile' => "required",
            'uuid' => "required",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){
            $input = $request->input();

            $user_info = User::getActiveUserByMobile($input['mobile']);
            if(!empty($user_info)){
                // p($user_active);

                // $device_info = Device::getDeviceByMobileAndUUID($input['mobile'],$input['uuid']);
                // if(!empty($device_info)){
    
                    $user_token = Str::random(60);
                    $updateData = array(
                        "token" => $user_token
                    );
                    Device::where(['mobile' => $input['mobile'], "uuid" => $input['uuid']])->update($updateData);

                    $createData = [
                        "user_id" => $user_info->user_id,
                        "latitude" => $user_info->latitude,
                        "longitude" => $user_info->longitude
                    ];
                    UserLoginLog::create($createData);

                    // p($device_info);
                    // $user_info = User::getUserByUserId($user_info->user_id);
                    // p($user_info);
                    // $user_detail = array();
                    // if(!empty($user_info)){

                    $user_detail = array(
                        "token" =>  $user_token,
                        "user_id" => $user_info->user_id,
                        "user_name" => $user_info->name,
                        "mobile" => $user_info->mobile,
                        "user_type" => $user_info->user_type,
                        "profile_picture" => (!empty($user_info->profile_picture))? config('app.storage_url').$user_info->profile_picture : "",
                        "uuid" => $input['uuid'],
                    );

                    $vendor_info = Vendor::getVendorDetailByUserId($user_info->user_id);
                    $vendor_detail = array();
                    if($user_info->user_type == "Vendor"){
                        $vendor_detail = array(
                            "business_name" => $vendor_info->business_name,
                            "state_id" => $vendor_info->state_id,
                            "state_name" => $vendor_info->state_name,
                            "city_id" => $vendor_info->city_id,
                            "city_name" => $vendor_info->city_name,
                        );
                    }
        
                    $response['status'] = '1';
                    $response['message'] = config('constant_api.massage.data_get_successfully');
                    $response['data']['user_detail'] = $user_detail;
                    $response['data']['vendor_detail'] = $vendor_detail;

                    _response($response);

                    // } else {
                    //     $response['status'] = '0';
                    //     $response['message'] = config("constant_api.massage.login.user_detail_not_found");
                    //     _response($response);
                    // }
                    
                // } else {
                //     $response['status'] = '202';
                //     $response['message'] = config("constant_api.massage.login.device_is_not_detected");
                //     _response($response);
                // }
            } else {
                $response['status'] = '201';
                $response['message'] = config("constant_api.massage.login.account_is_not_activated");
                _response($response);
            }
            

        } else {
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }
    }

    public function getUserByUserId(Request $request){
        $rules = array(
            'user_id' => "required"
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $input = $request->input();
            $user_info = User::getUserByUserId($input['user_id']);

            $data = array(
                "user_name" => $user_info->name,
                "email" => (!empty($user_info->email))? $user_info->email : "" ,
                "birth_date" => (!empty($user_info->birth_date))? $user_info->birth_date : ""
            );

            $response['status'] = '1';
            $response['message'] = config('constant_api.massage.data_get_successfully');
            $response['data'] = $data;
            _response($response);

        } else {
            $response = array();
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }
    }

    public function update_user_profile_detail(Request $request){
        $rules = array(
            'user_id' => "required",
            'user_name' => "required",
            'birth_date' => "required"
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $input = $request->input();
            User::update_user_profile_detail($request);

            $response['status'] = '1';
            $response['message'] = config('constant_api.massage.data_updated_successfully');
            _response($response);

        } else {
            $response = array();
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }
    }

    public function testing_image_upload(Request $request){
        $rules = array(
            'upload_file' => "required|mimes:jpg,png,jpeg",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){
            $file = $request->file('upload_file');
            // p($file);
            $input = $request->input();
            $upload_response = upload_document($file,"test");
            
            $response['status'] = '1';
            $response['message'] = config('constant_api.massage.data_updated_successfully');
            $response['data'] = config('app.storage_url').$upload_response;
            _response($response);
        } else {
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }
    }
    
    public function store_user_profile_picture(Request $request){
        $rules = array(
            'upload_file' => "required|mimes:jpg,png,jpeg",
            'user_id' => "required",
            'destination' => "required"
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){
            $file = $request->file('upload_file');
            $input = $request->input();
            $upload_response = upload_document($file,"profile_picture");

            // $vendor_details = DB::table('vendor_master')->select('profile_picture')->where(['user_id'=> ])->first();
            $user_profile_picture = User::getAttributesByUserId(["profile_picture"],$input['user_id']);
            if(!empty($user_profile_picture->profile_picture)){
                $path = config('app.storage_path').$user_profile_picture->profile_picture;
                unlink($path);
            }

            $updateData = array(
                "profile_picture" => $upload_response
            );
            User::where("user_id", $input['user_id'])->update($updateData);
            
            $response['status'] = '1';
            $response['message'] = config('constant_api.massage.data_updated_successfully');
            $response['data'] = config('app.storage_url').$upload_response;
            _response($response);
        } else {
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }

    }
}
