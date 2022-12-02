<?php

namespace App\Http\Controllers\Web\VendorAccountModule;

use App\Http\Controllers\Controller;
use Request, Session;
use Jenssegers\Agent\Agent;

class VendorDashboard extends Controller
{
    public $DeviceAgent;
    public function __construct() {
        $this->DeviceAgent = new Agent;
    }
    public function index(){
        if ($this->DeviceAgent->isDesktop()){
            return view("desktop.vendor_profile_modules.vendor_dashboard.index");
        } else{
            return view("mobile.vendor_profile_modules.vendor_dashboard.index");
        }
    }
}
