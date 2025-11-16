@extends('admin.layout.app')
@section('content')
	<section class="content-header">
		<div class="container-fluid my-2">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Edit Color</h1>
				</div>
				<div class="col-sm-6 text-right">
					<a href="{{route('colorss.index')}}" class="btn btn-primary">Back</a>
				</div>
			</div>
		</div>
		<!-- /.container-fluid -->
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="container-fluid">
			<form name="editcolorsform" id="editcolorsform" method="POST">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label for="name">Name</label>
									<input value="{{$color->name}}" type="text" name="name" id="name" class="form-control"
										placeholder="Name">
								</div>
								<p id="para_name"></p>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label for="hex_value">Hex Value</label>
									<input type="color" name="value" id="value" class="form-control" placeholder="Hex Value"
										value="{{$color->value}}">
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
												<option value="{{$product->id}}" {{ $color->product_id == $product->id ? 'selected' : '' }}>
													{{$product->title}}
												</option>
											@endforeach
										@endif
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label>Select Size</label>
									<select name="size_id" id="size_id" class="form-control">
										<option value="">Select the Size</option>
										@if($Size->isNotEmpty() && $products->isNotEmpty())
											@foreach($Size as $size_pro)
												@php
													$product = $products->firstWhere('id', $size_pro->product_id);
												@endphp
												@if ($product)
													<option value="{{$size_pro->id}}" {{$color->size_id == $size_pro->id ? 'selected' : '' }}>
														{{$size_pro->name}} - {{$product->title}}
													</option>
												@endif
											@endforeach
										@endif
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label for="price">Price</label>
									<input type="number" name="price" id="price" class="form-control"
										placeholder="Add Price" value="{{$color->price}}">
								</div>
								<p id="para_cod"></p>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label for="status">Status</label>
									<select name="status" id="status" class="form-control">
										<option {{($color->status == 1) ? 'selected' : ''}} value="1">Active</option>
										<option {{($color->status == 0) ? 'selected' : ''}} value="0">Block</option>
									</select>
								</div>
								<p id="para_slug"></p>
							</div>
						</div>
					</div>
				</div>
				<div class="pb-5 pt-3">
					<button id="getFormValuesButton" type="submit" class="btn btn-primary">Update</button>
					<a href="{{route('colorss.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
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
				var formDataArray = $("#editcolorsform").serializeArray();
				$.ajax({
					url: '{{route("colorss.update", $color->id)}}',
					type: 'PUT',
					data: formDataArray, // Use correct form ID
					dataType: 'json', // 'datatype' should be 'dataType'
					success: function (response) {
						if (response['status'] == true) {
							window.location.href = "{{route('colorss.index')}}";
						}
						else {
							if (response['exist'] == true) {
								alert(response['message']);
							} else {
								var errors = response['errors'];
								if (errors['name']) {
									// $('#name').addClass('is-valid').siblings('p').addClass('invalid-feedback').html(errors['name']);
									$('#para_name').html(errors['name']);
								}
								if (errors['value']) {
									// $('#name').addClass('is-valid').siblings('p').addClass('invalid-feedback').html(errors['name']);
									$('#para_value').html(errors['value']);
								}
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