@extends('mobile.layouts.default.index')

@section("title", "Online local karigar Categories - Karigarbazar")
@section("description", "List of Categories of karigar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar services, tils service")
@section("keywords", "karigarbazar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar services, tils service")

@section('page_style')
@stop

@section('content')
<?php $vandor_detail = $data['vandor_detail']; ?>
<div class="container mt-4 mb-5 pb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between">
                <div class="col-md-4 pt-2">
                    <a href="{{ url('vendor/dashboard') }}">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="col-md-4">
                    <h5>My Profile</h5>
                </div>
                <div class="col-md-4">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        
    </div>
    <div class="row mt-3">
        <div class="col-12">
            
            @if( Session::has('success_message'))
                <div class="alert alert-success alert-dismissible">
                <i class="icon fas fa-check"></i> {{ Session::get('success_message') }}
                </div>
            @endif
        <div>

        <div class="card">
            <div class="card-body">
                <form action="{{ url('vendor/profile/update') }}" method="post" name="vendorProfile" id="vendorProfile" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <div class="form-group">
                                <label for="address" class="form-label">Business Name</label>
                                <input type="text" class="form-control" name="business_name" id="business_name" value="{{ $vandor_detail['business_name'] }}">
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="form-group">
                                <label for="address" class="form-label">Vendor Name</label>
                                <input type="text" class="form-control" name="vendor_name" id="vendor_name" value="{{ $vandor_detail['vendor_name'] }}">
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="form-group">
                                <label for="address" class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" id="email" value="{{ $vandor_detail['email'] }}">
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label for="address" class="form-label">Birthdate</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <?php $birthdate_explode = explode('-',Session::get('birthdate'));  ?>
                            <select class="form-select" name="birthdate_day" id="birthdate_day">
                                <option>-- DAY --</option>
                                <?php for($i=1; $i<=31;$i++){ ?>
                                <option value="{{ $i; }}" {{ ($i == $birthdate_explode[0])? "selected" : "" }}>{{ $i; }}</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-4">
                            <select class="form-select" name="birthdate_month" id="birthdate_month">
                                <option>-- MONTH --</option>
                                <?php for($i=1; $i<=12;$i++){ ?>
                                    <option value="{{ $i; }}" {{ ($i == $birthdate_explode[1])? "selected" : "" }}>{{ $i; }}</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-4">
                            <select class="form-select" name="birthdate_year" id="birthdate_year">
                                <option>-- YEAR --</option>
                                <?php for($i=date("Y",strtotime("-60 year")); $i<=date("Y",strtotime("-10 year"));$i++){ ?>
                                    <option value="{{ $i; }}" {{ ($i == $birthdate_explode[2])? "selected" : "" }}>{{ $i; }}</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label for="address" class="form-label">State</label>
                                <select class="form-select" name="state" id="state">
                                    <?php foreach($data['state_data'] as $state_row){ ?>
                                    <option value="{{ $state_row['state_id'] }}" {{ (Session::get('state_id') == $state_row['state_id'])? "selected" : "" }}>{{ $state_row['state_name'] }}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label for="address" class="form-label">City</label>
                                <select class="form-select" name="city" id="city">
                                    <?php foreach($data['city_data'] as $city_row){ ?>
                                    <option value="{{ $city_row['city_id'] }}" {{ (Session::get('city_id') == $city_row['city_id'])? "selected" : "" }}>{{ $city_row['city_name'] }}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label for="address" class="form-label">Area</label>
                                <select class="form-select" name="area" id="area">
                                    <?php foreach($data['area_data'] as $area_row){ ?>
                                    <option value="{{ $area_row['area_id'] }}" {{ (Session::get('area_id') == $area_row['area_id'])? "selected" : "" }}>{{ $area_row['area_name'] }}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <button type="submit" class="btn btn-primary" name="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>
@stop

@section('page_javascript')

<script type="text/javascript">
    $('form[id="vendorProfile"]').validate({
        rules: {
            business_name: 'required',
            vendor_name: 'required',
            birthdate_day: 'required',
            birthdate_month: 'required',
            birthdate_year: 'required',
            state: 'required',
            city: 'required',
            area: 'required',
        },
        messages: {
            business_name: 'Business is required',
            vendor_name: 'Vandor name is required',
            birthdate_day: 'Required',
            birthdate_month: 'Required',
            birthdate_year: 'Required',
            state: 'State is required',
            city: 'City is required',
            area: 'Area is required',
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>


<script>
$(document).ready(function(){
    $("#state").change(function() {
        var state_id = $(this).val();
        $.ajax({
            "url": "{{ URL('api/get_cities_by_state_id') }}",
            "data": {"state_id": state_id},
            "type": "POST",
            beforeSend: function(){
                $('#please_wait_loading').show();
            },
            success: function(response){
                var html = '<option value="">-- SELECT --</option>';
                $.each(response, function(k, val){
                    html += '<option value="'+val['city_id']+'">'+val['city_name']+'</option>';
                });
                $("#city").html(html);
            },
            complete: function(){
                $("#please_wait_loading").hide();
            }
        });
    });
    
    $("#city").change(function() {
    var city_id = $(this).val();
        $.ajax({
            "url": '{{ URL("api/get_areas_by_city_id") }}',
            "data": {"city_id": city_id},
            "type": "POST",
            beforeSend: function(){
                $('#please_wait_loading').show();
            },
            success: function(response){
                var html = '<option value="">-- SELECT --</option>';
                $.each(response, function(k, val){
                    html += '<option value="'+val['area_id']+'">'+val['area_name']+'</option>';
                });
                $("#area").html(html);
            },
            complete: function(){
                $("#please_wait_loading").hide();
            }
        });
    });
});
</script>

@stop
