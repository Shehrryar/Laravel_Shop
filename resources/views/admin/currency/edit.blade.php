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
			<form name="editcurrencyform" id="editcurrencyform" method="POST">
			@csrf
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label for="name">Name</label>
								<input value="{{$currency->name}}" type="text" name="name" id="name" class="form-control"
									placeholder="Name">
							</div>
							<p id="para_name"></p>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="code">Code</label>
								<input type="text" name="code" id="code" class="form-control" placeholder="Code"
									value="{{$currency->code}}">
							</div>
							<p id="para_code"></p>
						</div>

						<!-- <div class="col-md-6">
							<div class="mb-3">
								<label for="symbol">Symbol</label>
								<input type="text" name="symbol" id="symbol" class="form-control" placeholder="Symbol"
									value="{{$currency->symbol}}">
							</div>
							<p id="para_symbol"></p>
						</div> -->

						<div class="col-md-6">
							<div class="mb-3">
								<label for="exchange_rate">Exchange Rate</label>
								<input type="number" step="0.01" name="exchange_rate" id="exchange_rate"
									class="form-control" placeholder="Exchange Rate" value="{{$currency->exchange_rate}}">
							</div>
							<p id="para_exchange_rate"></p>
						</div>

						<div class="col-md-6">
							<div class="mb-3">
								<label for="status">Status</label>
								<select name="status" id="status" class="form-control">
									<option {{($currency->status == 1) ? 'selected' : ''}} value="1">Active</option>
									<option {{($currency->status == 0) ? 'selected' : ''}} value="0">Inactive</option>
								</select>
							</div>
							<p id="para_status"></p>
						</div>
					</div>
				</div>
			</div>
			<div class="pb-5 pt-3">
				<button id="getFormValuesButton" type="submit" class="btn btn-primary">Update</button>
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
			$("#editcurrencyform").submit(function (event) {
				event.preventDefault();
				var formDataArray = $(this).serializeArray(); // Use correct form ID
				$.ajax({
					url: '{{route("currency.update", $currency->id)}}',
					type: 'PUT',
					data: formDataArray,
					dataType: 'json',
					success: function (response) {
						if (response['status'] == true) {
							window.location.href = "{{route('currency.index')}}";
						} else {
							if (response['notfound'] == true) {
								window.location.href = "{{route('currency.index')}}";
							}
							var error = response['error'];
							if (error['name']) {
								$('#para_name').html(error['name']);
							}
							if (error['code']) {
								$('#para_code').html(error['code']);
							}
							if (error['symbol']) {
								$('#para_symbol').html(error['symbol']);
							}
							if (error['exchange_rate']) {
								$('#para_exchange_rate').html(error['exchange_rate']);
							}
							if (error['status']) {
								$('#para_status').html(error['status']);
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