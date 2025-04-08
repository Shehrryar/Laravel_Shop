@extends('admin.layout.app')
@section('content')
	<section class="content-header">
		<div class="container-fluid my-2">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Edit Promotion</h1>
				</div>
				<div class="col-sm-6 text-right">
					<a href="{{route('promotions.index')}}" class="btn btn-primary">Back</a>
				</div>
			</div>
		</div>
		<!-- /.container-fluid -->
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="container-fluid">
			<form name="editpromotionform" id="editpromotionform" method="POST">
				@csrf
				@method('PUT')
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="mb-3">
									<label for="description">Description</label>
									<textarea name="description" id="description" class="form-control"
										placeholder="Enter promotion description">{{$promotion->description}}</textarea>
								</div>
								<p id="para_description"></p>
							</div>
						</div>
					</div>
				</div>
				<div class="pb-5 pt-3">
					<button id="getFormValuesButton" type="submit" class="btn btn-primary">Update</button>
					<a href="{{route('promotions.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
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
				var formDataArray = $("#editpromotionform").serializeArray();
				$.ajax({
					url: '{{route("promotions.update", $promotion->id)}}',
					type: 'PUT',
					data: formDataArray,
					dataType: 'json',
					success: function (response) {
						if (response['status'] == true) {
							window.location.href = "{{route('promotions.index')}}";
						} else {
							var error = response['error'];
							if (error['description']) {
								$('#para_description').html(error['description']);
							}
						}
					},
					error: function (jqXHR, exception) {
						console.log("Something went wrong");
					}
				});
			});
		});
	</script>
@endsection