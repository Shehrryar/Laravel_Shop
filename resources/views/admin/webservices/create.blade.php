@extends('admin.layout.app')
@section('content') 
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Webservice</h1>
            </div>
            <div class="col-sm-6 text-right">
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        @include('admin.message')
        <form id="webservice_form" method="post" action="">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Webservice</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="route_name">Route Name</label>
                            <input type="text" name="route_name" id="route_name" class="form-control"
                                placeholder="Enter route name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="route_url">URL</label>
                            <input type="text" name="route_url" id="route_url" class="form-control"
                                placeholder="Enter URL">
                        </div>
                        <div class="col-md-12 text-right">
                            <button type="submit" id="getFormValuesButton" class="btn btn-success">Create</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">Webservices List</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Route Name</th>
                                    <th>URL</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Add dynamic rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
@section('customjs') 

<script>
        $("#webservice_form").submit(function (event) {
            event.preventDefault();
            $.ajax({
                url: '{{ route("webservice.create") }}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function (response) {
                    if (response['status'] == true) {

                    }
                },
                error: function (jqXHR, exception) {
                    console.log("Something went wrong");
                }
            });
    });

    function deleteshipping(shipping_id) {
        var delurl = '{{ route("shipping.delete", "ID") }}'.replace("ID", shipping_id);
        if (confirm("Are you sure you want to delete " + shipping_id + "?")) {
            $.ajax({
                url: delurl,
                type: 'delete',
                data: {},
                dataType: 'json',
                success: function (response) {
                    if (response['status']) {
                        window.location.href = "{{ route('shipping.create') }}";
                    }
                }
            });
        }
    }
</script>

<!-- /.content -->
@endsection