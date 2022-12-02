@extends('mobile.layouts.default.index')

@section("title", "Online local karigar Categories - Karigarbazar")
@section("description", "List of Categories of karigar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar services, tils service")
@section("keywords", "karigarbazar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar services, tils service")

@section('page_style')
@stop

@section('content')
<div class="container mt-5 mb-5 pb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between">
                <div class="col-md-4 pt-2">
                    <a href="{{ url('vendor/project') }}">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="col-md-4">
                    <h3>Update: {{ $data['category_name'] }}</h3>
                </div>
                <div class="col-md-4 bg-light text-right">
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <form action="{{ url('vendor/project/update') }}" method="post" name="vendorProject" id="vendorProject" autocomplete="off">
            @csrf
            <div class="card">
                <div class="card-body">
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
                </div>
            </div>
            
        </form>
    </div>
</div>
@stop

@section('page_javascript')
<script>
$('.select2').select2();
</script>
@stop
