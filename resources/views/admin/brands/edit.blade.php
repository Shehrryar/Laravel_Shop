
@extends('admin.layout.app')

@section('content') 

<section class="content-header">					
	<div class="container-fluid my-2">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Edit Brand</h1>
			</div>
			<div class="col-sm-6 text-right">
				<a href="{{route('brands.index')}}" class="btn btn-primary">Back</a>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
	<!-- Default box -->
	<div class="container-fluid">
		<form name="editbrandsform" id="editbrandsform" method="POST">

			<div class="card">
				<div class="card-body">								
					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label for="name">Name</label>
				<input value="{{$brand->name}}" type="text" name="name" id="name" class="form-control" placeholder="Name">	
							</div>
							<p id="para_name"></p>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="email">Slug</label>
								<input readonly type="text" name="slug" id="slug" class="form-control" placeholder="Slug" value="{{$brand->slug}}">	
							</div>
							<p id="para_slug"></p>

						</div>	

						<div class="col-md-6">
							<div class="mb-3">
								<label for="status">Status</label>
								<select name="status" id="status" class="form-control" >
<option {{($brand->status == 1) ? 'selected' : ''}} value="1">Active</option>
<option {{($brand->status == 0) ? 'selected' : ''}} value="0">Block</option>
									
								</select>
							</div>
							<p id="para_slug"></p>

						</div>								
					</div>
				</div>							
			</div>
			<div class="pb-5 pt-3">
				<button id="getFormValuesButton" type="submit" class="btn btn-primary">Update</button>
				<a href="{{route('brands.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
			</div>

		</form>
	</div>
	<!-- /.card -->
</section>
@endsection

@section('customjs') 
<script >

	$(document).ready(function(){

		$("#getFormValuesButton").click(function(event){
			event.preventDefault();
			var formDataArray = $("#editbrandsform").serializeArray();
			$.ajax({
				url: '{{route("brands.update", $brand->id)}}',
				type: 'PUT',
    data: formDataArray, // Use correct form ID
    dataType: 'json', // 'datatype' should be 'dataType'
    success: function(response) {
    	if(response['status']==true){
    	window.location.href= "{{route('brands.index')}}";
    	}
    	else{
    		if(response['notfound']==true){
    	window.location.href= "{{route('brands.index')}}";

    		}

    		var error = response['error'];
    		if(error['name']){
    			$('#para_name').html(error['name']);

    		}
    		if(error['slug']){
    			$('#para_slug').html(error['slug']);
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
</script>
<!-- /.content -->
@endsection