<?php

namespace App\Http\Controllers\Web\VendorAccountModule;

use App\Http\Controllers\Controller;
use Request, Session, Redirect;
use Jenssegers\Agent\Agent;
use App\Services\RestApi;

class VendorProfileController extends Controller
{
    public $DeviceAgent;
    public function __construct() {
        $this->DeviceAgent = new Agent;
    }
    public function index(){

        $dataBody['user_id'] = Session::get('user_id');
        $data['vandor_detail'] = RestApi::post('vendor/get_vendor_details_by_vendor_id',$dataBody);

        $data['state_data'] = RestApi::get('get_states');

        $dataBody['state_id'] = Session::get('state_id');
        $data['city_data'] = RestApi::post('get_cities_by_state_id',$dataBody);

        $dataBody['city_id'] = Session::get('city_id');
        $data['area_data'] = RestApi::post('get_areas_by_city_id',$dataBody);
        
        if ($this->DeviceAgent->isDesktop()){
            return view("desktop.vendor_profile_modules.vendor_profile.index", compact('data'));
        } else{
            return view("mobile.vendor_profile_modules.vendor_profile.index", compact('data'));
        }
    }

    public function update(){
        $request = Request::input();

        $birthdate = $request['birthdate_day']."-".$request['birthdate_month']."-".$request['birthdate_year'];

        $dataBody = array(
            'user_id' => Session::get('user_id'),
            'business_name' => $request['business_name'],
            'vendor_name' => $request['vendor_name'],
            'email' => $request['email'],
            'birthdate' => $birthdate,
            'state_id' => $request['state'],
            'city_id' => $request['city'],
            'area_id' => $request['area'],
        );
        $submit_response = RestApi::post('vendor/post_update_vendor_profile_details',$dataBody);


        $dataBody['user_id'] = Session::get('user_id');
        $vandor_detail = RestApi::post('vendor/get_vendor_details_by_vendor_id',$dataBody);

        $session_data = array(
            "business_name" => $request['business_name'],
            "vendor_name" => $request['vendor_name'],
            "email" => $request['email'],
            "birthdate" => $birthdate,
            "state_id" => $request['state'],
            "state_name" => $vandor_detail['state_name'],
            "city_id" => $request['city'],
            "city_name" => $vandor_detail['city_name'],
            "area_id" => $request['area'],
            "area_name" => $vandor_detail['area_name'],
        );
        Session::put($session_data);

        return redirect("vendor/profile")->with('success_message', $submit_response['message']);
    }

    public function set_vendor_picture_session($image_url){
        $session_data = array(
            "profile_picture" => base64_decode($image_url),
        );
        Session::put($session_data);
        return Redirect::back();
    }
}
