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
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div class="col-md-3">
                            <h5>My Projects</h5>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ url('vendor/project/create') }}" class="btn btn-success btn-sm" style="float:right">New Create</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if( Session::has('success_message'))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success alert-dismissible">
                            <i class="icon fas fa-check"></i> {{ Session::get('success_message') }}
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="row">

                        <?php foreach($data['project_data'] as $project_row){  ?>
                            <div class="col-md-4 mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $project_row['category_name'] }}</h5>
                                        <p class="card-text">
                                            <?php if(!empty($project_row['service_data'])){ ?>
                                                <?php foreach($project_row['service_data'] as $service_row){ ?>
                                                    <span class="badge text-bg-primary" style="border-radius: 3px; padding: 5px 13px">{{ $service_row['service_name'] }}</span>
                                                <?php } ?>
                                            <?php } ?>
                                        </p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ url('vendor/project/edit').'/'.$project_row['category_id'].'/'.$project_row['category_name'] }}" class="card-link" style="text-decoration: none">Edit</a>
                                        <a href="{{ url('vendor/project/delete').'/'.$project_row['category_id'] }}" class="card-link text-danger" style="text-decoration: none">Delete</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        
                    </div>
                </div>
              </div>

        </div>
    </div>
</div>

@stop

@section('page_javascript')
@stop
