@extends('desktop.layouts.default.default_layout')

@section("title", $data['metadata']['title'])
@section("description", $data['metadata']['description'])
@section("keywords", $data['metadata']['keyword'])

@section('page_style')
@stop

@section('content')
<div class="container pt-5">
  <div class="row d-flex justify-content-between">
    <div class="col-md-5">
      <h4 class="fw-bold mb-0">{{ remove_dash_first_upperletter($data['segment_two'])." in ".remove_dash_first_upperletter($data['segment_one']) }}</h4>
    </div>
    <div class="col-md-4">
    </div> 
  </div>
  <div class="mt-0 row row-cols-3 row-cols-xs-3 row-cols-sm-3 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 row-cols-xl-4 row-cols-xxl-5 
                  g-2 g-xs-2 g-sm-3 g-md-2 g-lg-3 g-xl-2 g-xxl-3" >

      <?php foreach($data['category_data'] as $key => $category_row){  ?>
      <div class="col home_category_class" >
        <a href="{{ url($data['segment_one'].'/'.$category_row['category_slug'].'/'.$data['segment_three']) }}" class="card transition_image box-shadow card_item_class" >
          <div class="card-header p-0">
            <img class="card-img-top category_thumb" src="{{ $category_row['picture_thumb'] }}" alt="" data-holder-rendered="true">
          </div>
          <div class="card-body py-2 px-2 category_label">
            <p class="card-text ">{{ $category_row['category_name'] }}</p>
          </div>
        </a>
      </div>
      <?php } ?>

  </div>
</div>
@stop

@section('page_javascript')
@stop
