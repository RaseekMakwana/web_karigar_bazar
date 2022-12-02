<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use DB, Request, Validator, Config;
use App\Models\V1\GroupCategoryMap;

class HomepageController extends Controller
{
    public function homePageModule(){
        $data = array(
            "section_one" => 1,
            "section_two" => 1
        );
        $response['status'] = "1";
        $response['message'] = config("constant_api.message.data_get_successfully");
        $response['data'] = $data;
        _response($response);
    }

    public function six_box_component(){
        $result_data = GroupCategoryMap::select("cm.category_id","cm.category_name","g.group_id","g.group_name","cm.category_slug","cm.picture_thumb")
                    ->from("group_category_map as gcm")
                    ->leftJoin("group as g","g.group_id","=","gcm.group_id")
                    ->leftJoin("category_master as cm","cm.category_id","=","gcm.category_id")
                    ->whereIn('gcm.group_id', ['1','2','3','4'])
                    ->where(['g.status' => '1','gcm.status' => '1'])
                    ->get()
                    ->sortBy("g.group_id");
        // p($result_data);

        $collect_data = array();
        if(!empty($result_data)){
            $i=-1;
            $temp_group = "";
            foreach ($result_data as $element) {
                
                if($element['group_id'] != $temp_group){
                    $temp_group = $element['group_id'];
                    $i++;
                }
                $collect_data[$i]['group_id'] = $element['group_id'];
                $collect_data[$i]['group_name'] = $element['group_name'];
                $collect_data[$i]['category_data'][] = [
                    "category_id" => $element->category_id,
                    "category_slug" => $element->category_slug,
                    "category_name" => $element->category_name,
                    "picture_thumb" => config('app.storage_url').$element->picture_thumb,
                ];
            }
            $response['status'] = "1";
            $response['message'] = config('constant_api.massage.data_get_successfully');
            $response['data'] = $collect_data;
        } else {
            $response['status'] = "0";
            $response['message'] = config('constant_api.massage.data_not_found');
        }
        _response($response);
    }

    public function group_by(){
        function group_by($key, $data) {
    $result = array();

    foreach($data as $val) {
        if(array_key_exists($key, $val)){
            $result[$val[$key]][] = $val;
        }else{
            $result[""][] = $val;
        }
    }

    return $result;
}
    }
}
