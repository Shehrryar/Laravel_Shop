@extends('admin.layout.app')

@section('content') 
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Shipping Management</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="" class="btn btn-primary">Back</a>
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
        <form action="" method="post" id="shipping_from" enctype="multipart/form-data">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">

                                <select name="country" id="country" class="form-control">
                                    <option value="">Select a Country</option>
                                    @if ($countries->isNotEmpty())
                                        @foreach ($countries as $country)
                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                    @endif
                                    <option value="rest_of_the_world">Rest of the World</option>
                                </select>
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <input type="text" name="amount" id="amount" class="form-control" placeholder="amount">

                        </div>
                        <div class="col-md-6">
                            <button type="submit" id="getFormValuesButton" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                            @if ($shipping_charges->isNotEmpty())
                                @foreach ($shipping_charges as $charges)
                                    <tr>

                                        <th>{{$charges->id}}</th>
                                        <th>{{$charges->name}}</th>
                                        <th>{{$charges->amount}}</th>
                                        <th>
                                            <a href="{{route('shipping.edit', $charges->id)}}" class="btn btn-primary">Edit</a>
                                            <a href="javascript:void(0);" onclick="deleteshipping({{$charges->id}})" class="btn btn-danger">Delete</a>
                                        </th>

                                    </tr>
                                @endforeach
                            @endif
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

    $(document).ready(function () {
        $("#shipping_from").submit(function (event) {
            event.preventDefault();
            $.ajax({
                url: '{{route("shipping.store")}}',
                type: 'post',
                data: $(this).serializeArray(), // Use correct form ID
                dataType: 'json', // 'datatype' should be 'dataType'
                success: function (response) {
                    if (response['status'] == true) {
                        window.location.href = "{{route('shipping.create')}}";
                    }
                },
                error: function (jqXHR, exception) {
                    console.log("Something went wrong");
                }
            });
        });
    });


    function deleteshipping(shipping_id) {

        var delurl = '{{route("shipping.delete", "ID")}}'.replace("ID", shipping_id);

        if (confirm("Are you sure you want to delete " + shipping_id)) {
            $.ajax({
                url: delurl,
                type: 'delete',
                data: {}, // Use correct form ID
                dataType: 'json', // 'datatype' should be 'dataType'
                success: function (response) {

                    if (response['status']) {
                        window.location.href = "{{route('shipping.create')}}";
                    }
                }

            });
        }
    }

</script>
<!-- /.content -->
@endsection