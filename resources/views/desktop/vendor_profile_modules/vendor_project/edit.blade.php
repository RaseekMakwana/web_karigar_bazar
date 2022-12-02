@extends('desktop.layouts.default.default_layout')

@section("title", "Online local karigar Categories - Karigarbazar")
@section("description", "List of Categories of karigar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar services, tils service")
@section("keywords", "karigarbazar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar services, tils service")

@section('page_style')
<link rel="stylesheet" href="{{ URL::asset('plugins/select2/css/select2.min.css') }}">
@stop

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            
                    @include('desktop.vendor_profile_modules.profile_card')
                
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div class="col-md-6">
                            <h5>Update: {{ $data['category_name'] }}</h5>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ url('vendor/project') }}" class="btn btn-primary btn-sm" style="float:right">Manage Projects</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="{{ url('vendor/project/update') }}" method="post" name="vendorProject" id="vendorProject" autocomplete="off">
                            @csrf
                            <input type="hidden" name="category_id" value="{{ $data['category_id'] }}">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="selected_services" class="col-form-label">Vendor Services</label>
                                    <select class="select2" name="selected_services[]" id="selected_services" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                                        <?php  foreach($data['service_data'] as $service_row){ ?>
                                            <?php if(in_array($service_row['service_id'], explode(",",$data['selected_service_data']))){ ?>
                                                <option value="{{ $service_row['service_id'] }}" selected>{{ $service_row['service_name'] }}</option>
                                            <?php } else { ?>
                                                <option value="{{ $service_row['service_id'] }}"  >{{ $service_row['service_name'] }}</option>
                                            <?php } ?>
                                            
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary" name="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
              </div>

        </div>
    </div>
</div>


@stop

@section('page_javascript')
<script src="{{ URL::asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script>
$('.select2').select2();
</script>
@stop
