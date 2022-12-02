@extends('desktop.layouts.default.default_layout')

@section("title", "Post Your Requirement | karigarbazar.com")
@section("description", "Karigarbazar, India's local search engine, provides karigar, Electrician, Painters, Interior Design, Furniture, Plumber, Wedding Planner, Contractor, Product Supplier, Consultant, Aluminium & Glass Work, Architect, Modular Kitchen")
@section("keywords", "karigarbazar, carpenter, contractor, karigar, fabrication, electrician, product supplier, consultant, aluminium & glass work, architect, painters, modular kitchen, interior design, furniture, plumber, home decoration, solar services, tils service")

@section('page_style')
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 pt-3">
            <h1 class="display-6 fw-bold lh-1 mt-5">Post Your Requirement</h1>
            <h6 class="mb-4">Please share your requirement</h6>
            <form action="{{ url('post-your-requirement/store') }}" method="post" name="PostRequirementForm" id="PostRequirementForm" autocomplete="off">
                @csrf  
            <div class="row g-3 border-top mt-3">
                @if(Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible">
                    <i class="icon fas fa-check"></i> {{ Session::get('success_message') }}
                    </div>
                @endif
                
                <div class="col-sm-6">
                    <!-- <label for="firstName" class="form-label"></label> -->
                    <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" id="name" >
                    <div class="name_validation"></div>                    
                </div>

                <div class="col-sm-6">
                    <!-- <label for="address" class="form-label"></label> -->
                    <input type="text" class="form-control" id="mobile" placeholder="Mobile" name="mobile" id="mobile" maxlength="10">
                    <div class="mobile_validation"></div>                    
                </div>

                <div class="col-sm-6">
                    <!-- <label for="address" class="form-label"></label> -->
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email" id="email">
                    <div class="email_validation"></div>                    
                </div>

                <div class="col-sm-12">
                    <!-- <label for="address" class="form-label">Message</label> -->
                    <textarea class="form-control" rows="5" name="message" id="message" placeholder="Message"></textarea>
                    <div class="message_validation"></div>                    
                </div>

                <div class="col-sm-12">
                <button type="submit" class="btn btn-primary" [disabled]="!PostYourRequirementForm.valid">Submit</button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
@stop

@section('page_javascript')
<script type="text/javascript">
    $('form[id="PostRequirementForm"]').validate({
        rules: {
            name: 'required',
            mobile: {
                required: true,
                digits: true,
                minlength : 10
            },
            email: 'required',
            message: 'required',
        },
        messages: {
            name: 'Name is required',
            mobile: {
                required: 'Mobile is required',
            },
            email: 'Email is required',
            message: 'Message is required',
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>
@stop
