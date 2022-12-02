<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\V1\User;
use App\Models\V1\Vendor;

class AuthenticationController extends Controller
{

    public function checkToken(Request $request){
        $rules = array(
            'token' => "required",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $input = Request::input();
            $response = User::checkToken($input['token']);
            _response($response);

        } else {
            $response = array();
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }
    }

    

        
       
    
}
