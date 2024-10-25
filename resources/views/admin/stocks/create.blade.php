@extends('admin.layout.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Stock</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href='{{route("stock.index")}}' class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="" method="post" id="stock_form" enctype="multipart/form-data">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quantity">Add Quantity</label>
                                <input type="number" name="quantity" id="quantity" class="form-control"
                                    placeholder="Add Quantity">
                                <p id="para_quantity"></p>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug">Description</label>
                                <textarea class="form-control" name="description" id="description" cols="30"
                                    rows="5"></textarea>
                                <p id="para_description"></p>
                            </div>
                        </div> -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="select_product">Select Products</label>
                                <select id="select_product[]" name="select_product[]" class="form-control">
                                    @if ($products->isNotEmpty())
                                        @foreach ($products as $product)
                                            <option value="{{$product->id}}"> {{ $product->title }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p id="para_products"></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Product Color</h2>
                                    <div class="mb-3">
                                        <select name="color_id" id="color" class="form-control">
                                            <option value='0'>Select the Color</option>
                                            @if($colors->isNotEmpty())
                                                @foreach($colors as $colori)
                                                    <option value="{{$colori->id}}">{{$colori->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Product Size</h2>
                                    <div class="mb-3">
                                        <select name="size_id" id="size" class="form-control">
                                            <option value="0">Select the Size</option>
                                            @if($sizes->isNotEmpty())
                                                @foreach($sizes as $sizei)
                                                    <option value="{{$sizei->id}}">{{$sizei->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="remaning_quantity">Remaining Quantity</label>
                                <input type="number" name="remaning_quantity" id="remaning_quantity"
                                    class="form-control" placeholder="Remaining Quantity">
                                <p id="para_remaning_quantity"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sold_quantity">Sold Quantity</label>
                                <input type="number" name="sold_quantity" id="sold_quantity" class="form-control"
                                    placeholder="Sold Quantity">
                                <p id="para_sold_quantity"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>
                                </select>
                                <p id="para_status"></p>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="mb-3">
                                <label for="select_Category">Select Category</label>
                                <select id="select_Category" name="select_Category" class="form-control">
                                    <option value="1">Category 1</option>
                                    <option value="0">Category 2</option>
                                </select>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" id="getFormValuesButton" class="btn btn-primary">Create</button>
                <a href='{{route("stock.index")}}' class="btn btn-outline-dark ml-3">Cancel</a>
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
        $("#stock_form").submit(function (event) {
            event.preventDefault();
            $.ajax({
                url: '{{route("stock.store")}}',
                type: 'POST',
                data: $(this).serializeArray(), // Use correct form ID
                dataType: 'json', // 'datatype' should be 'dataType'
                success: function (response) {
                    if (response['status'] == true) {
                        window.location.href = "{{route('stock.index')}}";
                    } else {
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