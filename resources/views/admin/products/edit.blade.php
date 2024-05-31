@extends('admin.layout.app')

@section('content')


<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Product</h1>
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
    <!-- Default box -->
    <form action="" method="POST" name="productform" id="productform">
        @csrf
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" id="title" class="form-control"
                                            placeholder="Title" value="{{$product->title}}">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="Slug">Slug</label>
                                        <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug"
                                            value="{{$product->slug}}">
                                        <p class="error"></p>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="short_description">Short Description</label>
                                        <textarea name="short_description" id="short_description" cols="30" rows="10"
                                            class="summernote">{{$product->short_description}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" cols="30" rows="10"
                                            class="summernote">{{$product->description}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="shipping_return">Shipping Return</label>
                                        <textarea name="shipping_return" id="shipping_return" cols="30" rows="10"
                                            class="summernote">{{$product->shipping_returns}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Media</h2>
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">
                                    <br>Drop files here or click to upload.<br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="productgallery">
                        @if($productimage->isNotEmpty())
                            @foreach($productimage as $image)
                                <div class="card" id="image_row_{{$image->id}}" style="width: 18rem;">
                                    <input type="hidden" name="image_array[]" value="{{$image->id}}">
                                    <img class="card-img-top" src="{{asset('upload/products/' . $image->image)}}"
                                        alt="Card image cap">
                                    <div class="card-body">
                                        <a href="javascript:void(0)" onclick="delete_image({{$image->id}})"
                                            class="btn btn-danger">Delete</a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Pricing</h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="price">Price</label>
                                        <p class="error"></p>
                                        <input type="text" name="price" id="price" class="form-control"
                                            placeholder="Price" value="{{$product->price}}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="compare_price">Compare at Price</label>
                                        <input type="text" name="compare_price" id="compare_price" class="form-control"
                                            placeholder="Compare Price" value="{{$product->compare_price}}">
                                        <p class="text-muted mt-3">
                                            To show a reduced price, move the product’s original price into Compare at
                                            price. Enter a lower value into Price.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Inventory</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sku">SKU (Stock Keeping Unit)</label>
                                        <input type="text" name="sku" id="sku" class="form-control" placeholder="sku"
                                            value="{{$product->sku}}">
                                        <p class="error"></p>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="barcode">Barcode</label>
                                        <input type="text" name="barcode" id="barcode" class="form-control"
                                            placeholder="Barcode" value="{{$product->barcode}}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="hidden" id="track_qty" name="track_qty" value="No">
                                            <input class="custom-control-input" type="checkbox" id="track_qty"
                                                name="track_qty" value="Yes" {{($product->track_qty == 'Yes') ? 'checked' : ''}}>
                                            <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                            <p class="error"></p>

                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <input type="number" min="0" name="qty" id="qty" class="form-control"
                                            placeholder="Qty" value="{{$product->qty}}">
                                        <p class="error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Product status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option {{($product->status == 1) ? 'selected' : ''}} value="1">Active</option>
                                    <option {{($product->status == 0) ? 'selected' : ''}} value="0">Block</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h2 class="h4  mb-3">Product category</h2>
                            <div class="mb-3">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select a Category</option>

                                    @if($categories->isNotEmpty())

                                        @foreach($categories as $cati_data)

                                            <option {{($product->categories_id == $cati_data->id) ? 'selected' : ''}}
                                                value="{{$cati_data->id}}">{{$cati_data->name}}</option>

                                        @endforeach

                                    @endif
                                </select>
                                <p class="error"></p>
                            </div>
                            <div class="mb-3">
                                <label for="category">Sub category</label>
                                <select name="sub_category" id="sub_category" class="form-control">
                                    <option value="">Select a Sub Category</option>
                                    @if($subcategories->isNotEmpty())

                                        @foreach($subcategories as $subcati_data)

                                            <option {{($product->sub_category_id == $subcati_data->id) ? 'selected' : ''}}
                                                value="{{$subcati_data->id}}">{{$subcati_data->name}}</option>

                                        @endforeach

                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Product brand</h2>
                            <div class="mb-3">
                                <select name="brand" id="brand" class="form-control">
                                    <option value="">Select the Brand</option>
                                    @if($brands->isNotEmpty())
                                        @foreach($brands as $brandi)
                                            <option {{($product->brands_id == $brandi->id) ? 'selected' : ''}}
                                                value="{{$brandi->id}}">{{$brandi->name}}</option>
                                        @endforeach
                                    @endif 

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Featured product</h2>
                            <div class="mb-3">
                                <select name="is_featured" id="is_featured" class="form-control">
                                    <option {{($product->is_featured == 'Yes') ? 'selected' : ''}} value="Yes">Yes
                                    </option>
                                    <option {{($product->is_featured == 'No') ? 'selected' : ''}} value="No">No</option>

                                </select>
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Related product</h2>
                            <div class="mb-3">
                                <select multiple class="releated-product w-100" name="related_product[]"
                                    id="related_product">
                                    @foreach($showrelatedproduct as $subproduct)
                                        <option value="{{$subproduct->id}}" selected>{{$subproduct->title}}</option>
                                    @endforeach
                                </select>
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>

            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href='{{route("product.index")}}' class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </div>

    </form>
    <!-- /.card -->
</section>


@endsection

@section('customjs') 

<script>

    $('.releated-product').select2({
        ajax: {
            url: '{{ route("product.getProducts") }}',
            dataType: 'json',
            tags: true,
            multiple: true,
            minimumInputLength: 3,
            processResults: function (data) {
                return {
                    results: data.tags
                };
            }
        }
    });


    $("#title").change(function () {

        var element = $(this).val();

        $("button[type=submit]").prop('disabled', true);


        $.ajax({
            url: '{{route("getslug")}}',
            type: 'get',
            data: { title: element }, // Use correct form ID
            dataType: 'json', // 'datatype' should be 'dataType'
            success: function (response) {
                $("button[type=submit]").prop('disabled', false);

                if (response['status'] == true) {

                    $("#slug").val(response['slug']);
                } else {
                    console.log("there is not response");
                }
            },

        });

    });


    $("#productform").submit(function (event) {
        event.preventDefault();
        var formarray = $("#productform").serializeArray();
        $.ajax({
            url: '{{route("product.update", $product->id)}}',
            type: 'put',
            data: formarray,
            dataType: 'json',
            success: function (response) {
                if (response['status'] == true) {
                    window.location.href = "{{route('product.index')}}";
                }
                else {
                    var errors = response['error'];
                    $(".error").removeClass('invalid-feedback').html('');
                    $("input[type='text']").removeClass('is-invalid');
                    $.each(errors, function (key, value) {
                        $(`#${key}`).addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(value);
                    });
                }
            },
            error: function () {
                console.log("something went wrong");
            }
        });
    });
    $("#category").change(function () {
        var category_id = $(this).val();
        $.ajax({
            url: '{{route("productsubcat.index")}}',
            type: 'get',
            data: { category_id: category_id },
            dataType: 'json',
            success: function (response) {
                $("#sub_category").find("option").not(":first").remove();
                $.each(response['SubCategory'], function (key, item) {
                    $("#sub_category").append(`<option = '${item.id}'>${item.name}</option>`)
                });
            },
            error: function () {
                console.log("something went wrong");
            }
        });
    });
    Dropzone.autoDiscover = false;
    const dropzone = $("#image").dropzone({
        url: "{{route('product-images.update')}}",
        maxFiles: 10,
        params: { 'product_id': '{{$product->id}}'},
        paramName: 'image',
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg,image/png,image/gif",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }, success: function (file, response) {
            $("#image_id").val(response.image_id);
            var html = `<div class="card" id="image_row_${response['image_id']}" style="width: 18rem;">
            <input type="hidden" name="image_array[]" value="${response['image_id']}">
            <img class="card-img-top" src="${response['imagepath']}" alt="Card image cap">
            <div class="card-body">
            <a href="javascript:void(0)" onclick="delete_image(${response['image_id']})" class="btn btn-danger">Delete</a>
            </div>
            </div>`;
            $('#productgallery').append(html);
        },
        complete: function (file) {
            this.removeFile(file);
        }
    });
    function delete_image(id) {
        $("#image_row_" + id).remove();
        if (confirm("Are you sure to delete image?")) {
            $.ajax({
                url: '{{route("product-images.destroy")}}',
                type: 'delete',
                data: { id: id },
                success: function (response) {
                    if (response.status == true) {
                        alert(response.message);
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    }
</script>
@endsection