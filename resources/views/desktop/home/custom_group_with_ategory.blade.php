<?php $category_data = $data['category_data']['data']; 

$uri_one = "all";
$uri_three = config('constant_web.custom_slug.vendor.category_normal');
$segment_one = request()->segment(1);
if(!empty($segment_one)){
  $uri_one = request()->segment(1);
  $uri_three = config('constant_web.custom_slug.vendor.category_city');
} 
foreach($category_data as $group_key => $group_row){  
    
    // if(empty($data['segment_one'])){
//   $data['segment_one'] = $vendor_data_row['vendor_type_slug'];
//   $data['segment_two'] = $vendor_data_row['vendor_type_slug'];
//   $data['segment_category_link'] = 'all';
//   $data['vendor_type_name'] = remove_dash_first_upperletter($vendor_data_row['vendor_type_slug']);
// } else {
//   $data['segment_one'] = $data['segment_one'];
//   $data['segment_two'] = $vendor_data_row['vendor_type_slug'];
//   $data['segment_category_link'] = $data['segment_one'];
//   $data['vendor_type_name'] = remove_dash_first_upperletter($vendor_data_row['vendor_type_name'])." in ".remove_dash_first_upperletter($data['segment_one']);
// }

?>
<div class="row">
    <div class="col-12 mb-5">
      <div class="row d-flex justify-content-between">
        <div class="col-6">
          <h4 class="fw-bold mb-0">{{ $group_row['group_name'] }}</h4>
        </div>
        <div class="col-4 ">
          {{-- <a href="{{ url($data['segment_category_link'].'/'.$data['segment_two'].'/'.$data['link_segment_three']) }}" class="btn btn-primary btn-sm " style="float: right" >View All</a> --}}
        </div> 
      </div>
      <div class="mt-0 row row-cols-3 row-cols-xs-3 row-cols-sm-3 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 row-cols-xl-4 row-cols-xxl-5 
                  g-2 g-xs-2 g-sm-3 g-md-2 g-lg-3 g-xl-2 g-xxl-3" >

                  <?php foreach($group_row['category_data'] as $key => $category_row){   ?>
                  <div class="col home_category_class transition_image" >
                    
                    <a  href="{{ url($uri_one.'/'.$category_row['category_slug'],$uri_three) }}" class="card  box-shadow card_item_class" >
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
  </div>

<?php } ?>