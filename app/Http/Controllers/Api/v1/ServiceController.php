<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\V1\Service;
use App\Models\V1\VendorService;

class ServiceController extends Controller
{
    /*
        action_flag: category_id, category_slug
        category_value: value
    */
    public function get_services_by_category_slug_or_id(Request $request){
        
        $rules = array(
            'action_flag' => "required",
            'category_value' => "required",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $request = $request->input();
            if(in_array($request['action_flag'], array('category_id','category_slug'))){

                $query = Service::from('service_master AS sm')
								->select(array('sm.service_id', 'sm.service_slug', 'sm.service_name'))
								->leftjoin('category_master AS cm','cm.category_id', '=', 'sm.category_id');
								$query->where('sm.status', '1');
                                if($request['action_flag'] == "category_id"){
                                    $query->where('cm.category_id', $request['category_value']);
                                } else if($request['action_flag'] == "category_slug") {
                                    $query->where('cm.category_slug', $request['category_value']);
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
        action_flag: category_id, category_slug
        category_value: value
    */
    public function get_vendor_selected_services_with_all_service_by_user_id_and_category_id(Request $request){
        
        $rules = array(
            'user_id' => "required",
            'category_id' => "required",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $request = $request->input();
            
            $vendor_service_ids = VendorService::getVendorServiceByUserIdAndCategoryId($request['user_id'],$request['category_id']);
            $vendor_service_id_array = explode(",",$vendor_service_ids->service_id);
            $category_service_data = Service::getServicesByCategoryId($request['category_id']);
            // p($category_service_data);
            if(!empty($category_service_data)){
                $i = 0;
                foreach($category_service_data as $row){
                    
                    if(in_array($row->service_id,$vendor_service_id_array)){
                        $service_data[$i]['service_id'] = $row->service_id;
                        $service_data[$i]['service_slug'] = $row->service_slug;
                        $service_data[$i]['service_name'] = $row->service_name;
                        $service_data[$i]['select_status'] = "selected";
                    } else {
                        $service_data[$i]['service_id'] = $row->service_id;
                        $service_data[$i]['service_slug'] = $row->service_slug;
                        $service_data[$i]['service_name'] = $row->service_name;
                        $service_data[$i]['select_status'] = "not_selected";
                    }
                    
                    $i++;
                }
                $response['status'] = '1';
                $response['message'] = config('constant_api.massage.data_get_successfully');
                $response['data'] = $service_data;
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
