@extends('admin.layout.app')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Product Attributes</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href='{{route("productattribute.index")}}' class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <form name="productattributeeditform" id="productattributeeditform" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" value="PUT">
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
                                        <option value="{{$product->id}}" {{ $ProductAttribute_edit->product_id == $product->id ? 'selected' : '' }}>
                                            {{$product->title}}
                                        </option>
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
                                        <option value="{{$colori->id}}" {{ isset($ProductAttribute_edit->color_id) && $ProductAttribute_edit->color_id == $colori->id ? 'selected' : '' }}>
                                            {{$colori->name}}
                                        </option>
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
                            <input type="file" name="image" id="image" class="form-control">
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
                                        <option value="{{$sizei->id}}" {{ isset($ProductAttribute_edit->size_id) && $ProductAttribute_edit->size_id == $sizei->id ? 'selected' : '' }}>
                                            {{$sizei->name}}
                                        </option>
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
                            <input name="stock_quantity" class="form-control" type="number"
                                placeholder="Enter Stock Quantity" id="stock"
                                value="{{$ProductAttribute_edit->quantity}}">
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
                                    value="{{$ProductAttribute_edit->original_price}}">
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
                                placeholder="Compare Price" value="{{$ProductAttribute_edit->saling_price}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Update Attribute</button>
            <a href='{{route("productattribute.index")}}' class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
    </form>
    </div>
</section>
@endsection
@section('customjs')
<script>
    $(document).ready(function () {
        $("#productattributeeditform").submit(function (event) {
            event.preventDefault(); // Prevent default form submission
            var formData = new FormData(this); // Use FormData for file uploads

            $.ajax({
                url: '{{ route("productattribute.update", $ProductAttribute_edit->id) }}',
                type: 'POST', // Use POST, but specify PUT method in form
                data: formData,
                dataType: 'json',
                processData: false,  // Important! Don't let jQuery process the data
                contentType: false,  // Important! Set contentType to false for file uploads
                success: function (response) {
                    if (response.status === true) {
                        window.location.href = "{{ route('productattribute.index') }}";
                    } else {
                        var errors = response.errors;
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
    });

</script>
@endsection