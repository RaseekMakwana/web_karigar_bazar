<?php

namespace App\Http\Controllers\Web;

use Config, Request;
use App\Services\RestApi;

class CategoryController extends Controller
{
    public function index(){
        $dataBody['location_type'] = Request::segment(1);
        $dataBody['slug'] = Request::segment(2);
        $data['category_data'] = RestApi::post('get_category_details_by_vendor_type',$dataBody);
       
        $data['segment_one'] = Request::segment(1);
        $data['segment_two'] = Request::segment(2);
        if(Request::segment(3) == Config::get('constant_web.custom_slug.category.normal')){
            $data['segment_three'] = Config::get('constant_web.custom_slug.vendor_category.normal');
        }
        if(Request::segment(3) == Config::get('constant_web.custom_slug.category.state')){
            $data['segment_three'] = Config::get('constant_web.custom_slug.vendor_category.state');
        }

        $metaData = array(
            'page_type_name' => 'category_page',
            'segment_one' => Request::segment(1),
            'segment_two' => Request::segment(2),
        );
        $data['metadata'] = RestApi::post('metadata', $metaData);
        
        return view("desktop.categories.index", compact('data'));
    }
}
