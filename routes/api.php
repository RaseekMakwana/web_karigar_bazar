<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\VendorCategoryServiceController;
use App\Http\Controllers\Api\v1\StateController;
use App\Http\Controllers\Api\v1\CityController;
use App\Http\Controllers\Api\v1\AreaController;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\ServiceController;
use App\Http\Controllers\Api\v1\VendorController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\MetadataController;
use App\Http\Controllers\Api\v1\AuthenticationController;
use App\Http\Controllers\Api\v1\VendorServiceController;
use App\Http\Controllers\Api\v1\ExtraController;
use App\Http\Controllers\Api\v1\DeviceController;
use App\Http\Controllers\Api\v1\HomepageController;
use App\Http\Controllers\Api\v1\PostYourRequirementController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// 'middleware' => ['basicAuth']
Route::group(['prefix' => 'v1', ],function () {

    // Extra
    Route::post('search_bar_cities', [ExtraController::class, 'search_bar_cities']);
    Route::post('search_bar_services', [ExtraController::class, 'search_bar_services']);
    Route::get('check_app_update', [ExtraController::class, 'check_app_update']);
    Route::get('app-api-config-data', [ExtraController::class, 'appApiConfigData']);
    
    // Post Your Requirement
    Route::post('post-your-requirement', [PostYourRequirementController::class, 'postYourRequirement']);

    // Metadata
    Route::post('metadata', [MetadataController::class, 'index']);
    
    //Common 
    Route::get('get_states', [StateController::class, 'get_states']);
    Route::post('get_cities_by_state_id', [CityController::class, 'get_cities_by_state_id']);
    Route::post('get_areas_by_city_id', [AreaController::class, 'get_areas_by_city_id']);
    
    // Device
    Route::post('device/check_device_exist_by_mobile_and_uuid', [DeviceController::class, 'check_device_exist_by_mobile_and_uuid']);
    
    // Category
    Route::post('get_category_details_by_vendor_type', [CategoryController::class, 'get_category_details_by_vendor_type']);
    

    // Route::get('get_vendor_type_with_category_details', [VendorCategoryServiceController::class, 'get_vendor_type_with_category_details']);
    // Route::post('get_vendors_details_by_category_slug', [VendorCategoryServiceController::class, 'get_vendors_details_by_category_slug']);
    // Route::post('get_vendors_details_by_service_slug', [VendorCategoryServiceController::class, 'get_vendors_details_by_service_slug']);
    Route::post('get_vendors_details_by_category_service_slug', [VendorCategoryServiceController::class, 'get_vendors_details_by_category_service_slug']);
    
    // User
    Route::post('login_success', [UserController::class, 'login_success']);
    Route::post('otp_verification', [UserController::class, 'otp_verification']);
    Route::post('user_registration', [UserController::class, 'user_registration']);
    
    // Vendor
    Route::post('vendor_registration', [VendorController::class, 'vendor_registration']);
    Route::post('vendor_login_verification', [VendorController::class, 'vendor_login_verification']);
    Route::post('vendor/get_vendor_details_by_vendor_id', [VendorController::class, 'get_vendor_details_by_vendor_id']);
    Route::post('vendor/post_update_vendor_profile_details', [VendorController::class, 'post_update_vendor_profile_details']);
    Route::post('check-token', [AuthenticationController::class, 'checkToken']);
    
    // Route::post('vendor/profile/upload_vendor_profile_picture', [VendorController::class, 'upload_vendor_profile_picture']);
    Route::post('vendor/project/get_vendor_project_list', [VendorController::class, 'get_vendor_project_list']);
    // Route::post('vendor/project/create', [VendorController::class, 'vendor_project_create']);
    // Route::post('vendor/project/update', [VendorController::class, 'vendor_project_update']);
    // Route::post('vendor/project/delete', [VendorController::class, 'vendor_project_delete']);
    // Route::post('vendor/project/get_category_of_selected_services_id_by_category_id_and_user_id', [VendorController::class, 'get_category_of_selected_services_id_by_category_id_and_user_id']);
    Route::post('vendor/update_business_profile_detail', [VendorController::class, 'update_business_profile_detail']);
    Route::post('vendor/get_business_profile_detail', [VendorController::class, 'get_business_profile_detail']);
    
    Route::post('service/get_vendor_selected_services_with_all_service_by_user_id_and_category_id', [ServiceController::class, 'get_vendor_selected_services_with_all_service_by_user_id_and_category_id']);
    Route::post('service/get_services_by_category_slug_or_id', [ServiceController::class, 'get_services_by_category_slug_or_id']);
    
    Route::post('vendor-service/create-vendor-service', [VendorServiceController::class, 'create_vendor_service']);
    Route::post('vendor-service/update-vendor-service', [VendorServiceController::class, 'update_vendor_service']);
    Route::post('vendor-service/delete-vendor-service', [VendorServiceController::class, 'delete_vendor_service']);
    
    Route::post('user/store_user_profile_picture', [UserController::class, 'store_user_profile_picture']);
    Route::post('user/get_user_detail_by_user_id', [UserController::class, 'getUserByUserId']);
    Route::post('user/update_user_profile_detail', [UserController::class, 'update_user_profile_detail']);
    
    Route::post('vendor-service/get_services_not_mapped_with_vendor_id', [VendorServiceController::class, 'get_services_not_mapped_with_vendor_id']);
    // Route::post('category/get_categories_list_not_mapped_with_vendor_id', [CategoryController::class, 'get_categories_list_not_mapped_with_vendor_id']);
    
    
    // App Home Page
    Route::get('home_page/home_page_module', [HomepageController::class, 'homePageModule']);
    Route::get('home_page/six_box_component', [HomepageController::class, 'six_box_component']);
    
    
    Route::post('testing_image_upload', [UserController::class, 'testing_image_upload']);
});

