<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorBasicRegistration extends Model
{
    use HasFactory;

    protected $table = 'vendor_basic_registration';

    protected $fillable = ['vendor_name','business_name','mobile','occupation','state','city','area','pin_code','password'];

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
            "status" => '2',
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
}
