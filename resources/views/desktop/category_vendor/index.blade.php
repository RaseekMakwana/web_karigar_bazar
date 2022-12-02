@extends('desktop.layouts.default.default_layout')

@section("title", $data['metadata']['title'])
@section("description", $data['metadata']['description'])
@section("keywords", $data['metadata']['keyword'])

@section('page_style')
@stop

@section('content')

    <div class="container mt-5">
      <div class="row d-flex justify-content-between">
        <div class="col-md-5">
          <h4 class="fw-bold mb-0">{{ remove_dash_first_upperletter($data['segment_two'])." in ".remove_dash_first_upperletter($data['segment_one']) }}</h4>
        </div>
        <div class="col-md-4">
        </div> 
      </div>
      
        <div class="row mt-3 sub_tag_master_class">
            <div class="col ">
                <?php foreach($data['service_data'] as $key => $service_row){ ?>
                <a href="{{ url($data['segment_one'].'/'.$data['segment_two'].'/'.$service_row['service_slug'].'/'.$data['segment_three']) }}" class="btn btn-outline-secondary btn-sm" >
                        {{ $service_row['service_name'] }}
                </a>
                <?php } ?>
            </div>
        </div>
      <div class="mt-0 row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xl-4 row-cols-xxl-5 
      g-2 g-xs-2 g-sm-3 g-md-2 g-lg-3 g-xl-2 g-xxl-3">
        <?php foreach($data['vendor_data'] as $key => $vendor_row){ ?>
          <div class="col" >
              <div class="card h-100" >
                  {{-- <img src="https://www.tutorialrepublic.com/examples/images/thumbnail.svg" class="card-img-top" alt="..."> --}}
                  <div class="card-body">
                      <h5 class="card-title">{{ $vendor_row['vendor_name'] }}</h5>
                      <p class="card-text"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $vendor_row['city_name'] }} | {{ $vendor_row['area_name'] }} <br> <i class="fa fa-mobile" aria-hidden="true"></i> {{ $vendor_row['mobile'] }}</p>
                  </div>
                  <div class="card-footer">
                    <a class="btn btn-sm btn-success" href="" ><i class="fa fa-whatsapp"></i> Whatsapp</a>
                      <!-- <small class="text-muted"><button class="btn btn-sm btn-primary" [routerLink]="['/vendor-detail/'+paramsCity+'/'+paramsCategory+'/'+level_two.user_id+'/'+level_two.business_name]">Details</button></small> -->
                  </div>
              </div>
          </div>
        <?php } ?>
      </div>
    </div>
    
@stop

@section('page_javascript')
@stop


