@extends('admin.layout.app')
@section('content') 
<section class="content-header">
	<div class="container-fluid my-2">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Edit Color</h1>
			</div>
			<div class="col-sm-6 text-right">
				<a href="{{route('sizes.index')}}" class="btn btn-primary">Back</a>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
	<!-- Default box -->
	<div class="container-fluid">
		<form name="editsizeform" id="editsizeform" method="POST">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label for="name">Name</label>
								<input value="{{$size->name}}" type="text" name="name" id="name" class="form-control"
									placeholder="Name">
							</div>
							<p id="para_name"></p>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="size_code">Size Code</label>
								<input type="text" name="code" id="code" class="form-control"
									placeholder="Size Code" value="{{$size->code}}">
							</div>
							<p id="para_value"></p>
						</div>



						<div class="col-md-6">
							<div class="mb-3">
							<label>Select Product</label>
								<select name="product_id" id="product_id" class="form-control">
									<option value="">Select the Product</option>
									@if($products->isNotEmpty())
										@foreach($products as $product)
											<option value="{{$product->id}}" {{ $size->product_id == $product->id ? 'selected' : '' }}>
												{{$product->title}}
											</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="mb-3">
								<label for="price">Price</label>
								<input type="number" name="price" id="price" class="form-control"
									placeholder="Add Price" value="{{$size->price}}" >
							</div>
							<p id="para_cod"></p>
						</div>


						<div class="col-md-6">
							<div class="mb-3">
								<label for="status">Status</label>
								<select name="status" id="status" class="form-control">
									<option {{($size->status == 1) ? 'selected' : ''}} value="1">Active</option>
									<option {{($size->status == 0) ? 'selected' : ''}} value="0">Block</option>
								</select>
							</div>
							<p id="para_slug"></p>
						</div>
					</div>
				</div>
			</div>
			<div class="pb-5 pt-3">
				<button id="getFormValuesButton" type="submit" class="btn btn-primary">Update</button>
				<a href="{{route('sizes.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
			</div>
		</form>
	</div>
	<!-- /.card -->
</section>
@endsection
@section('customjs') 
<script>
	$(document).ready(function () {
		$("#getFormValuesButton").click(function (event) {
			event.preventDefault();
			var formDataArray = $("#editsizeform").serializeArray();
			$.ajax({
				url: '{{route("sizes.update", $size->id)}}',
				type: 'PUT',
				data: formDataArray, // Use correct form ID
				dataType: 'json', // 'datatype' should be 'dataType'
				success: function (response) {
					if (response['status'] == true) {
						window.location.href = "{{route('sizes.index')}}";
					}
					else {
						if (response['notfound'] == true) {
							window.location.href = "{{route('sizes.index')}}";
						}
						var error = response['error'];
						if (error['name']) {
							$('#para_name').html(error['name']);
						}
						if (error['value']) {
							$('#para_value').html(error['value']);
						}
					}
				},
				error: function (jqXHR, exception) {
					console.log("Something went wrong");
				}
			});
			// Further logic here
		});
	});
</script>
<!-- /.content -->
@endsection