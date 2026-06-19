@extends('admin.layout.app')
@section('content')

	<!-- Content Header -->
	<section class="content-header">
		<div class="container-fluid my-2">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Homepage Labels</h1>
				</div>
				<div class="col-sm-6 text-right">
					<a href='{{ route("homepage-labels.create") }}' class="btn btn-primary">Add New Label</a>
				</div>
			</div>
		</div>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">

			@include('admin.message')

			<div class="card">

				<form action="" method="get">
					<div class="card-header">
						<div class="card-tools">
							<div class="input-group input-group" style="width: 250px;">
								<input type="text" value='{{ Request::get("keyword") }}' name="keyword"
									class="form-control float-right" placeholder="Search by Label Name">

								<div class="input-group-append">
									<button type="submit" class="btn btn-default">
										<i class="fas fa-search"></i>
									</button>
								</div>

							</div>
						</div>
					</div>
				</form>

				<div class="card-body table-responsive p-0">
					<table class="table table-hover text-nowrap">
						<thead>
							<tr>
								<th width="60">ID</th>
								<th>Label Name</th>
								<th>Label Key</th>
								<th>Active</th>
								<th>Sort Order</th>
								<th width="100">Action</th>
							</tr>
						</thead>

						<tbody>
							@if($labels->isNotEmpty())
								@foreach($labels as $label)
									<tr>
										<td>{{ $label->id }}</td>
										<td>{{ $label->label_name }}</td>
										<td>{{ $label->label_key }}</td>
										<td>
											@if($label->is_active)
												<span class="badge badge-success">Active</span>
											@else
												<span class="badge badge-danger">Inactive</span>
											@endif
										</td>
										<td>{{ $label->sort_order }}</td>

										<td>
											<!-- Edit -->
											<a href="{{ route('homepage-labels.edit', $label->id) }}">
												<svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg"
													viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
													<path
														d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
													</path>
												</svg>
											</a>

											<!-- Delete -->
											<a href="#" onclick='deleteLabel({{ $label->id }})' class="text-danger">
												<svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg"
													viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
													<path fill-rule="evenodd"
														d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
														clip-rule="evenodd"></path>
												</svg>
											</a>

										</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td colspan="6" class="text-center">No Records Found</td>
								</tr>
							@endif
						</tbody>

					</table>
				</div>

				<div class="card-footer clearfix">
					{{ $labels->links() }}
				</div>

			</div>

		</div>
	</section>

@endsection

@section('customjs')
	<script>
		function deleteLabel(label_id) {
			var url = '{{ route("homepage-labels.delete", "ID") }}'.replace("ID", label_id);

			if (confirm("Are you sure you want to delete: " + label_id)) {

				$.ajax({
					url: url,
					type: 'DELETE',
					data: {},
					dataType: 'json',

					success: function (response) {
						if (response.status) {
							window.location.href = "{{ route('homepage-labels.index') }}";
						}
					},

					error: function (jqXHR) {
						console.log(jqXHR.responseText);
					}
				});
			}
		}
	</script>
@endsection