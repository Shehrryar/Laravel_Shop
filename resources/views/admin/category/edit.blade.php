
@extends('admin.layout.app')

@section('content') 
				<!-- Content Header (Page header) -->
				<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Edit Category</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href='{{route("categories.index")}}' class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
						<form action="" method="post" id="category_from" enctype="multipart/form-data">

						<div class="card">
							<div class="card-body">								
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label for="name">Name</label>
											<input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{$cat_edit->name}}">
											<p id="para_name"></p>	
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="slug">Slug</label>
											<input readonly type="text" name="slug" id="slug" class="form-control" placeholder="Slug" value="{{$cat_edit->slug}}">	
											<p id="para_slug" ></p>
										</div>
									</div>	

									<div class="col-md-6">
										<div class="mb-3">
											<input type="hidden" name="image_id" id="image_id" value="">
											<label for="image">Image</label>
											<div id="image" class="dropzone dz-clickable">
    <div class="dz-message needsclick">    
        <br>Drop files here or click to upload.<br><br>                                            
    </div>
</div>
										</div>
										@if(!empty($cat_edit->image))
										<div>

											<img width="250" src="{{asset('upload/category/'.$cat_edit->image)}}">
										</div>
										@endif
									</div>

									<div class="col-md-6">
										<div class="mb-3">
											<label for="status">Status</label>

											<select id="status" name="status" class="form-control">
							<option {{($cat_edit->status == 1) ? 'selected' : ''}} value="1" >Active</option>
												<option {{($cat_edit->status == 0) ? 'block' : ''}}  value="0" >
													Block
												</option>
											</select>
						
										</div>
									</div>								
								</div>
							</div>							
						</div>
						<div class="pb-5 pt-3">
							<button type="submit" id="getFormValuesButton" class="btn btn-primary">Create</button>
							<a href='{{route("categories.index")}}' class="btn btn-outline-dark ml-3">Cancel</a>
						</div>

						</form>
					</div>
					<!-- /.card -->
				</section>
				<!-- /.content -->
@endsection

@section('customjs') 
<script >

$(document).ready(function(){

	    $("#getFormValuesButton").click(function(event){
	    	 event.preventDefault();
 		var formDataArray = $("#category_from").serializeArray();
	$.ajax({
    url: '{{route("categories.update", $cat_edit->id)}}',
    type: 'PUT',
    data: formDataArray, // Use correct form ID
    dataType: 'json', // 'datatype' should be 'dataType'
    success: function(response) {

    	
    	if(response['status']==true){
    		window.location.href= "{{route('categories.index')}}";
    	}
    	else{

    		if(response['not found']== true){
    			window.location.href= "{{route('categories.index')}}";
    		}
     var errors= response['errors'];
       if(errors['name']){
       	// $('#name').addClass('is-valid').siblings('p').addClass('invalid-feedback').html(errors['name']);

       		$('#para_name').html(errors['name']);
       	
       }
              if(errors['slug']){
       	// $('#name').addClass('is-valid').siblings('p').addClass('invalid-feedback').html(errors['name']);

       		$('#para_slug').html(errors['slug']);
       	}

       	}


    },
    error: function(jqXHR, exception) {
        console.log("Something went wrong");
    }
});   
        // Further logic here
    });


	$("#name").change(function(){

	var element = $(this).val();

 	$("button[type=submit]").prop('disabled',true);


	$.ajax({
    url: '{{route("getslug")}}',
    type: 'get',
    data: {title:element}, // Use correct form ID
    dataType: 'json', // 'datatype' should be 'dataType'
    success: function(response) {
 		$("button[type=submit]").prop('disabled',false);
    	
    	if(response['status']==true){
    		
    		$("#slug").val(response['slug']);
    	}else{
    		console.log("there is not response");
    	}
    },
 
}); 
	
	});
});


Dropzone.autoDiscover = false;    
const dropzone = $("#image").dropzone({ 
    init: function() {
        this.on('addedfile', function(file) {
            if (this.files.length > 1) {
                this.removeFile(this.files[0]);
            }
        });
    },
    url:  "{{ route('temp-images.create') }}",
    maxFiles: 1,
    paramName: 'image',
    addRemoveLinks: true,
    acceptedFiles: "image/jpeg,image/png,image/gif",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }, success: function(file, response){
        $("#image_id").val(response.image_id);
        //console.log(response)
    }
});


</script>
				<!-- /.content -->
@endsection