<?php

namespace App\Http\Controllers\Web\VendorAccountModule;

use App\Http\Controllers\Controller;
use Session, Request;
use Jenssegers\Agent\Agent;
use App\Services\RestApi;

class VendorProjectController extends Controller
{
    public $DeviceAgent;
    public function __construct() {
        $this->DeviceAgent = new Agent;
    }
    public function index(){
        $request = Request::input();
        
        $dataBody['user_id'] = Session::get('user_id');
        $data['project_data'] = RestApi::post('vendor/project/get_vendor_project_list',$dataBody);

        if ($this->DeviceAgent->isDesktop()){
            return view("desktop.vendor_profile_modules.vendor_project.index", compact('data'));
        } else{
            return view("mobile.vendor_profile_modules.vendor_project.index", compact('data'));
        }
    }

    public function create(){
        $dataBody = array(
            'user_id' => Session::get('user_id')
        );
        $data['category_data'] = RestApi::post('category/get_categories_list_not_mapped_with_vendor_id',$dataBody);

        if ($this->DeviceAgent->isDesktop()){
            return view("desktop.vendor_profile_modules.vendor_project.create", compact('data'));
        } else{
            return view("mobile.vendor_profile_modules.vendor_project.create", compact('data'));
        }
    }

    public function store(){
        $request = Request::input();
        $dataBody = array(
            'user_id' => Session::get('user_id'),
            'category_id' => $request['category'],
            "selected_services" => !empty($request['selected_services'])? implode(",",$request['selected_services']) : "",
            "area_id" => Session::get('area_id'),
            "city_id" => Session::get('city_id'),
            "state_id" => Session::get('state_id')
        );
        // p($dataBody);
        
        $api_response = RestApi::post('vendor/project/create',$dataBody);
        if($api_response['status'] == "1"){
            return redirect("vendor/project")->with('success_message', $api_response['message']);
        }
    }

    public function edit($category_id,$category_name){
        $dataBody = array(
            'action_flag' => 'category_id',
            'category_value' => $category_id
        );
        $data['service_data'] = RestApi::post('service/get_services_by_category_slug_or_id',$dataBody);

        $dataBody = array(
            'user_id' => Session::get('user_id'),
            'category_id' => $category_id
        );
        $data['selected_service_data'] = RestApi::post('vendor/project/get_category_of_selected_services_id_by_category_id_and_user_id',$dataBody);

        $data['category_id'] = $category_id;
        $data['category_name'] = $category_name;
        
        if ($this->DeviceAgent->isDesktop()){
            return view("desktop.vendor_profile_modules.vendor_project.edit", compact('data'));
        } else{
            return view("mobile.vendor_profile_modules.vendor_project.edit", compact('data'));
        }
    }

    public function update(){
        $request = Request::input();
        $dataBody = array(
            'user_id' => Session::get('user_id'),
            'category_id' => $request['category_id'],
            "selected_services" => !empty($request['selected_services'])? implode(",",$request['selected_services']) : ""
        );
        
        $api_response = RestApi::post('vendor/project/update',$dataBody);
        if($api_response['status'] == "1"){
            return redirect("vendor/project")->with('success_message', $api_response['message']);
        }
    }

    public function delete($category_id){
        $dataBody = array(
            'user_id' => Session::get('user_id'),
            'category_id' => $category_id,
        );
        $api_response = RestApi::post('vendor/project/delete',$dataBody);
        if($api_response['status'] == "1"){
            return redirect("vendor/project")->with('success_message', $api_response['message']);
        }
    }
}
