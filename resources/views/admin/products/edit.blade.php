
@extends('admin.layout.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Product</h1>
                </div>

                <div class="col-sm-6 text-right">
                    <a href="{{ route('product.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <form action="" method="POST" name="productform" id="productform">
            @csrf

            <div class="container-fluid">
                <div class="row">
                    {{-- Left Column --}}
                    <div class="col-md-8">
                        {{-- Product Details --}}
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product Details</h2>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title">Title</label>
                                            <input type="text" name="title" id="title" class="form-control"
                                                placeholder="Title" value="{{ old('title', $product->title) }}">
                                            <p class="error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="slug">Slug</label>
                                            <input type="text" name="slug" id="slug" class="form-control"
                                                placeholder="Slug" value="{{ old('slug', $product->slug) }}">
                                            <p class="error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="short_description">Short Description</label>
                                            <textarea name="short_description" id="short_description" cols="30" rows="5"
                                                class="form-control summernote">{{ old('short_description', $product->short_description) }}</textarea>
                                            <p class="error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" cols="30" rows="5"
                                                class="form-control summernote">{{ old('description', $product->description) }}</textarea>
                                            <p class="error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="shipping_return">Shipping Return</label>
                                            <textarea name="shipping_return" id="shipping_return" cols="30" rows="5"
                                                class="form-control summernote">{{ old('shipping_return', $product->shipping_returns) }}</textarea>
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Media --}}
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Media</h2>

                                <div id="image" class="dropzone dz-clickable">
                                    <div class="dz-message needsclick">
                                        Drop files here or click to upload.
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Pricing --}}
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Pricing</h2>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="price">Price</label>
                                            <input type="text" name="price" id="price" class="form-control"
                                                placeholder="Price" value="{{ old('price', $product->price) }}">
                                            <p class="error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="compare_price">Compare at Price</label>
                                            <input type="text" name="compare_price" id="compare_price" class="form-control"
                                                placeholder="Compare Price" value="{{ old('compare_price', $product->compare_price) }}">
                                            <p class="error"></p>

                                            <p class="text-muted mt-3">
                                                To show a reduced price, move the product’s original price into Compare at Price.
                                                Enter a lower value into Price.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Inventory --}}
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Inventory</h2>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sku">SKU (Stock Keeping Unit)</label>
                                            <input type="text" name="sku" id="sku" class="form-control"
                                                placeholder="SKU" value="{{ old('sku', $product->sku) }}">
                                            <p class="error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="barcode">Barcode</label>
                                            <input type="text" name="barcode" id="barcode" class="form-control"
                                                placeholder="Barcode" value="{{ old('barcode', $product->barcode) }}">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column --}}
                    <div class="col-md-4">
                        {{-- Product Status --}}
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product Status</h2>

                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ old('status', $product->status) == 0 ? 'selected' : '' }}>
                                            Block
                                        </option>
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>

                        {{-- Product Category --}}
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product Category</h2>

                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Select a Category</option>

                                        @if ($categories->isNotEmpty())
                                            @foreach ($categories as $cati_data)
                                                <option value="{{ $cati_data->id }}"
                                                    {{ old('category', $product->categories_id) == $cati_data->id ? 'selected' : '' }}>
                                                    {{ $cati_data->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="error"></p>
                                </div>

                                <div class="mb-3">
                                    <label for="sub_category">Level 2 Subcategory</label>
                                    <select name="sub_category" id="sub_category" class="form-control">
                                        <option value="">Select a Level 2 Subcategory</option>

                                        @if ($subcategories->isNotEmpty())
                                            @foreach ($subcategories as $subcati_data)
                                                <option value="{{ $subcati_data->id }}"
                                                    {{ old('sub_category', $product->sub_category_id) == $subcati_data->id ? 'selected' : '' }}>
                                                    {{ $subcati_data->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="error"></p>
                                </div>

                                <div class="mb-3">
                                    <label for="subsub_category">Level 3 Subcategory</label>
                                    <select name="subsub_category" id="subsub_category" class="form-control">
                                        <option value="">Select a Level 3 Subcategory</option>

                                        @if (isset($susubcategories) && $susubcategories->isNotEmpty())
                                            @foreach ($susubcategories as $subsubcati_data)
                                                <option value="{{ $subsubcati_data->id }}"
                                                    {{ old('subsub_category', $product->sub_sub_category_id) == $subsubcati_data->id ? 'selected' : '' }}>
                                                    {{ $subsubcati_data->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>

                        {{-- Product Brand --}}
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product Brand</h2>

                                <div class="mb-3">
                                    <select name="brand" id="brand" class="form-control">
                                        <option value="">Select the Brand</option>

                                        @if ($brands->isNotEmpty())
                                            @foreach ($brands as $brandi)
                                                <option value="{{ $brandi->id }}"
                                                    {{ old('brand', $product->brands_id) == $brandi->id ? 'selected' : '' }}>
                                                    {{ $brandi->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>

                        {{-- Store / Vendor: Only Main Admin --}}
                        @if (Auth::guard('admin')->user()?->role == 2)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Store / Vendor</h2>

                                    <div class="mb-3">
                                        <label for="store_id">Select Store</label>
                                        <select name="store_id" id="store_id" class="form-control">
                                            <option value="">Select Store</option>

                                            @foreach ($stores as $store)
                                                <option value="{{ $store->id }}"
                                                    {{ old('store_id', $product->store_id ?? '') == $store->id ? 'selected' : '' }}>
                                                    {{ $store->store_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="error"></p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Featured Product --}}
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Featured Product</h2>

                                <div class="mb-3">
                                    <select name="is_featured" id="is_featured" class="form-control">
                                        <option value="1" {{ old('is_featured', $product->is_featured) == 1 ? 'selected' : '' }}>
                                            Yes
                                        </option>
                                        <option value="0" {{ old('is_featured', $product->is_featured) == 0 ? 'selected' : '' }}>
                                            No
                                        </option>
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submit Buttons --}}
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('product.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </div>
        </form>
    </section>
@endsection

@section('customjs')
    <script>
        $(".releated-product").select2({
            ajax: {
                url: "{{ route('product.getProducts') }}",
                dataType: "json",
                tags: true,
                multiple: true,
                minimumInputLength: 3,

                processResults: function(data) {
                    return {
                        results: data.tags
                    };
                }
            }
        });

        $("#title").change(function() {
            var element = $(this).val();

            $("button[type=submit]").prop("disabled", true);

            $.ajax({
                url: "{{ route('getslug') }}",
                type: "GET",
                data: {
                    title: element
                },
                dataType: "json",

                success: function(response) {
                    $("button[type=submit]").prop("disabled", false);

                    if (response.status === true) {
                        $("#slug").val(response.slug);
                    } else {
                        console.log("There is no response");
                    }
                }
            });
        });

        $("#productform").submit(function(event) {
            event.preventDefault();

            var formarray = $("#productform").serializeArray();

            $.ajax({
                url: "{{ route('product.update', $product->id) }}",
                type: "PUT",
                data: formarray,
                dataType: "json",

                success: function(response) {
                    if (response.status === true) {
                        window.location.href = "{{ route('product.index') }}";
                    } else {
                        var errors = response.error;

                        $(".error").removeClass("invalid-feedback").html("");
                        $("input, select, textarea").removeClass("is-invalid");

                        $.each(errors, function(key, value) {
                            let field = $("#" + key);
                            let message = Array.isArray(value) ? value[0] : value;

                            field.addClass("is-invalid");

                            field.closest(".mb-3, .form-group")
                                .find("p.error")
                                .addClass("invalid-feedback")
                                .html(message);
                        });
                    }
                },

                error: function() {
                    console.log("Something went wrong");
                }
            });
        });

        $("#category").change(function() {
            var category_id = $(this).val();

            $.ajax({
                url: "{{ route('productsubcat.index') }}",
                type: "GET",
                data: {
                    category_id: category_id
                },
                dataType: "json",

                success: function(response) {
                    $("#sub_category").find("option").not(":first").remove();
                    $("#subsub_category").find("option").not(":first").remove();

                    $.each(response.SubCategory, function(key, item) {
                        $("#sub_category").append(
                            `<option value="${item.id}">${item.name}</option>`
                        );
                    });
                },

                error: function() {
                    console.log("Something went wrong");
                }
            });
        });

        $("#sub_category").change(function() {
            var subcategory_id = $(this).val();

            $.ajax({
                url: "{{ route('productsubcat.subcategory') }}",
                type: "GET",
                data: {
                    subcategory_id: subcategory_id
                },
                dataType: "json",

                success: function(response) {
                    $("#subsub_category").find("option").not(":first").remove();

                    $.each(response.SubSubCategory, function(key, item) {
                        $("#subsub_category").append(
                            `<option value="${item.id}">${item.name}</option>`
                        );
                    });
                },

                error: function() {
                    console.log("Something went wrong");
                }
            });
        });

        Dropzone.autoDiscover = false;

        const dropzone = $("#image").dropzone({
            url: "{{ route('product-images.update') }}",
            maxFiles: 10,
            params: {
                product_id: "{{ $product->id }}"
            },
            paramName: "image",
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",

            headers: {
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
            },

            init: function() {
                const myDropzone = this;
                const existingImages = @json($productImages ?? []);

                existingImages.forEach(function(image) {
                    const mockFile = {
                        name: image.name,
                        size: image.size,
                        url: image.url
                    };

                    myDropzone.emit("addedfile", mockFile);
                    myDropzone.emit("thumbnail", mockFile, image.url);
                    myDropzone.emit("complete", mockFile);
                    myDropzone.files.push(mockFile);
                });

                myDropzone.on("removedfile", function(file) {
                    if (file.url) {
                        $.ajax({
                            url: "{{ route('product-images.destroy') }}",
                            method: "DELETE",
                            data: {
                                _token: $("meta[name='csrf-token']").attr("content"),
                                product_id: "{{ $product->id }}",
                                file_name: file.name
                            },

                            success: function(response) {
                                console.log("Image deleted:", response);
                            },

                            error: function(error) {
                                console.error("Error deleting image:", error);
                            }
                        });
                    }
                });
            }
        });
    </script>
@endsection