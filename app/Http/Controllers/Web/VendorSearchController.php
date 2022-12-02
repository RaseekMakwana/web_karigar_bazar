<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Services\RestApi;
use App\Models\V1\Category;
use App\Http\Controllers\Web\Traits\MetadataTrait;

class VendorSearchController extends Controller
{

    use MetadataTrait;

    public function index(Request $request){


        
        $data['segment_one'] = $request->segment(1);
        $data['segment_two'] = $request->segment(2);

        $api_vendor_request_data = array();

        if(!empty($request->segment(4))){
            $category_data = Category::select("category_id")->where(['category_slug' => $request->segment(2)])->first();
            if($request->segment(4) == config('constant_web.custom_slug.vendor.service_normal')){
                $api_vendor_request_data = array(
                    'type' => "service",
                    'slug' => $request->segment(3),
                    'category_id' => $category_data->category_id,
                    'zone_type' => "all",
                    'zone_value' => "all"
                );
                $data['service_tag'] = config('constant_web.custom_slug.vendor.service_normal');
            }
            if($request->segment(4) == config('constant_web.custom_slug.vendor.service_state')){
    
            }
            if($request->segment(4) == config('constant_web.custom_slug.vendor.service_city')){
                
                $api_vendor_request_data = array(
                    'type' => "service",
                    'slug' => $request->segment(3),
                    'category_id' => $category_data->category_id,
                    'zone_type' => "city",
                    'zone_value' => $request->segment(1),
                );
                $data['service_tag'] = config('constant_web.custom_slug.vendor.service_city');
            }
        } else {
            $category_data = Category::select("category_id")->where(['category_slug' => $request->segment(2)])->first();
            if($request->segment(3) == config('constant_web.custom_slug.vendor.category_normal')){
                $api_vendor_request_data = array(
                    'type' => "category",
                    'slug' => $request->segment(2),
                    'category_id' => $category_data->category_id,
                    'zone_type' => "all",
                    'zone_value' => "all",
                );
                $data['service_tag'] = config('constant_web.custom_slug.vendor.service_normal');
            }
            if($request->segment(3) == config('constant_web.custom_slug.vendor.category_state')){
                // all/air-conditioner/vcn-ndywpu
            }
            if($request->segment(3) == config('constant_web.custom_slug.vendor.category_city')){
                $api_vendor_request_data = array(
                    'type' => "category",
                    'slug' => $request->segment(2),
                    'category_id' => $category_data->category_id,
                    'zone_type' => "city",
                    'zone_value' => $request->segment(1),
                );
                $data['service_tag'] = config('constant_web.custom_slug.vendor.service_city');
            }
        }
        
        $api_response = RestApi::post('get_vendors_details_by_category_service_slug',$api_vendor_request_data);
        
        $data['result_data'] = $api_response['data'];

        
        $data['metadata'] = $this->vendorSearchMetadata();

        $api_service_request_data['action_flag'] = 'category_slug';
        $api_service_request_data['category_value'] = $request->segment(2);
        return view("desktop.vendor_service.index", compact('data'));
    }
}
