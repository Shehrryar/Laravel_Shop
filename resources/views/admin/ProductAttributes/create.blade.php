@extends('admin.layout.app')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Product Attributes</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href='{{route("product.index")}}' class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <form action="" method="POST" name="productattributeform" id="productattributeform" enctype="multipart/form-data">
        @csrf
        <!-- Row format for three divs in a single row -->
        <div class="row">
            <!-- First Column (4 columns wide) -->

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Select Product</h2>
                        <div class="mb-3">
                            <select name="product_id" id="product_id" class="form-control">
                                <option value="">Select the Product</option>
                                @if($products->isNotEmpty())
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}">{{$product->title}}</option>
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
                        <h2 class="h4 mb-3">Product Color</h2>
                        <div class="mb-3">
                            <select name="color" id="color" class="form-control">
                                <option value="">Select the Color</option>
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
                        <h2 class="h4 mb-3">Product Image</h2>
                        <div class="mb-3">
                        <input type="file" name="image" id="image" class = "form-control">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Second Column (4 columns wide) -->
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Product Size</h2>
                        <div class="mb-3">
                            <select name="size" id="size" class="form-control">
                                <option value="">Select the Size</option>
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
            <!-- Third Column (4 columns wide) -->
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Product Stock</h2>
                        <div class="mb-3">
                            <input name="stock_quantity" class="form-control" type="number" placeholder="Enter Stock Quantity" id="stock">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <!-- First Column for Price -->
                            <div class="mb-3">
                                <label for="price">Price</label>
                                <p class="error"></p>
                                <input type="text" name="price" id="price" class="form-control" placeholder="Price"
                                    value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Compare Price</h2>
                        <div class="mb-3">
                            <input type="text" name="compare_price" id="compare_price" class="form-control"
                                placeholder="Compare Price" value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Add New</button>
            <a href='{{route("product.index")}}' class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
    </form>
    </div>
</section>
@endsection
@section('customjs')
<script>

    $("#productattributeform").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: '{{ route("productattribute.store") }}',
            type: 'post',
            data: formData,
            processData: false, // Important! Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Important! Ensure multipart/form-data is used
            success: function (response) {
                if (response['status'] == true) {
                    window.location.href = "{{route('productattribute.index')}}";
                } else {
                    var errors = response['error'];
                    $(".error").removeClass('invalid-feedback').html('');
                    $("input[type='text']").removeClass('is-invalid');
                    $.each(errors, function (key, value) {
                        $(`#${key}`).addClass("is-invalid").siblings('p').addClass(
                            'invalid-feedback').html(value);
                    });
                }
            },
            error: function () {
                console.log("something went wrong");
            }
        });
    });


</script>
@endsection