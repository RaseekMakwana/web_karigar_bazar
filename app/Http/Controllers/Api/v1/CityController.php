<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\V1\City;


class CityController extends Controller
{

    /**
     * @param  $state_id
     */
    public function get_cities_by_state_id(Request $request){
        
        

        $rules = array(
            'state_id' => "required",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $input = $request->input();

            $city_data = City::from('city_master as cm')
                        ->select(array('cm.city_id', 'cm.city_slug', 'cm.city_name'))
                        ->where(['cm.state_id'=>$input['state_id'], 'cm.status'=>'1'])
                        ->orderBy('cm.city_name','asc')
                        ->get();
            
            $response = array();
            foreach($city_data as $city_row){
                $response[] = array(
                    'city_id' => $city_row->city_id,
                    'city_slug' => $city_row->city_slug,
                    'city_name' => $city_row->city_name
                );
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
