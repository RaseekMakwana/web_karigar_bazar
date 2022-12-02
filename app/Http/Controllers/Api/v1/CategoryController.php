<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\V1\Category;

class CategoryController extends Controller
{
    public function get_category_details_by_vendor_type(Request $request){
        
        $rules = array(
            'location_type' => "required|max:30",
            'slug' => "required|max:30"
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $input = $request->input();
            
            $result_data = Category::from('category_master AS cm')
								->select(array('cm.category_id', 'cm.category_slug', 'cm.category_name', 'cm.picture_thumb'))
								->leftjoin('vendor_type_master AS vtm','vtm.vendor_type_id', '=', 'cm.vendor_type_id')
								->where(['vtm.vendor_type_slug'=>$input['slug'], 'cm.status'=>'1'])
                                ->orderBy('cm.category_name','asc')
								->get();

            $vendor_type_data = array();
            $i=0;
            foreach($result_data as $row){
                $vendor_type_data[$i]['category_id'] = $row->category_id;
                $vendor_type_data[$i]['category_slug'] = $row->category_slug;
                $vendor_type_data[$i]['category_name'] = $row->category_name;
                $vendor_type_data[$i]['picture_thumb'] = config('app.storage_url').$row->picture_thumb;
                $i++;
            }
            _response($vendor_type_data);

        } else {
            $response = array();
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }

    }

    // public function get_categories_list_not_mapped_with_vendor_id(){
        
    //     $response = array(); 
    //     $rules = array(
    //         'user_id' => "required",
    //     );
    //     $validator = Validator::make(Request::all(),$rules);
    //     if(!$validator->fails()){

    //         $request = Request::input();
    //         $vendor_service_data = Category::get_categories_list_not_mapped_with_vendor_id($request['user_id']);
    //         // p($vendor_service_data);

            
    //         if(!empty($vendor_service_data)){
    //             $data = array();
    //             foreach($vendor_service_data as $category_row){
    //                 $data[] = array(
    //                     'category_id' => $category_row->category_id,
    //                     'category_name' => $category_row->category_name,
    //                 );
    //             }
    
    //             $response['status'] = '1';
    //             $response['message'] = config('constant_api.massage.data_get_successfully');
    //             $response['data'] = $data;
    //             _response($response);
    //         } else {
    //             $response['status'] = '0';
    //             $response['message'] = config('constant_api.massage.data_not_found');
    //             _response($response);
    //         }
            

    //     } else {
    //         $response['status'] = '0';
    //         $response['message'] = $validator->errors();
    //         _response($response);
    //     }
    // }
}
