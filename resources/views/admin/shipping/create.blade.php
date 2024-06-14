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

    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customjs') 
<script>

    $(document).ready(function () {


        alert('dklfjkljadl;fjkl;adjfkl;j');
        $("shipping_from").submit(function (event) {
            event.preventDefault();
            $.ajax({
                url: '{{route("shipping.store")}}',
                type: 'POST',
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
</script>
<!-- /.content -->
@endsection