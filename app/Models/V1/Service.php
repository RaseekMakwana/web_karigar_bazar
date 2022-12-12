<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'service_master';

    public static function getServiceByCategoryIdAndServiceIds($category_id,$service_ids){
        return Service::where("category_id", $category_id)
                    ->whereIn("service_id", $service_ids)
                    ->get();
    }

    /**
     * API: Get Service By Category Id
     * 
     * Request: category_id
     * 
     * Return: All Services
     */
    public static function getServicesByCategoryId($category_id){
        return Service::where(["category_id" => $category_id, "status" => '1'])->get();
    }
}
