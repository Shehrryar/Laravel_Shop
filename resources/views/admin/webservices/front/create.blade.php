@extends('admin.layout.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Frontside Webservice</h1>
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
                                <input type="hidden" name="api_side" value="2">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="api_type">API Type</label>
                                <select name="api_type" id="api_type" class="form-control">
                                    <option value="get">GET</option>
                                    <option value="post">POST</option>
                                    <option value="put">PUT</option>
                                    <option value="patch">PATCH</option>
                                    <option value="delete">DELETE</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="api_url">API URL</label>
                                <input type="text" name="api_url" id="api_url" class="form-control"
                                    placeholder="Enter API URL">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="api_name">API Name</label>
                                <input type="text" name="api_name" id="api_name" class="form-control"
                                    placeholder="Enter API name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="api_description">API Description</label>
                                <textarea name="api_description" id="api_description" class="form-control"
                                    placeholder="Enter API description"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="api_payload">API Payload</label>
                                <textarea name="api_payload" id="api_payload" class="form-control"
                                    placeholder="Enter API payload"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="api_response">API Response</label>
                                <textarea name="api_response" id="api_response" class="form-control"
                                    placeholder="Enter API response"></textarea>
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
                                        <th>API Name</th>
                                        <th>API URL</th>
                                        <th>API Type</th>
                                        <th>API Payload</th>
                                        <th>API Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Webservice as $webservice)
                                        <tr>
                                            <td>{{ $webservice->api_name }}</td>
                                            <td>{{ $webservice->api_url }}</td>
                                            <td>{{ strtoupper($webservice->api_type) }}</td>
                                            <td>{{ $webservice->api_payload }}</td>
                                            <td>{{ $webservice->api_description }}</td>
                                            <td>
                                                <button class="btn btn-danger"
                                                    onclick="deleteapi({{ $webservice->id }})">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer clearfix">
            {{ $Webservice->links()}}
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
                url: '{{ route("FrontApi.create") }}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function (response) {
                    if (response['status'] == true) {
                        window.location.href = "{{ route('Frontapi.index') }}";
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