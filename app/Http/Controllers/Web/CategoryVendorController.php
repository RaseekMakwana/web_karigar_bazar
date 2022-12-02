<?php

namespace App\Http\Controllers\Web;

use Config, Request;
use App\Services\RestApi;

class CategoryVendorController extends Controller
{
    public function index(){

        if(Request::segment(3) == Config::get('constant_web.custom_slug.vendor_category.normal')){
            $data['segment_one'] = Request::segment(1);
            $data['segment_two'] = Request::segment(2);
            $data['segment_three'] = Config::get('constant_web.custom_slug.vendor_service.normal');

            $api_vendor_request_data = array(
                'category_slug' => Request::segment(2),
                'action_type' => 'all',
                'action_value' => 'all',
            );
        }
        if(Request::segment(3) == Config::get('constant_web.custom_slug.vendor_category.state')){
            $data['segment_one'] = Request::segment(1);
            $data['segment_two'] = Request::segment(2);
            $data['segment_three'] =  Config::get('constant_web.custom_slug.vendor_service.state');
            
            $api_vendor_request_data = array(
                'category_slug' => Request::segment(2),
                'action_type' => 'state',
                'action_value' => Request::segment(1),
            );
        }
        $data['vendor_data'] = RestApi::post('get_vendors_details_by_category_slug',$api_vendor_request_data);

        $metaData = array(
            'page_type_name' => 'category_vendor_page',
            'segment_one' => Request::segment(1),
            'segment_two' => Request::segment(2),
        );
        $data['metadata'] = RestApi::post('metadata', $metaData);


        $api_service_request_data['action_flag'] = 'category_slug';
        $api_service_request_data['category_value'] = Request::segment(2);
        $data['service_data'] = RestApi::post('service/get_services_by_category_slug_or_id',$api_service_request_data);
        
        

        return view("desktop.category_vendor.index", compact('data'));
    }
}
