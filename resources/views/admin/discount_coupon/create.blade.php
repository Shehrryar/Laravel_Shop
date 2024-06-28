@extends('admin.layout.app')

@section('content') 
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid my-2">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Create Coupon Code</h1>
			</div>
			<div class="col-sm-6 text-right">
				<a href='' class="btn btn-primary">Back</a>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
	<!-- Default box -->
	<div class="container-fluid">
		<form action="" method="post" id="discout_form" enctype="multipart/form-data">

			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label for="name">Code</label>
								<input type="text" name="code" id="code" class="form-control" placeholder="Coupon Code">
								<p id="para_name"></p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="slug">Name</label>
								<input type="text" name="name" id="name" class="form-control"
									placeholder="Coupon Code Name">
								<p id="para_slug"></p>
							</div>
						</div>

						<div class="col-md-6">
							<div class="mb-3">
								<label for="slug">Max Uses</label>
								<input type="number" name="max_uses" id="max_uses" class="form-control"
									placeholder="Max Uses">
								<p id="para_slug"></p>
							</div>
						</div>

						<div class="col-md-6">
							<div class="mb-3">
								<label for="slug">Max Uses User</label>
								<input type="number" name="max_uses_user" id="max_uses_user" class="form-control"
									placeholder="Max Uses User">
								<p id="para_slug"></p>
							</div>
						</div>



						<div class="col-md-6">
							<div class="mb-3">
								<label for="status">Type</label>

								<select id="type" name="type" class="form-control">
									<option value="percent">Percent</option>
									<option value="fixed">Fixed</option>
								</select>

							</div>
						</div>



						<div class="col-md-6">
							<div class="mb-3">
								<label for="slug">Discount Amount</label>
								<input type="number" name="discount_amount" id="discount_amount" class="form-control"
									placeholder="Discount Amount">
								<p id="para_slug"></p>
							</div>
						</div>


						<div class="col-md-6">
							<div class="mb-3">
								<label for="slug">Min Amount</label>
								<input type="number" name="min_amount" id="min_amount" class="form-control"
									placeholder="Min Amount">
								<p id="para_slug"></p>
							</div>
						</div>

						<div class="col-md-6">
							<div class="mb-3">
								<label for="status">Status</label>

								<select id="status" name="status" class="form-control">
									<option value="1">Active</option>
									<option value="0">Block</option>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="mb-3">
								<label for="slug">Starts At</label>
								<input type="datetime-local" name="starts_at" id="starts_at" class="form-control"
									placeholder="Starts At">
								<p id="para_slug"></p>
							</div>
						</div>


						<div class="col-md-6">
							<div class="mb-3">
								<label for="slug">Expires At</label>
								<input type="datetime-local" name="expires_at" id="expires_at" class="form-control"
									placeholder="Expires At">
								<p id="para_slug"></p>
							</div>
						</div>

						<div class="col-md-6">
							<div class="mb-3">
							<label for="slug">Description</label>
							<textarea class="form-control" name="description" id="description" cols = "30" rows="5"></textarea>
								<p id="para_slug"></p>
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
<script>

	$(document).ready(function () {

			$("#discout_form").submit(function (event) {
			event.preventDefault();
			$.ajax({
				url: '{{route("coupon.store")}}',
				type: 'POST',
				data: $(this).serializeArray(), // Use correct form ID
				dataType: 'json', // 'datatype' should be 'dataType'
				success: function (response) {
					if (response['status'] == true) {

					}
					else {
						var errors = response['errors'];
						if (errors['code']) {
							// $('#name').addClass('is-valid').siblings('p').addClass('invalid-feedback').html(errors['name']);

							$('#para_name').html(errors['code']);

						}
						if (errors['discount_amount']) {
							// $('#name').addClass('is-valid').siblings('p').addClass('invalid-feedback').html(errors['name']);

							$('#para_slug').html(errors['discount_amount']);
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