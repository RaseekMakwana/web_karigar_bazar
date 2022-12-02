<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\AuthenticationController;
use App\Http\Controllers\Web\PostYourRequirementController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\VendorSearchController;

use App\Http\Controllers\Web\VendorAccountModule\VendorDashboard;
use App\Http\Controllers\Web\VendorAccountModule\VendorProfileController;
use App\Http\Controllers\Web\VendorAccountModule\VendorProjectController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [HomeController::class, 'index']);
Route::get('login', [AuthenticationController::class, 'login']);
Route::post('login/varification', [AuthenticationController::class, 'login_varification']);
Route::get('become-a-vendor', [AuthenticationController::class, 'vendor_registration']);
Route::post('vendor_registration/store', [AuthenticationController::class, 'vendor_registration_store']);
Route::get('post-your-requirement', [PostYourRequirementController::class, 'index']);
Route::post('post-your-requirement/store', [PostYourRequirementController::class, 'store']);

Route::middleware(['auth'])->group(function () {
    Route::get('vendor/dashboard', [VendorDashboard::class, 'index']);
    Route::get('logout', [AuthenticationController::class, 'logout']);

    Route::get('vendor/profile', [VendorProfileController::class, 'index']);
    Route::post('vendor/profile/update', [VendorProfileController::class, 'update']);
    Route::get('vendor/profile/set_vendor_picture_session/{image_url}', [VendorProfileController::class, 'set_vendor_picture_session']);

    Route::get('vendor/project', [VendorProjectController::class, 'index']);
    Route::get('vendor/project/create', [VendorProjectController::class, 'create']);
    Route::post('vendor/project/store', [VendorProjectController::class, 'store']);
    Route::get('vendor/project/edit/{category_id}/{category_name}', [VendorProjectController::class, 'edit']);
    Route::post('vendor/project/update', [VendorProjectController::class, 'update']);
    Route::get('vendor/project/delete/{category_id}', [VendorProjectController::class, 'delete']);
});


Route::get('{segment_one}/s-slfnxv', [HomeController::class, 'index']);
Route::get('{segment_one}/c-gxzsyu', [HomeController::class, 'index']);

Route::get('{segment_one}/{segment_two}/cn-pdtmsj', [CategoryController::class, 'index']);
Route::get('{segment_one}/{segment_two}/cs-qlwske', [CategoryController::class, 'index']);
Route::get('{segment_one}/{segment_two}/cc-chnpdy', [CategoryController::class, 'index']);

Route::get('{segment_one}/{segment_two}/vcn-ndywpu', [VendorSearchController::class, 'index']);
Route::get('{segment_one}/{segment_two}/vcs-vrtkwd', [VendorSearchController::class, 'index']);
Route::get('{segment_one}/{segment_two}/vcc-rwtkey', [VendorSearchController::class, 'index']);

Route::get('{segment_one}/{segment_two}/{segment_three}/vsn-adyquj', [VendorSearchController::class, 'index']);
Route::get('{segment_one}/{segment_two}/{segment_three}/vss-zhfagl', [VendorSearchController::class, 'index']);
Route::get('{segment_one}/{segment_two}/{segment_three}/vsc-hjebag', [VendorSearchController::class, 'index']);



