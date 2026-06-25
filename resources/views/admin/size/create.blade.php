@extends('admin.layout.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if (Auth::guard('admin')->user()?->role == 3)
                        <h1>Create My Store Size</h1>
                    @else
                        <h1>Create Size</h1>
                    @endif
                </div>

                <div class="col-sm-6 text-right">
                    <a href="{{ route('sizes.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <form name="sizesform" id="sizesform" method="POST">
                @csrf

                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                    <p id="para_name" class="text-danger error-message"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code">Size Code</label>
                                    <input type="text" name="code" id="code" class="form-control" placeholder="Size Code">
                                    <p id="para_code" class="text-danger error-message"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="product_id">Select Product</label>
                                    <select name="product_id" id="product_id" class="form-control">
                                        <option value="">Select the Product</option>

                                        @if ($products->isNotEmpty())
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">
                                                    {{ $product->title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p id="para_product_id" class="text-danger error-message"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price">Price</label>
                                    <input type="number" name="price" id="price" class="form-control" placeholder="Add Price">
                                    <p id="para_price" class="text-danger error-message"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                    <p id="para_status" class="text-danger error-message"></p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button id="getFormValuesButton" type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('sizes.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('customjs')
    <script>
        $(document).ready(function() {
            $("#sizesform").on("submit", function(event) {
                event.preventDefault();

                // Clear old errors
                $(".error-message").html("");
                $(".form-control").removeClass("is-invalid");

                $.ajax({
                    url: "{{ route('sizes.store') }}",
                    type: "POST",
                    data: $("#sizesform").serialize(),
                    dataType: "json",

                    success: function(response) {
                        if (response.status === true) {
                            window.location.href = "{{ route('sizes.index') }}";
                            return;
                        }

                        if (response.exist === true) {
                            alert(response.message);
                            return;
                        }

                        let errors = response.errors || response.error || {};

                        $.each(errors, function(field, message) {
                            let errorMessage = Array.isArray(message) ? message[0] : message;

                            $("#" + field).addClass("is-invalid");
                            $("#para_" + field).html(errorMessage);
                        });
                    },

                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert("Something went wrong. Please check console.");
                    }
                });
            });
        });
    </script>
@endsection