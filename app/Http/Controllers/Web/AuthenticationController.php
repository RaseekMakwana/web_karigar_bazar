<?php

namespace App\Http\Controllers\Web;

use Request, Session, Config;
use App\Services\RestApi;
use Jenssegers\Agent\Agent;

class AuthenticationController extends Controller
{
    public $DeviceAgent;
    public function __construct() {
        $this->DeviceAgent = new Agent;
    }

    public function login(){
        if ($this->DeviceAgent->isDesktop()){
            return view("desktop.authentication.login");
        } else {
            return view("mobile.authentication.login");
        }
        
    }

    public function logout() {
        Session::flush();
        return redirect('login');
    }

    public function login_varification(){
        $request = Request::input();
        $ApiData = array(
            'mobile_number' => $request['mobile_number'],
            'password' => md5($request['password']),
        );
        $api_response = RestApi::post('vendor_login_verification',$ApiData);
        Session::flush();

        if($api_response['status'] == '1'){
            $user_detail = $api_response['data'];
            $session_data = array(
                "login_status" => "1",
                "user_id" => $user_detail['user_id'],
                "business_name" => $user_detail['business_name'],
                "vendor_name" => $user_detail['vendor_name'],
                "mobile" => $user_detail['mobile'],
                "email" => $user_detail['email'],
                "birthdate" => date('d-m-Y', strtotime($user_detail['birthdate'])),
                "state_id" => $user_detail['state_id'],
                "state_name" => $user_detail['state_name'],
                "city_id" => $user_detail['city_id'],
                "city_name" => $user_detail['city_name'],
                "area_id" => $user_detail['area_id'],
                "area_name" => $user_detail['area_name'],
                "profile_picture" => Config::get('app.storage_url').$user_detail['profile_picture'],
            );
            Session::put($session_data);
            return redirect()->intended('vendor/dashboard');
        } else {
            return redirect("login")->with('error_message', $api_response['message']);
        }
    }
    
    public function vendor_registration(){ 
        if ($this->DeviceAgent->isDesktop()){
            return view("desktop.authentication.vendor_registration"); 
        } else {
            return view("mobile.authentication.vendor_registration");
        }
    }

    public function vendor_registration_store(){
        $request = Request::input();

        $ApiData = array(
            'business_name' => $request['business_name'],
            'vendor_name' => $request['vendor_name'],
            'mobile_no' => $request['mobile_no'],
            'password' => $request['password'],
            'occupation' => $request['occupation'],
            'state' => $request['state'],
            'city' => $request['city'],
            'area' => $request['area'],
            'pin_code' => $request['pin_code']
        );
        $api_response = RestApi::post('vendor_registration',$ApiData);
        if($api_response['status'] == "1"){
            return redirect("become-a-vendor")->with('success_message', $api_response['message']);
        }
    }
    
}
