
<div class="card mb-4 rounded-3 shadow-sm">
    <div class="card-body">
        <div class="row text-center">
            <div class="text-center mt-3">
                <?php if(!empty(Session::get('profile_picture'))){ ?>
                    <img src="{{ Session::get('profile_picture') }}" id="user_profile_image" class="img-thumbnail text-center" alt="..." style="border-radius: 50%; height: 190px; width: 190px">
                <?php } else {  ?>
                    <img src="{{ URL::asset('images/user-placeholder.png') }}" id="user_profile_image" class="img-thumbnail text-center" alt="..." style="border-radius: 50%; height: 190px; width: 190px">
                <?php } ?>
            </div>
            <p>
                <form action="asdfadadfadf" mathod="post" id="ImageBrowseForm" enctype="multipart/form-data">
                    <label class="custom-file-upload" >
                    <input type="file" style="display:none" id="upload_file" name="upload_file">
                    <i class="fa-solid fa-pen-to-square"></i>&nbsp;<span style="text-decoration: underline; cursor: pointer;">Change Photo</span>
                    </label>
                </form>
            </p>
            <h5 class="mt-4">{{ Session::get('vendor_name') }}</h5>
            <h6>{{ Session::get('mobile') }}</h6>
            <div class="d-grid gap-2 col-11 mx-auto mt-4">
                <a href="{{ url('vendor/dashboard') }}" class="btn btn-primary">Home</a>
                <a href="{{ url('vendor/profile') }}" class="btn btn-primary">My Profile</a>
                <a href="{{ url('vendor/project') }}" class="btn btn-primary">My Projects</a>
                <a href="{{ url('logout') }}" class="btn btn-danger">Logout</a>
              </div>
          </div>
    </div>
    
</div>

<script>
$(document).ready(function (e) {
    $("#upload_file").on("change", function() {
        event.preventDefault();
			var form = $('#ImageBrowseForm')[0];
			var formData = new FormData(form);
            formData.append("destination", 'profile_picture');
			$.ajax({
				type: "POST",
				enctype: 'multipart/form-data',
				url: "https://karigarbazar.com/api/upload_document",
				// url: "http://localhost/kb/web_karigar_bazar/api/upload_document",
				data: formData,
				processData: false,
				contentType: false,
				cache: false,
				timeout: 600000,
				beforeSend: function() {
					$('.please_wait_loading').show();
				},
				success: function(response){
					$("#user_profile_image").attr('src',response.file_url);
                    store_upload_file(response.file_url, response.file_location);
				},
				complete: function(){
					$("#final_attachment").val(null);
					$('.please_wait_loading').hide();
				}
			});
    });
});

function store_upload_file(file_url,file_location){
    setTimeout(function(){
        $.ajax({
            'url': "https://karigarbazar.com/api/store_user_profile_picture",
            // 'url': "http://localhost/kb/web_karigar_bazar/api/store_user_profile_picture",
            'type': 'POST',
            'data':{'user_id':  "{{ Session::get('user_id') }}", 'file_location': file_location},
            'success': function(response){
                document.location.href = 'https://karigarbazar.com/vendor/profile/set_vendor_picture_session/'+btoa(file_url);
            }
        });
    }, 1000);
}
</script>