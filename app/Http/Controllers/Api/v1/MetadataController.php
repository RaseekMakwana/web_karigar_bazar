<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MetadataController extends Controller
{
    public function index(Request $request) {
        $rules = array(
            'page_type_name' => "required"
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $input = $request->input();
                if($input['page_type_name'] == "home_page"){
                    
                    
                    
                } else if($input['page_type_name'] == "category_page"){

                    $response['title'] = "Top 100 ".remove_dash_first_upperletter($input['segment_two'])." in ".remove_dash_first_upperletter($input['segment_one'])." - KarigarBazar";
                    $response['description'] = "Top 100 ".remove_dash_first_upperletter($input['segment_two'])." in ".remove_dash_first_upperletter($input['segment_one'])." - KarigarBazar. List of Categories of karigar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar services, tils service";
                    $response['keyword'] = "karigar bazar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar services, tils service";

                } else if($input['page_type_name'] == "category_vendor_page"){

                    $response['title'] = "Top 100 ".remove_dash_first_upperletter($input['segment_two'])." in ".remove_dash_first_upperletter($input['segment_one'])." - KarigarBazar";
                    $response['description'] = "Top 100 ".remove_dash_first_upperletter($input['segment_two'])." in ".remove_dash_first_upperletter($input['segment_one'])." - KarigarBazar. List of Categories of karigar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar services, tils service";
                    $response['keyword'] = "karigarbazar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar services, tils service";

                } else if($input['page_type_name'] == "service_vendor_page"){

                    $response['title'] = "Top 100 ".remove_dash_first_upperletter($input['segment_two'])." in ".remove_dash_first_upperletter($input['segment_one'])." - ".remove_dash_first_upperletter($input['segment_three'])." - KarigarBazar";
                    $response['description'] = "Top 100 ".remove_dash_first_upperletter($input['segment_two'])." in ".remove_dash_first_upperletter($input['segment_one'])." - ".remove_dash_first_upperletter($input['segment_three'])." - KarigarBazar. List of Categories of karigar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar services, tils service";
                    $response['keyword'] = "karigarbazar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar services, tils service";

                }            
            
            _response($response);
        } else {
            $response = array();
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }
    }
}
