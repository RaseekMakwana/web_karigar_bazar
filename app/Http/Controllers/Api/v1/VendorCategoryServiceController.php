<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\V1\Service;
use App\Models\V1\Category;
use App\Models\V1\City;
use App\Models\V1\VendorService;

class VendorCategoryServiceController extends Controller
{
    public function get_vendor_type_with_category_details(Request $request){
        
        $rules = array(
            // 'location' => "required|max:30"
            // 'location_value'  => "required|max:30",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

                $result_data = Category::Table('category_master as cm')
								->select(array('vtm.vendor_type_id', 'vtm.vendor_type_slug', 'vtm.vendor_type_name', 'cm.category_id', 'cm.category_slug', 'cm.category_name', 'cm.picture_thumb'))
								->leftjoin('vendor_type_master as vtm','vtm.vendor_type_id', '=', 'cm.vendor_type_id')
								->where(['cm.status'=>1, 'vtm.status'=>1])
                                ->orderBy('vtm.order_by','asc')
                                ->orderBy('cm.category_name', 'ASC')
								->get();
            
                $vendor_type_data = array();

                $i=-1;
                $j=-1;
                $division = "";
                foreach($result_data as $row){
                    $i++;
                    if($row->vendor_type_name != $division){
                        $j++;
                        $division = $row->vendor_type_name;
                        $vendor_type_data[$j]['vendor_type_id'] = $row->vendor_type_id;
                        $vendor_type_data[$j]['vendor_type_slug'] = $row->vendor_type_slug;
                        $vendor_type_data[$j]['vendor_type_name'] = $row->vendor_type_name;
                    }
                    if($row->vendor_type_name == $division){
                        $vendor_type_data[$j]['category'][$i]['category_id'] = $row->category_id;
                        $vendor_type_data[$j]['category'][$i]['category_slug'] = $row->category_slug;
                        $vendor_type_data[$j]['category'][$i]['category_name'] = $row->category_name;
                        $vendor_type_data[$j]['category'][$i]['picture_thumb'] = config('app.storage_url').$row->picture_thumb;
                    }
                }
                _response($vendor_type_data);

        } else {
            $response = array();
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }

    }


    public function get_vendors_details_by_category_service_slug(Request $request){
        

        $rules = array(
            'type' => "required",
            'slug' => "required",
            'category_id' => "required",
            'zone_type' => "required",
            'zone_value' => "required",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $input = $request->input();

            $result_data = VendorService::get_vendors_by_category_service_zone($input);

            // select `vm`.`vendor_name`, `vm`.`mobile`, `cim`.`city_name`, `cm`.`category_id` from `vendor_service_master` as `vsm` left join `service_master` as `sm` on find_in_set(sm.service_id, vsm.service_id) left join `category_master` as `cm` on `cm`.`category_id` = `vsm`.`category_id` left join `vendor_master` as `vm` on `vm`.`user_id` = `vsm`.`user_id` left join `state_master` as `stm` on `stm`.`state_id` = `vsm`.`state_id` left join `city_master` as `cim` on `cim`.`city_id` = `vsm`.`city_id` where vsm.status = '1' AND cm.status = '1' AND cim.status = '1'  AND vsm.city_id IN (SELECT city_id FROM (SELECT city_id, latitude, longitude, (7000*ACOS(COS(RADIANS(23.022505)) * COS(RADIANS(latitude)) * COS(RADIANS(longitude) - RADIANS(72.5713621)) + SIN(RADIANS(23.022505))* SIN(RADIANS(latitude)))) AS distance FROM city_master HAVING distance < 100) a) and sm.service_slug = 'ac-installation'

            $service_result = Service::getServicesByCategoryId($input['category_id']);
            $service_data = array();
            if(!empty($service_result)){
                foreach($service_result as $row){
                    $service_data[] = array(
                        'service_id' => $row->service_id,
                        'service_slug' => $row->service_slug,
                        'service_name' => $row->service_name,
                        'category_id' => $row->category_id,
                    );
                }
            }

            $vendor_data = array();
            if($result_data->isNotEmpty()){
                foreach($result_data as $row){
                    $vendor_data[] = array(
                        'vendor_name' => $row->name,
                        'mobile' => $row->mobile,
                        'city_name' => $row->city_name,
                        'area' => $row->area,
                    );
                }
            } 

            $response['status'] = '1';
            $response['message'] = config('constant_api.massage.data_get_successfully');
            $response['data']['vendor_data'] = $vendor_data;
            $response['data']['service_data'] = $service_data;
            _response($response);
            

        } else {
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }
    }
}
