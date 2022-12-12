@extends('mobile.layouts.default.index')

@section('title', 'Login - karigarbazar.com')
@section("description", "Log in to Karigarbazar. India's local search engine.")

@section('page_style')
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 pt-5">
            <h1 class="display-6 fw-bold lh-1 mt-5 text-center">Sign In</h1>
            <h6 class="mb-4 text-center">Please login to start your session</h6>
            <div class="row g-3  mt-3">
                @if(Session::has('error_message'))
                    <div class="alert alert-danger alert-dismissible">
                    <i class="icon fas fa-check"></i> {{ Session::get('error_message') }}
                    </div>
                @endif
                
                <form action="{{ url('login/varification') }}" method="post" name="loginForm" id="loginForm" autocomplete="off">
                    @csrf
                    <div class="col-sm-12 mb-3">
                        <!-- <label for="address" class="form-label"></label> -->
                        <input type="text" class="form-control" name="mobile_number" id="mobile_number" placeholder="Enter Mobile" maxlength="10">
                    </div>
                    <div class="col-sm-12 mb-3">
                        <!-- <label for="address" class="form-label"></label> -->
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    </div>
                    <div class="col-sm-12  text-center">
                        <button type="submit" class="btn btn-primary" name="submit">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>
@stop

@section('page_javascript')

<script type="text/javascript">
    $('form[id="loginForm"]').validate({
        rules: {
            mobile_number: 'required',
            password: 'required',
        },
        messages: {
            mobile_number: 'Mobile is required',
            password: 'Password is required',
        },
        submitHandler: function(form) {
            form.submit();
            // login_verification();
        }
    });
</script>
@stop
