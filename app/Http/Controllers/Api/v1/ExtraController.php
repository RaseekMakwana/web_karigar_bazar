<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\V1\Service;
use App\Models\V1\Category;
use App\Models\V1\City;
use App\Models\V1\PostYourRequirement;

class ExtraController extends Controller
{
    public function search_bar_cities(Request $request){
        $input = $request->input();
        $data = City::select('city_name','city_slug')
                    ->where("city_name","like", $input['term']."%")
                    ->limit(10)
                    ->get();
        $response = array();
        foreach($data as $row){
            $response[] = array(
                "value" => $row->city_slug,
                "label" => $row->city_name
            );
        }
        return $response;
    }

    public function search_bar_services(Request $request){
        $input = $request->input();
        $service_data = Service::from("service_master as sm")
                            ->select("sm.service_name","sm.service_slug","cm.category_id","cm.category_slug")
                            ->where('service_name', 'like', $input['term'] . '%')
                            ->leftJoin("category_master as cm","cm.category_id","=","sm.category_id")
                            ->get();
        $category_data = Category::select("category_id","category_name","category_slug")
                            ->where('category_name', 'like', $input['term'] . '%')
                            ->get();

        $array_collect = array();
        $is_data = 1;
        if(!empty($service_data)){
            foreach($service_data as $row){
                $array_collect[] = array(
                    "value" => $row->service_slug,
                    "label" => $row->service_name,
                    "category_id" => $row->category_id,
                    "category_slug" => $row->category_slug,
                    "type" => "service"
                );
            }
        } else {
            $is_data = 0;
        }
        
        if(!empty($category_data)){
            foreach($category_data as $row){
                $array_collect[] = array(
                    "value" => $row->category_slug,
                    "label" => $row->category_name,
                    "category_id" => $row->category_id,
                    "type" => "category"
                );
            }
        } else {
            $is_data = 0;
        }
        
        if($is_data == 1){
            $sort_name = array_column($array_collect, 'label');
            array_multisort($sort_name, SORT_DESC, $array_collect);

            $response['status'] = '1';
            $response['message'] = config('constant_api.massage.data_get_successfully');
            $response['data'] = $array_collect;
            _response($response);
        } else {
            $response['status'] = '0';
            $response['message'] = config('constant_api.massage.data_not_found');
            _response($response);
        }
        
    }

    public function post_your_requirement(Request $request){

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

    public function check_app_update(Request $request){
        $response['status'] = "1";
        $response['version'] = "1";
        $response['force_update'] = false;
        $response['title'] = 'Update Available';
        $response['message'] = 'New version of this app is available, please update now!';
        _response($response);
    }

    public function appApiConfigData(){
        $response = [
            "app_logo" => "https://storage.karigarbazar.com/assets/logos/logo-64.png",
            "play_store_url" => "https://play.google.com/store/apps/details?id=com.dashmobo.karigar.bazar",
            "customer_support_number" => "+91 9898079641",
            "website_url" => "https://karigarbazar.com",
            "share_app_english_message" =>"*Join for free.* Any craftsman can join this app. So that people contact you for work. You get contact in your own city. You can present your works.  Below is the link to join.",
        ];
        _response($response);
    }
}
