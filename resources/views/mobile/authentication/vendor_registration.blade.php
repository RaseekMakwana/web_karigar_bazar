@extends('mobile.layouts.default.index')

@section("title", "Free Join - Karigar Bazar- List Your All Karigar Join For Free")
@section("description", "Place a free listing of karigar on Karigar Bazar, Customer can contact you in your city and state of karigar, get valuable karigar for customers. Please free join instantly.")

@section('page_style')
@stop

@section('content')
<div class="container">
    <div class="row mb-5 justify-content-center">
        <div class="col-md-9 pt-3">
            <h1 class="display-6 fw-bold lh-1 mt-5 text-center">Free Join</h1>
            <h6 class="mb-4 text-center">It's free and always will be</h6>
            <form action="{{ url('vendor_registration/store') }}" method="post" name="signupForm" id="signupForm" autocomplete="off">
              @csrf
              @if(Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible">
                    <i class="icon fas fa-check"></i> {{ Session::get('success_message') }}
                    </div>
                @endif
                <div class="card">
                  <div class="card-body">
                      <div class="row g-3 mt-3">

                        <div class="col-sm-6">
                          <label for="lastName" class="form-label">Business Name / व्यवास्यक नाम / વ્યવસાયનું નામ</label>
                          <input type="text" class="form-control" name="business_name" id="business_name">
                          <div class="business_name_validation"></div>
                        </div>
        
                        <div class="col-sm-6">
                          <label for="lastName" class="form-label">Person Name / व्यक्ति का नाम / વ્યક્તિનું નામ</label>
                          <input type="text" class="form-control" name="vendor_name" id="vendor_name">
                          <div class="vendor_name_validation"></div>
                        </div>
                
                        <div class="col-sm-6">
                          <label for="lastName" class="form-label">Mobile No / मोबाइल नंबर / મોબાઇલ નંબર</label>
                          <input type="text" class="form-control" name="mobile_no" id="mobile_no" maxlength="10">
                          <div class="mobile_no_validation"></div>
                        </div>
        
                        
        
                        <div class="col-sm-6">
                          <label for="lastName" class="form-label">Password / पासवर्ड / પાસવર્ડ</label>
                          <input type="password" class="form-control" name="password" id="password">
                          <div class="password_validation"></div>
                        </div>
                      </div>
                      <div class="row g-3 border-top mt-3">
                        
                        <div class="col-md-6">
                          <label for="state" class="form-label">Occupation / व्यवसाय / વ્યવસાય</label>
                          <input type="text" class="form-control" name="occupation" id="occupation">
                          <div class="occupation_validation"></div>
                          
                        </div>
        
                        <div class="col-md-6">
                          <label for="state" class="form-label">State / राज्य / રાજ્ય</label>
                          <input type="text" class="form-control" name="state" id="state">
                          <div class="state_validation"></div>
                          
                        </div>
        
                        <div class="col-md-6">
                          <label for="state" class="form-label">City / शहर / શહેર</label>
                          <input type="text" class="form-control" name="city" id="city">
                          <div class="city_validation"></div>
                          
                        </div>
                        <div class="col-md-6">
                          <label for="state" class="form-label">Area / क्षेत्र / વિસ્તાર</label>
                          <input type="text" class="form-control" name="area" id="area">
                          <div class="area_validation"></div>
                          
                        </div>
                        <div class="col-sm-6">
                          <label for="lastName" class="form-label">Pincode / पिन कोड / પીન કોડ</label>
                          <input type="text" class="form-control" name="pin_code" id="pin_code" maxlength="6">
                          <div class="pincode_validation"></div>
                          
                        </div>
                      </div>
                      <div class="row g-3 mt-1">
                        <div class="col-md-6 text-center">
                          <button type="submit" class="btn btn-primary" name="submit">Join Now</button>
                        </div>
                      </div>
                  </div>
                </div>
              
              <div class="row g-3 mt-1">
                <div class="col-md-6">
                  If any query with us please contect on: +91 9898079641
                </div>
              </div>
            </form>
        </div>
    </div>
    
</div>

@stop

@section('page_javascript')

<script type="text/javascript">
  $('form[id="signupForm"]').validate({
      rules: {
        business_name: 'required',
        vendor_name: 'required',
        mobile_no: {
          required: true,
          digits: true,
          minlength : 10
        },
        password: 'required',
        occupation: 'required',
        state: 'required',
        city: 'required',
        area: 'required',
        pin_code: {
          required: true,
          digits: true,
          minlength : 6
        }
      },
      messages: {
        business_name: 'Business name is required',
        vendor_name: 'Vendor name is required',
        mobile_no: {
          required: 'Mobile is required',
        },
        password: 'Password is required',
        occupation: 'Occupation is required',
        state: 'State is required',
        city: 'City is required',
        area: 'Area is required',
        pin_code: {
          required: 'Pincode is required',
        }
      },
      submitHandler: function(form) {
          form.submit();
          // login_verification();
      }
  });
</script>

@stop
