<?php

namespace App\Models\V1;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    use HasFactory;

    public static function home_master_data(){
        return DB::Table('category_master as cm')
								->select(array('vtm.vendor_type_id', 'vtm.vendor_type_name', 'cm.category_id', 'cm.category_name', 'cm.picture_thumb'))
								->leftjoin('vendor_type_master as vtm','vtm.vendor_type_id', '=', 'cm.vendor_type_id')
								->where(['cm.status'=>1, 'vtm.status'=>1])
								->get();
    }
}
