@extends('desktop.layouts.default.default_layout')

@section("title", "Online local karigar Categories - Karigarbazar")
@section("description", "List of Categories of karigar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar services, tils service")
@section("keywords", "karigarbazar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar services, tils service")

@section('page_style')
@stop

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            
                    @include('desktop.vendor_profile_modules.profile_card')
                
        </div>
        <div class="col-md-9">
            <div class="card mb-4 rounded-3 shadow-sm">
                <div class="card-body">
                  <div class="row mt-1 mb-5">
                      <div clas="col-md-12">
                        <h3 class="card-title">{{ Session::get('vendor_name') }}</h3>
                      </div>
                  </div>
                  <div class="row mt-2">
                      <div class="col-md-3">
                        <strong>Business Name</strong>
                      </div> 
                      <div class="col-md-9"> 
                        <p class="card-title">: {{ Session::get('business_name') }}</p>
                      </div> 
                  </div>  
                  <div class="row mt-2">
                      <div class="col-md-3">
                        <strong>Mobile</strong>
                      </div> 
                      <div class="col-md-9"> 
                        <p class="card-title">: {{ Session::get('mobile') }}</p>
                      </div> 
                  </div>  
                  <div class="row mt-2">
                      <div class="col-md-3">
                        <strong>Email</strong>
                      </div> 
                      <div class="col-md-9"> 
                        <p class="card-title">: {{ Session::get('email') }}</p>
                      </div> 
                  </div>  
                  <div class="row mt-2">
                      <div class="col-md-3">
                        <strong>Birthdate</strong>
                      </div> 
                      <div class="col-md-9"> 
                        <p class="card-title">: {{ Session::get('birthdate') }}</p>
                      </div> 
                  </div>  
                  <div class="row mt-2">
                      <div class="col-md-3">
                        <strong>Area</strong>
                      </div> 
                      <div class="col-md-9"> 
                        <p class="card-title">: {{ Session::get('area_name') }}</p>
                      </div> 
                  </div>  
                  <div class="row mt-2">
                      <div class="col-md-3">
                        <strong>City</strong>
                      </div> 
                      <div class="col-md-9"> 
                        <p class="card-title">: {{ Session::get('city_name') }}</p>
                      </div> 
                  </div>  
                  <div class="row mt-2">
                      <div class="col-md-3">
                        <strong>State</strong>
                      </div> 
                      <div class="col-md-9"> 
                        <p class="card-title">: {{ Session::get('state_name') }}</p>
                      </div> 
                  </div>  
                  </div>
                  
                  
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('page_javascript')
@stop
