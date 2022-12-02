<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorService extends Model
{
    use HasFactory;

    protected $table = 'vendor_service_master';

    public static function getVendorServiceByUserIdAndCategoryId($user_id,$category_id){
        return VendorService::where(["user_id"=>$user_id,"category_id"=>$category_id])->first();
    }

    public static function create_vendor_service($request){
        $service_ids_collection = json_decode($request['service_ids_collection'], true);
        $service_ids = array();
        foreach($service_ids_collection as $row){
            $service_ids[] = $row['service_id'];
        }
        $updateData = array(
            "service_id" => implode(",",$service_ids),
            "status" => '1'
        );
        VendorService::where(["user_id" => $request['user_id'], "category_id" => $request['category_id']])->update($updateData);
    }

    public static function update_vendor_service($request){
        // p($request['service_ids_collection']);
        $service_ids_collection = json_decode($request['service_ids_collection'], true);
        
        $service_ids = array();
        foreach($service_ids_collection as $row){
            $service_ids[] = $row['service_id'];
        }
        $updateData = array(
            "service_id" => implode(",",$service_ids)
        );
        VendorService::where(["user_id" => $request['user_id'],"category_id" => $request['category_id']])->update($updateData);
    }

    public static function delete_vendor_service($user_id,$category_id){
        $updateData = array(
            "status" => '3',
        );
        VendorService::where(["user_id" => $user_id, "category_id"=>$category_id])->update($updateData);
            
        // return VendorService::where(["user_id"=>$user_id,"category_id"=>$category_id])->delete();
        // return VendorService::where(["user_id"=>$user_id,"category_id"=>$category_id])->delete();
    }

    public static function get_services_not_mapped_with_vendor_id($user_id){
        return VendorService::select("cm.category_id","cm.category_name")
            ->from("vendor_service_master as vsm")
            ->leftJoin("category_master as cm","cm.category_id","=","vsm.category_id")
            ->where(["vsm.user_id"=>$user_id,"vsm.status"=>"2"])
            ->get()
            ->sortByDesc("cm.category_name");
    }

    public static function get_vendors_by_category_service_zone($input){
        $query_string = "";
        if($input['zone_type'] == "state"){
            $query_string .= " and stm.state_slug = '".$input['zone_value']."'";
        } else if($input['zone_type'] == "city"){

            $city_lat_long = City::select('latitude','longitude')->where("city_slug",$input['zone_value'])->first();

            $calculate_range_cities = "(SELECT city_id FROM (SELECT city_id, latitude, longitude, (6000*ACOS(COS(RADIANS($city_lat_long->latitude)) * COS(RADIANS(latitude)) * COS(RADIANS(longitude) - RADIANS($city_lat_long->longitude)) + SIN(RADIANS($city_lat_long->latitude))* SIN(RADIANS(latitude)))) AS distance FROM city_master HAVING distance < 50 ORDER BY distance ASC) a)";

            $query_string .= " AND vsm.city_id IN $calculate_range_cities";
        } 

        if($input['type'] == "service"){
            $query_string .= " and sm.service_slug = '".$input['slug']."'";
        } else if($input['type'] == "category"){
            $query_string .= " and cm.category_slug = '".$input['slug']."'";
        }

        return VendorService::from('vendor_service_master AS vsm')
                ->select(array('um.user_id','um.name', 'um.mobile', 'cim.city_name','cm.category_id','vm.area'))
                ->distinct('um.user_id')
                ->leftjoin('service_master AS sm', function($query){
                    $query->whereRaw("find_in_set(sm.service_id, vsm.service_id)");
                })
                ->leftjoin('category_master AS cm','cm.category_id', '=', 'vsm.category_id')
                ->leftjoin('user_master AS um','um.user_id', '=', 'vsm.user_id')
                ->leftjoin('city_master AS cim','cim.city_id', '=', 'vsm.city_id')
                ->leftjoin('vendor_master AS vm','vm.user_id', '=', 'vsm.user_id')
                ->whereRaw("vsm.status = '1' AND cm.status = '1' AND cim.status = '1' AND um.status='1' $query_string")
                ->get();
    }
}
