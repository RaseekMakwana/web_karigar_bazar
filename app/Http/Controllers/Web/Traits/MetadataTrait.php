<?php

namespace App\Http\Controllers\Web\Traits;

use Cookie;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Service\RestApi;

trait MetadataTrait
{
    public function homeMetadata(){
        $segment_one = request()->segment(1);
        if(empty(request()->segment(1))){
            $response['title'] = "Karigarbazar - Local Karigar Search";
            $response['description'] = "Karigarbazar India's local karigar search website. anyone can find karigar in their own area, city and state. Karigar can join for free. Customer can share their work";
            $response['keyword'] = "Get Karigar, Karigar Bazar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar service, tils service";
        } else {
            $response['title'] = "Get Karigar in ".remove_dash_first_upperletter($segment_one)." - KarigarBazar";
            $response['description'] = "Karigarbazar ".remove_dash_first_upperletter($segment_one)." local karigar search website. anyone can find karigar in their own area, city and state. Karigar can join for free. Customer can share their work";
            $response['keyword'] = "Get Karigar in ".remove_dash_first_upperletter($segment_one).", Karigar Bazar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar service, tils service";
        }
        return $response;
    }

    public function vendorSearchMetadata(){
        $segment_one = request()->segment(1);
        $segment_two = request()->segment(2);
        $segment_three = request()->segment(3);
        $segment_four = request()->segment(4);

        $response = array();
        if(empty($segment_four)){
            if($segment_three == config("constant_web.custom_slug.vendor.category_normal")){ // vcn
                $response['title'] = "Top 100 ".remove_dash_first_upperletter($segment_two)." Service in Karigar Bazar";
                $response['description'] = "Top 100 ".remove_dash_first_upperletter($segment_two)." Service in ".remove_dash_first_upperletter($segment_three)." - Karigar Bazar. List of Categories of karigar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar service, tils service";
                $response['keyword'] = "karigarbazar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar service, tils service";
            }
            if($segment_three == config("constant_web.custom_slug.vendor.category_city")){ // vcc
                $response['title'] = "Top 100 ".remove_dash_first_upperletter($segment_two)." Service in ".remove_dash_first_upperletter($segment_one)." - Karigar Bazar";
                $response['description'] = "Top 100 ".remove_dash_first_upperletter($segment_two)." Service in ".remove_dash_first_upperletter($segment_three)." - KarigarBazar. List of Categories of karigar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar service, tils service";
                $response['keyword'] = "karigarbazar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar service, tils service";
            }
        } else {
            if($segment_four == config("constant_web.custom_slug.vendor.service_normal")){  // vsn
                $response['title'] = "Top 100 ".remove_dash_first_upperletter($segment_three)." - ".remove_dash_first_upperletter($segment_two)." Service in Karigar Bazar";
                $response['description'] = "Top 100 ".remove_dash_first_upperletter($segment_two)." in ".remove_dash_first_upperletter($segment_one)." - ".remove_dash_first_upperletter($segment_three)." - KarigarBazar. List of Categories of karigar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar service, tils service";
                $response['keyword'] = "karigarbazar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painter, modular kitchen, interior design, furniture, plumber, home decoration, solar service, tils service";
            }
            if($segment_four == config("constant_web.custom_slug.vendor.service_city")){ // vsc
                $response['title'] = "Top 100 ".remove_dash_first_upperletter($segment_three)." Services in ".remove_dash_first_upperletter($segment_one)." - Karigar Bazar";
                $response['description'] = "Top 100 ".remove_dash_first_upperletter($segment_three)." Services in ".remove_dash_first_upperletter($segment_one)." - KarigarBazar. List of Categories of karigar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar service, tils service";
                $response['keyword'] = "karigarbazar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painter, modular kitchen, interior design, furniture, plumber, home decoration, solar service, tils service";
            }
        }
        return $response;
    }

}
