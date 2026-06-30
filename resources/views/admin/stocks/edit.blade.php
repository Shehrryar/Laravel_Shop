@extends('admin.layout.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if (Auth::guard('admin')->user()?->role == 3)
                        <h1>Edit My Store Stock</h1>
                    @else
                        <h1>Edit Stock</h1>
                    @endif
                </div>
                <div class="col-sm-6 text-right">
                    <a href='{{ route('stock.index') }}' class="btn btn-primary">Back</a>
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
                                        placeholder="Add Quantity" value = "{{ $stock_edit->quantity }}">
                                    <p id="para_quantity"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="select_product">Select Products</label>
                                    <select id="select_product[]" name="select_product[]" class="form-control">
                                        @if ($products->isNotEmpty())
                                            @foreach ($products as $product)
                                                <option {{ $stock_edit->product_id == $product->id ? 'selected' : '' }}
                                                    value="{{ $product->id }}"> {{ $product->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p id="para_products"></p>

                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="select_color">Select Color</label>
                                    <select name="color_id" id="color" class="form-control">
                                        <option value='0'>Select the Color</option>
                                        @if ($colors->isNotEmpty())
                                            @foreach ($colors as $colori)
                                                <option {{ $stock_edit->color_id == $colori->id ? 'selected' : '' }}
                                                    value="{{ $colori->id }}">{{ $colori->name }}--

                                                    @foreach ($products as $product)
                                                        @if ($product->id == $colori->product_id)
                                                            {{ $product->title }}
                                                        @endif
                                                    @endforeach

                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p id="para_products"></p>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="select_size">Select Size</label>
                                    <select name="size_id" id="size" class="form-control">
                                        <option value="0">Select the Size</option>
                                        @if ($sizes->isNotEmpty())
                                            @foreach ($sizes as $sizei)
                                                <option {{ $stock_edit->size_id == $sizei->id ? 'selected' : '' }}
                                                    value="{{ $sizei->id }}"> {{ $sizei->name }}--
                                                    @foreach ($products as $product)
                                                        @if ($product->id == $sizei->product_id)
                                                            {{ $product->title }}
                                                        @endif
                                                    @endforeach
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p id="para_products"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" class="form-control">
                                        <option {{ $stock_edit->status == 1 ? 'selected' : '' }} value="1">Active
                                        </option>
                                        <option {{ $stock_edit->status == 0 ? 'selected' : '' }} value="0">Block
                                        </option>
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
                    <button type="submit" id="getFormValuesButton" class="btn btn-primary">Update</button>
                    <a href='{{ route('stock.index') }}' class="btn btn-outline-dark ml-3">Cancel</a>
                </div>

            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customjs')
    <script>
        $(document).ready(function() {
            $("#stock_form").submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '{{ route('stock.update', $stock_edit->id) }}',
                    type: 'PUT',
                    data: $(this).serializeArray(), // Use correct form ID
                    dataType: 'json', // 'datatype' should be 'dataType'
                    success: function(response) {
                        if (response['status'] == true) {
                            window.location.href = "{{ route('stock.index') }}";
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
                    error: function(jqXHR, exception) {
                        console.log("Something went wrong");
                    }
                });
                // Further logic here
            });
        });
    </script>
    <!-- /.content -->
@endsection
