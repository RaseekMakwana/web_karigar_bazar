<header class="border-bottom pt-3 pb-2">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-3 col-xxl-3 mb-3 mb-xs-3 mb-sm-3 mb-md-3 mb-lg-2 mb-xl-2 header_image_col_div">
          <a href="{{ url('/') }}"><img src="{{ URL::asset('images/logo.png') }}" style="width: 200px;" alt="karigarbazar logo"></a>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-7 col-xxl-6 
                  mb-2 mb-xs-2 mb-sm-2 mb-md-2 mb-lg-0
                ">
                <div class="row search_compoments">
                  <div class="col-10 col-md-3 offset-1 offset-md-0 search_city_cls" style="padding: 0px;">
                      <input class="form-control" id="autocomplete_search_city" name="q" autofocus autocomplete="off" placeholder="Select City">
                  </div>
                  <div class="col-10 col-md-9 offset-1 offset-md-0 service_city_cls" style="padding: 0px;">
                      <input class="form-control" id="autocomplete_search_service" name="q" autocomplete="off" placeholder="What are you looking">
                  </div>
                  <!-- <input type="text" id="filter_big_textbox" class="form-control typeahead tt-query" placeholder="Search keyword, event"> -->
                </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2 col-xxl-3 
                    d-none d-xs-none d-sm-none d-md-none d-lg-block" style="text-align: right;">
  
          <ul class="nav d-flex justify-content-end">
            <?php if(Session::get('login_status') != "1"){ ?>
            <li><a href="{{ url('login') }}" class="nav-link px-2 link-dark">Login</a></li>
            <li><a href="{{ url('become-a-vendor') }}" class="nav-link px-2 link-dark">Join Now</a></li>
            <?php } else { ?>
              <li><a href="{{ url('vendor/dashboard') }}" class="nav-link px-2 link-dark">{{ Session::get('vendor_name') }}</a></li>
            <?php } ?>
          </ul>
  
        </div>
      </div>
    </div>
  </header>


<link rel="stylesheet" href="{{ URL::asset('plugins/jquery-ui/jquery-ui.css') }}">
<script src="{{ URL::asset('plugins/jquery-ui/jquery-ui.js') }}"></script>

{{-- <style>
  .ui-autocomplete-input-has-clear {
  padding-right: 10px * 1.5;
}

.ui-autocomplete-input-has-clear::-ms-clear {
   display: none;
}

.ui-autocomplete-clear {
  display: inline-block;
  font-size: 22px;
  text-align: center;
  cursor: pointer;
}
</style> --}}





<script>

  $(function(){
    
    var source  = [ ];
    var mapping = { };
    $('#autocomplete_search_city').autocomplete({
        minLength: 2,
        source: function( request, response ) {
              $.ajax({
              url: "{{ Config::get('app.api_url').'search_bar_cities' }}",
              type: "post",
              data: {
                term: request.term
              },
              success: function(raw) {
                source  = [ ];
                mapping = { };
                for(var i = 0; i < raw.length; ++i) {
                    source.push(raw[i].label);
                    mapping[raw[i].label] = raw[i].value;
                }
                response(source);
              }
            });
        },
        clearButton: true,
        select: function(event, ui) {
            filter_collection('city_term',mapping[ui.item.value],"");
        }
    });
  });
</script>


<script>
  $(function(){
    var source  = [ ];
    var mapping_value = { };
    var mapping_category = { };
    $('#autocomplete_search_service').autocomplete({
        minLength: 2,
        source: function( request, response ) {
              $.ajax({
              url: "{{ config('app.api_url').'search_bar_services' }}",
              type: "post",
              data: {
                term: request.term
              },
              success: function(result) {
                var raw = result.data;
                source  = [ ];
                mapping_value = { };
                mapping_category = { };
                mapping_category_type = { };
                for(var i = 0; i < raw.length; ++i) {
                    source.push(raw[i].label);
                    mapping_value[raw[i].label] = raw[i].value;
                    mapping_category[raw[i].label] = raw[i].category_slug;
                    mapping_category_type[raw[i].label] = raw[i].type;
                }
                response(source);
              }
            });
        },
        closeButton: true,
        select: function(event, ui) {
            filter_collection("search_term",mapping_value[ui.item.value],mapping_category[ui.item.value],mapping_category_type[ui.item.value]);
        }
    });
  });
</script>

<script>
  var cities = "";
  var search_category_service = "";
  function filter_collection(type,value,mapping_category,mapping_category_type){
    console.log(type+" - "+value+" - "+mapping_category+" - "+mapping_category_type);
    if(type == "city_term" && value.length != 0){
      cities = value;
    }
    if(type == "search_term" && value.length != 0){
      search_category_service = value;
    }
    if(cities != "" && search_category_service != ""){
      if(mapping_category_type == "service"){
        window.location.href = "{{ URL('/') }}/"+cities+"/"+mapping_category+"/"+value+"/{{config('constant_web.custom_slug.vendor.service_city')}}";
      } else if(mapping_category_type == "category"){
        window.location.href = "{{ URL('/') }}/"+cities+"/"+search_category_service+"/{{config('constant_web.custom_slug.vendor.category_city')}}";
      }
    }
  }
</script>
