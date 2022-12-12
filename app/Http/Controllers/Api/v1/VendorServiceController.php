<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\V1\VendorService;
use App\Models\V1\Service;

class VendorServiceController extends Controller
{
    /*
        action_flag: action_flag, category_value
        category_value: value
    */
    public function get_services_by_category_slug_or_id(Request $request){
        
        $rules = array(
            'action_flag' => "required",
            'category_value' => "required",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $input = $request->input();
            if(in_array($input['action_flag'], array('category_id','category_slug'))){

                $query = Service::from('service_master AS sm')
								->select(array('sm.service_id', 'sm.service_slug', 'sm.service_name'))
								->leftjoin('category_master AS cm','cm.category_id', '=', 'sm.category_id');
								$query->where('sm.status', '1');
                                if($input['action_flag'] == "category_id"){
                                    $query->where('cm.category_id', $input['category_value']);
                                } else if($input['action_flag'] == "category_slug") {
                                    $query->where('cm.category_slug', $input['category_value']);
                                }
                                $query->orderBy('sm.service_name','asc');
                $result_data = $query->get();

                $vendor_type_data = array();
                $i=0;
                foreach($result_data as $row){
                    $vendor_type_data[$i]['service_id'] = $row->service_id;
                    $vendor_type_data[$i]['service_slug'] = $row->service_slug;
                    $vendor_type_data[$i]['service_name'] = $row->service_name;
                    $i++;
                }
                _response($vendor_type_data);
            } else {
                $response['status'] = '0';
                $response['message'] = config('constant_api.massage.invalid_action_passed');
                _response($response);
            }

        } else {
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }

    }

    /*
        user_id: value
        category_id: value
        service_ids_collection: value
    */
    public function create_vendor_service(Request $request){
        $rules = array(
            'user_id' => "required",
            'category_id' => "required",
            'service_ids_collection' => "required",
            'state_id' => "required",
            'city_id' => "required",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $input = $request->input();
            VendorService::create_vendor_service($request);

            $response['status'] = '1';
            $response['message'] = config('constant_api.massage.date_saved_successfully');
            _response($response);
        } else {
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }
    }

    
    /*
        user_id: value
        category_id: value
        service_ids_collection: value
    */
    public function update_vendor_service(Request $request){
        $rules = array(
            'user_id' => "required",
            'category_id' => "required",
            'service_ids_collection' => "required",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $input = $request->input();
            VendorService::update_vendor_service($request);

            $response['status'] = '1';
            $response['message'] = config("constant_api.massage.data_updated_successfully");;
            _response($response);
        } else {
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }
    }

    /*
        user_id: value
        category_id: value
        service_ids_collection: value
    */
    public function delete_vendor_service(Request $request){
        $rules = array(
            'user_id' => "required",
            'category_id' => "required",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $input = $request->input();
            VendorService::delete_vendor_service($input['user_id'],$input['category_id']);

            $response['status'] = '1';
            $response['message'] = config("constant_api.massage.data_deleted_successfully");;
            _response($response);
        } else {
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }
    }

    public function get_services_not_mapped_with_vendor_id(Request $request){
        
        $response = array(); 
        $rules = array(
            'user_id' => "required",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $input = $request->input();
            $vendor_service_data = VendorService::get_services_not_mapped_with_vendor_id($input['user_id']);
            // p($vendor_service_data);

            
            if(!empty($vendor_service_data)){
                $data = array();
                foreach($vendor_service_data as $category_row){
                    $data[] = array(
                        'category_id' => $category_row->category_id,
                        'category_name' => $category_row->category_name,
                    );
                }
    
                $response['status'] = '1';
                $response['message'] = config('constant_api.massage.data_get_successfully');
                $response['data'] = $data;
                _response($response);
            } else {
                $response['status'] = '0';
                $response['message'] = config('constant_api.massage.data_not_found');
                _response($response);
            }
            

        } else {
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }
    }

}
