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
                <div class="col-md-4">
                    <a href="{{ url('vendor/dashboard') }}">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="col-md-4">
                    <h3>My Project</h3>
                </div>
                <div class="col-md-4 bg-light text-right">
                    <a href="{{ url('vendor/project/create') }}" class="btn btn-sm btn-success">New Create</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 mt-3">
            @if( Session::has('success_message'))
                <div class="alert alert-success alert-dismissible">
                <i class="icon fas fa-check"></i> {{ Session::get('success_message') }}
                </div>
            @endif
        </div>
        
        <?php foreach($data['project_data'] as $project_row){  ?>
            <div class="col-md-6 mt-3">
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
@stop

@section('page_javascript')
@stop
