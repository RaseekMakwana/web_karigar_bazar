<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category_master';

    // public static function get_categories_list_not_mapped_with_vendor_id($user_id){
    //     return Category::where()
    //                     ->get();
    //     // return Category::select("cm.category_id","cm.category_name")
    //     //             ->distinct("cm.category_id")
    //     //             ->from("category_master AS cm")
    //     //             ->leftJoin("vendor_master AS vm","vm.vendor_type_id","=","cm.vendor_type_id")
    //     //             ->leftJoin("vendor_type_master AS vtm","vtm.vendor_type_id","=","cm.vendor_type_id")
    //     //             ->whereRaw("cm.`category_id` not in (SELECT `category_id` FROM `vendor_service_master` WHERE user_id='".$user_id."') AND cm.status='1' and vtm.status='1'")
    //     //             ->orderBy("cm.category_name")
    //     //             ->get();
    // }
}
