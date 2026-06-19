@extends('admin.layout.app')
@section('content') 
	<section class="content-header">
		<div class="container-fluid my-2">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Create Color</h1>
				</div>
				<div class="col-sm-6 text-right">
					<a href="{{route('currency.index')}}" class="btn btn-primary">Back</a>
				</div>
			</div>
		</div>
		<!-- /.container-fluid -->
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="container-fluid">
			<form name="currencyform" id="currencyform" method="POST" action="{{ route('currency.store') }}">
				@csrf
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label for="name">Currency Name</label>
									<input type="text" name="name" id="name" class="form-control"
										placeholder="Currency Name">
								</div>
								<p id="para_name"></p>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label for="code">Currency Code</label>
									<input type="text" name="code" id="code" class="form-control"
										placeholder="Currency Code">
								</div>
								<p id="para_code"></p>
							</div>

							<!-- <div class="col-md-6">
										<div class="mb-3">
											<label for="symbol">Currency Symbol</label>
											<input type="text" name="symbol" id="symbol" class="form-control"
												placeholder="Currency Symbol">
										</div>
										<p id="para_symbol"></p>
									</div> -->

							<div class="col-md-6">
								<div class="mb-3">
									<label for="exchange_rate">Exchange Rate</label>
									<input type="number" name="exchange_rate" id="exchange_rate" class="form-control"
										placeholder="Exchange Rate">
								</div>
								<p id="para_exchange_rate"></p>
							</div>

							<div class="col-md-6">
								<div class="mb-3">
									<label for="status">Status</label>
									<select name="status" id="status" class="form-control">
										<option value="1">Active</option>
										<option value="0">Inactive</option>
									</select>
								</div>
								<p id="para_status"></p>
							</div>
						</div>
					</div>
				</div>
				<div class="pb-5 pt-3">
					<button id="getFormValuesButton" type="submit" class="btn btn-primary">Create</button>
					<a href="{{route('currency.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
				</div>
			</form>
		</div>
		<!-- /.card -->
	</section>
@endsection
@section('customjs') 
	<script>
		$(document).ready(function () {
			$("#currencyform").submit(function (event) {
				event.preventDefault();
				var formDataArray = $(this).serializeArray(); // Correct form ID
				console.log(formDataArray);
				$.ajax({
					url: '{{route("currency.store")}}', // Correct route
					type: 'POST',
					data: formDataArray,
					dataType: 'json',
					success: function (response) {
						if (response['status'] == true) {
							window.location.href = "{{route('currency.index')}}";
						}
						else {
							var errors = response['errors'];
							if (errors['name']) {
								$('#para_name').html(errors['name']);
							}
							if (errors['code']) {
								$('#para_code').html(errors['code']);
							}
							if (errors['symbol']) {
								$('#para_symbol').html(errors['symbol']);
							}
							if (errors['exchange_rate']) {
								$('#para_exchange_rate').html(errors['exchange_rate']);
							}
							if (errors['status']) {
								$('#para_status').html(errors['status']);
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
	<!-- /.content -->
@endsection