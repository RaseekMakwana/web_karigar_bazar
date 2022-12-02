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
                    <a href="{{ url('vendor/project') }}">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="col-md-4">
                    <h3>Create Project</h3>
                </div>
                <div class="col-md-4 bg-light text-right">
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <form action="{{ url('vendor/project/store') }}" method="post" name="vendorProject" id="vendorProject" autocomplete="off">
            @csrf
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="address" class="form-label">Category</label>
                            <select class="form-control" name="category" id="category">
                                <option value="">-- SELECT CATEGORY --</option>
                                <?php foreach($data['category_data'] as $category_row){ ?>
                                <option value="{{ $category_row['category_id'] }}">{{ $category_row['category_name'] }}</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="selected_services" class="col-form-label">Vendor Services</label>
                            <select class="select2" name="selected_services[]" id="selected_services" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary" name="submit">Save</button>
                    </div>
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

<script type="text/javascript">
    $('form[id="vendorProject"]').validate({
        rules: {
            category: 'required',
        },
        messages: {
            category: 'Category is required',
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>

<script>
$("#category").change(function() {
    var category_id = $(this).val();
        $.ajax({
            "url": '{{ URL("api/service/get_services_by_category_slug_or_id") }}',
            "data": {"action_flag": "category_id", "category_value": category_id},
            "type": "POST",
            beforeSend: function(){
                $('#please_wait_loading').show();
            },
            success: function(response){
                var html = '<option value="">-- SELECT --</option>';
                $.each(response, function(k, val){
                    html += '<option value="'+val['service_id']+'">'+val['service_name']+'</option>';
                });
                $("#selected_services").html(html);
            },
            complete: function(){
                $("#please_wait_loading").hide();
            }
        });
    });
</script>
@stop
