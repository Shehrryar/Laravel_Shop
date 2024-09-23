@extends('admin.layout.app')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Product</h1>
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
    < class="container-fluid">

        <form action="" method="POST" name="productform" id="productform">
            @csrf
            <!-- Basic Info Tab -->
            <!-- Additional Info Tab -->
            <div class="tab-pane fade" id="additional-info" role="tabpanel" aria-labelledby="additional-info-tab">
                <!-- Row format for three divs in a single row -->
                <div class="row">
                    <!-- First Column (4 columns wide) -->
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
                                    <input type="file" class="form-control" name="product_image" id="product_image">
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
                                    <input class="form-control" type="number" placeholder="Enter Stock Quantity"
                                        id="stock">
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
                                        <input type="text" name="price" id="price" class="form-control"
                                            placeholder="Price" value="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="compare_price">Compare at Price</label>
                                        <input type="text" name="compare_price" id="compare_price" class="form-control"
                                            placeholder="Compare Price" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="mb-3">
                                    <a class="form-control" type="submit" id="add-attributes-btn">Add Attributes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="attribute-list-row">
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
    var twodattributesArray = [];

    $('#add-attributes-btn').on('click', function (e) {
        e.preventDefault();
        // Get values from form
        var color_id = $('#color option:selected').val();
        var color_name = $('#color option:selected').text();
        var size_id = $('#size option:selected').val();
        var size_name = $('#size option:selected').text();
        var stock = $('#stock').val();
        var price = $('#price').val();
        var comparePrice = $('#compare_price').val();
        var fileInput = $('#product_image')[0].files[0];
        const fullFileName = fileInput.name;
        const fileNameWithoutExtension = fullFileName.substring(0, fullFileName.lastIndexOf('.'));

        var attributesArray = {
            color: color_id,
            size: size_id,
            stock: stock,
            price: price,
            comparePrice: comparePrice,
            file: fileInput,
            image_name: fileNameWithoutExtension
        };

        twodattributesArray.push(attributesArray);

        // Create the row with attributes and buttons for edit/remove (for UI display)
        var uniqueId = new Date().getTime(); // Unique ID for the row
        var attributeRow = `
        <div class="col-md-12" id="attribute-row-${uniqueId}">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <p><strong>Color:</strong> ${color_name}</p>
                        </div>
                        <div class="col-md-2">
                            <p><strong>Size:</strong> ${size_name}</p>
                        </div>
                        <div class="col-md-2">
                            <p><strong>Stock:</strong> ${stock}</p>
                        </div>
                        <div class="col-md-2">
                            <p><strong>Price:</strong> ${price}</p>
                        </div>
                        <div class="col-md-2">
                            <p><strong>Compare Price:</strong> ${comparePrice ? comparePrice : 'N/A'}</p>
                        </div>
                        <div class="col-md-2 text-end">
                            <button class="btn btn-sm btn-warning edit-attribute" data-id="${uniqueId}">Edit</button>
                            <button class="btn btn-sm btn-danger remove-attribute" data-id="${uniqueId}">Remove</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

        // Append the new row with the attributes to the div
        $('#attribute-list-row').append(attributeRow);
    });

    $("#productform").submit(function (event) {
        event.preventDefault();
        var formData = new FormData();

        // Append form fields to the FormData object
        var formarray = $("#productform").serializeArray();
        $.each(formarray, function (i, field) {
            formData.append(field.name, field.value);
        });

        // Convert the twodattributesArray to a JSON string and append it
        formData.append('attributes', JSON.stringify(twodattributesArray));

        // Append file fields manually to the FormData
        twodattributesArray.forEach(function (attribute) {
            if (attribute.file) {
                // Extract the file name from the File object
                const fileName = attribute.image_name;
                formData.append(fileName, attribute.file);
            }
        });


        $.ajax({
            url: '{{ route("product.store") }}',
            type: 'post',
            data: formData,
            processData: false, // Important! Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Important! Ensure multipart/form-data is used
            success: function (response) {
                if (response['status'] == true) {
                    // Handle success
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


    // Remove the attribute row and also remove it from the 2D array
    $(document).on('click', '.remove-attribute', function () {
        var id = $(this).data('id');
        $('#attribute-row-' + id).remove(); // Remove the row with the specific id

        // Optionally remove from the 2D array if needed (this example doesn't track by id, but you can add logic to handle it)
    });

    // Edit the attribute row (same as before, no change here)
    // $(document).on('click', '.edit-attribute', function () {
    //     var id = $(this).data('id');
    //     var row = $('#attribute-row-' + id);

    //     // Get current values from the row
    //     var color = row.find('p:contains("Color:")').text().replace('Color: ', '');
    //     var size = row.find('p:contains("Size:")').text().replace('Size: ', '');
    //     var stock = row.find('p:contains("Stock:")').text().replace('Stock: ', '');
    //     var price = row.find('p:contains("Price:")').text().replace('Price: ', '');
    //     var comparePrice = row.find('p:contains("Compare Price:")').text().replace('Compare Price: ', '');

    //     // Set the values back to the form for editing
    //     $('#color').val($('#color option:contains("' + color + '")').val());  // Set color option
    //     $('#size').val($('#size option:contains("' + size + '")').val());    // Set size option
    //     $('#stock').val(stock);
    //     $('#price').val(price);
    //     $('#compare_price').val(comparePrice === 'N/A' ? '' : comparePrice);

    //     // Remove the current row for now, you can add back after editing
    //     $('#attribute-row-' + id).remove();
    // });







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
            data: {
                title: element
            }, // Use correct form ID
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

    $("#category").change(function () {
        var category_id = $(this).val();
        $.ajax({
            url: '{{route("productsubcat.index")}}',
            type: 'get',
            data: {
                category_id: category_id
            },
            dataType: 'json',
            success: function (response) {
                $("#sub_category").find("option").not(":first").remove();
                $.each(response['SubCategory'], function (key, item) {
                    $("#sub_category").append(
                        `<option value ='${item.id}'>${item.name}</option>`)
                });
            },
            error: function () {
                console.log("something went wrong");
            }
        });
    });
    $("#sub_category").change(function () {
        var subcategory_id = $(this).val();
        $.ajax({
            url: '{{route("productsubcat.subcategory")}}',
            type: 'get',
            data: {
                subcategory_id: subcategory_id
            },
            dataType: 'json',
            success: function (response) {
                $("#subsub_category").find("option").not(":first").remove();
                $.each(response['SubSubCategory'], function (key, item) {
                    $("#subsub_category").append(
                        `<option value ='${item.id}'>${item.name}</option>`)
                });
            },
            error: function () {
                console.log("something went wrong");
            }
        });
    });
    Dropzone.autoDiscover = false;
    const dropzone = $("#image").dropzone({
        url: "{{route('temp-images.create') }}",
        maxFiles: 10,
        paramName: 'image',
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg,image/png,image/gif",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (file, response) {
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
    }
</script>
@endsection