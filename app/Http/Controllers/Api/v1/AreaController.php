<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\V1\Area;

class AreaController extends Controller
{
    /**
     * @param  $state_id
     */
    public function get_areas_by_city_id(Request $request){

        $rules = array(
            'city_id' => "required",
        );
        $validator = Validator::make($request->all(),$rules);
        if(!$validator->fails()){

            $input = $request->input();

            $area_data = Area::from('area_master as am')
                        ->select(array('am.area_id', 'am.area_name'))
                        ->where(['am.city_id'=>$input['city_id'], 'am.status'=>'1'])
                        ->orderBy('am.area_name','asc')
                        ->get();

            $response = array();
            if(!empty($area_data)){
                foreach($area_data as $area_row){
                    $response[] = array(
                        'area_id' => $area_row->area_id,
                        'area_name' => $area_row->area_name
                    );
                }
                _response($response);
            } else {
                $response['status'] = '0';
                $response['message'] = config('constant_api.massage.data_not_found');
                _response($response);
            }
            

        } else {
            $response['status'] = '0';
            $response['message'] = $validator->errors();
            _response($response);
        }
    }
}
