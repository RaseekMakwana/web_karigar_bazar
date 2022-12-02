<?php

namespace App\Http\Controllers\Web;

use App\Services\RestApi;
use Illuminate\Http\Request;

class PostYourRequirementController extends Controller
{
    public function index(){
        return view('desktop.post_your_requirement.index');
    }

    public function store(Request $request){
        $input = $request->input();

        $ApiData = array(
            'name' => $input['name'],
            'mobile' => $input['mobile'],
            'email' => $input['email'],
            'message' => $input['message'],
        );
        $api_response = RestApi::post('post-your-requirement',$ApiData);
        if($api_response['status'] == "1"){
            return redirect("post-your-requirement")->with('success_message', $api_response['message']);
        }
    }
}
