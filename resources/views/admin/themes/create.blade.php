@extends('admin.layout.app')
@section('content')
	<section class="content-header">
		<div class="container-fluid my-2">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Create Theme</h1>
				</div>
				<div class="col-sm-6 text-right">
					<a href="{{route('themes.index')}}" class="btn btn-primary">Back</a>
				</div>
			</div>
		</div>
	</section>
	<section class="content">
		<div class="container-fluid">
			<form name="themeform" id="themeform" method="POST">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label for="theme_name">Theme Name</label>
									<input type="text" name="theme_name" id="theme_name" class="form-control" placeholder="Theme Name">
								</div>
								<p id="para_theme_name"></p>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label for="theme_color_code">Theme Color Code</label>
									<input type="color" name="theme_color_code" id="theme_color_code" class="form-control" placeholder="Theme Color Code">
								</div>
								<p id="para_theme_color_code"></p>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label for="theme_status">Theme Status</label>
									<select name="theme_status" id="theme_status" class="form-control">
										<option value="1">Active</option>
										<option value="0">Inactive</option>
									</select>
								</div>
								<p id="para_theme_status"></p>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label for="theme_isset_status">Is Set Status</label>
									<select name="theme_isset_status" id="theme_isset_status" class="form-control">
										<option value="1">Yes</option>
										<option value="0">No</option>
									</select>
								</div>
								<p id="para_theme_isset_status"></p>
							</div>
						</div>
					</div>
				</div>
				<div class="pb-5 pt-3">
					<button id="getFormValuesButton" type="submit" class="btn btn-primary">Create</button>
					<a href="{{route('themes.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
				</div>
			</form>
		</div>
	</section>
@endsection
@section('customjs')
	<script>
		$(document).ready(function () {
			$("#getFormValuesButton").click(function (event) {
				event.preventDefault();
				var formDataArray = $("#themeform").serializeArray();
				$.ajax({
					url: '{{route("themes.store")}}',
					type: 'POST',
					data: formDataArray,
					dataType: 'json',
					success: function (response) {
						if (response['status'] == true) {
							window.location.href = "{{route('themes.index')}}";
						} else {
							var errors = response['errors'] || {};
							if (errors['theme_name']) {
								$('#para_theme_name').html(errors['theme_name']);
							}
							if (errors['theme_color_code']) {
								$('#para_theme_color_code').html(errors['theme_color_code']);
							}
							if (errors['theme_status']) {
								$('#para_theme_status').html(errors['theme_status']);
							}
							if (errors['theme_isset_status']) {
								$('#para_theme_isset_status').html(errors['theme_isset_status']);
							}
						}
					},
					error: function () {
						console.log("Something went wrong");
					}
				});
			});
		});
	</script>
@endsection
