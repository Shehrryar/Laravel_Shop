@extends('admin.layout.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if (Auth::guard('admin')->user()?->role == 3)
                        <h1>Edit My Store Color</h1>
                    @else
                        <h1>Edit Color</h1>
                    @endif
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('colorss.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <form name="editcolorsform" id="editcolorsform" method="POST">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input value="{{ $color->name }}" type="text" name="name" id="name" class="form-control" placeholder="Name">
                                </div>
                                <p class="text-danger" id="para_name"></p>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="value">Hex Value</label>
                                    <input type="color" name="value" id="value" class="form-control" value="{{ $color->value }}">
                                </div>
                                <p class="text-danger" id="para_value"></p>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Select Product</label>
                                    <select name="product_id" id="product_id" class="form-control">
                                        <option value="">Select the Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" {{ $color->product_id == $product->id ? 'selected' : '' }}>
                                                {{ $product->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="text-danger" id="para_product_id"></p>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Select Size</label>
                                    <select name="size_id" id="size_id" class="form-control">
                                        <option value="">Select the Size</option>
                                        @foreach ($Size as $size_pro)
                                            @php
                                                $product = $products->firstWhere('id', $size_pro->product_id);
                                            @endphp

                                            @if ($product)
                                                <option value="{{ $size_pro->id }}" data-product-id="{{ $size_pro->product_id }}"
                                                    {{ $color->size_id == $size_pro->id ? 'selected' : '' }}>
                                                    {{ $size_pro->name }} - {{ $product->title }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <p class="text-danger" id="para_size_id"></p>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price">Price</label>
                                    <input type="number" name="price" id="price" class="form-control" placeholder="Add Price"
                                        value="{{ $color->price }}" step="0.01">
                                </div>
                                <p class="text-danger" id="para_price"></p>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option {{ $color->status == 1 ? 'selected' : '' }} value="1">Active</option>
                                        <option {{ $color->status == 0 ? 'selected' : '' }} value="0">Block</option>
                                    </select>
                                </div>
                                <p class="text-danger" id="para_status"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button id="getFormValuesButton" type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('colorss.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('customjs')
    <script>
        $(document).ready(function() {
            function clearErrors() {
                $('#para_name, #para_value, #para_product_id, #para_size_id, #para_price, #para_status').html('');
            }

            function showErrors(errors) {
                $.each(errors, function(key, value) {
                    $('#para_' + key).html(Array.isArray(value) ? value[0] : value);
                });
            }

            function filterSizesByProduct(keepSelected = false) {
                var productId = $('#product_id').val();
                var currentSizeId = $('#size_id').val();

                $('#size_id option').each(function() {
                    var optionProductId = $(this).data('product-id');
                    if (!optionProductId || optionProductId == productId) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                if (!keepSelected) {
                    $('#size_id').val('');
                } else {
                    $('#size_id').val(currentSizeId);
                }
            }

            filterSizesByProduct(true);
            $('#product_id').on('change', function() {
                filterSizesByProduct(false);
            });

            $('#getFormValuesButton').click(function(event) {
                event.preventDefault();
                clearErrors();

                $.ajax({
                    url: '{{ route('colorss.update', $color->id) }}',
                    type: 'POST',
                    data: $('#editcolorsform').serializeArray(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === true) {
                            window.location.href = "{{ route('colorss.index') }}";
                            return;
                        }

                        if (response.notfound === true) {
                            window.location.href = "{{ route('colorss.index') }}";
                            return;
                        }

                        if (response.exist === true) {
                            alert(response.message);
                            return;
                        }

                        showErrors(response.errors || {});
                    },
                    error: function(jqXHR) {
                        console.log(jqXHR.responseText);
                        alert('Something went wrong.');
                    }
                });
            });
        });
    </script>
@endsection
