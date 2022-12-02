<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\V1\Service;
use App\Models\V1\Category;
use App\Models\V1\City;
use App\Models\V1\PostYourRequirement;



class PostYourRequirementController extends Controller
{
    public function postYourRequirement(Request $request){

        $rules = array(
            'name' => "required",
            'mobile' => "required",
            'email' => "required",
            'message' => "required"
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $input = $request->input();

            $insertData = array(
                "id" => uniqid(),
                "name" => $input['name'],
                "mobile" => $input['mobile'],
                "email" => $input['email'],
                "message" => $input['message']
            );
            PostYourRequirement::create($insertData);

            $response = array(
                'status' => '1',
                'message' => config('constant_api.massage.requirement_post_success')
            );
            _response($response);

        } else {
            $response = array();
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }
    }
}
