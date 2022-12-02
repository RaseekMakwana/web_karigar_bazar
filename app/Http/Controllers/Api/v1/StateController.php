<?php

namespace App\Http\Controllers\Api\v1;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\V1\State;


class StateController extends Controller
{
    public function get_states(){
        return State::select('state_id', 'state_slug', 'state_name')
                ->where(['status'=>'1'])
                ->get();
    }
}
