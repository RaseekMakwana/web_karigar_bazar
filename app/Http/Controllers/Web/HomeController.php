<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\Home;
use App\Helpers\CommonFunction;
use App\Services\RestApi;
use App\Http\Controllers\Web\Traits\MetadataTrait;


class HomeController extends Controller
{
    use MetadataTrait;

    public function index(Request $request){
        $data['category_data'] = RestApi::get('home_page/six_box_component');

        $data['metadata'] = $this->homeMetadata();

        return view('desktop.home.home_index', compact('data'));
    }
}
