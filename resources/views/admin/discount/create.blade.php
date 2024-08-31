@extends('admin.layout.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Discount</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href='{{route("discount.index")}}' class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="" method="post" id="discount_form" enctype="multipart/form-data">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="discount_name" id="name" class="form-control"
                                    placeholder="Discount Name">
                                <p id="para_name"></p>
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
                                <label for="slug">Description</label>
                                <textarea class="form-control" name="description" id="description" cols="30"
                                    rows="5"></textarea>
                                <p id="para_description"></p>
                            </div>
                        </div> -->

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="select_product">Select Products</label>
                                <select multiple id="select_product[]" name="select_product[]" class="form-control">
                                    @if ($products->isNotEmpty())
										@foreach ($products as $product)
											<option value="{{$product->id}}"> {{ $product->title }}</option>
										@endforeach
                                    @endif
                                </select>
                                <p id="para_products"></p>

                            </div>
                        </div>
						<div class="col-md-6">
                            <div class="mb-3">
                                <label for="type">Type</label>
                                <select id="type" name="type" class="form-control">
                                    <option value="percentage">Percent</option>
                                    <option value="fixed">Fixed</option>
                                </select>
                                <p id="para_type"></p>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="number">Discount Amount</label>
                                <input type="number" name="discount_amount" id="discount_amount" class="form-control"
                                    placeholder="Discount Amount">
                                <p id="para_number"></p>
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

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="starts_at">Starts At</label>
                                <input type="date" name="starts_at" id="starts_at" class="form-control"
                                    placeholder="Starts At">
                                <p id="para_starts_at"></p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="expires_at">Expires At</label>
                                <input type="date" name="expires_at" id="expires_at" class="form-control"
                                    placeholder="Expires At">
                                <p id="para_expires_at"></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" id="getFormValuesButton" class="btn btn-primary">Create</button>
                <a href='{{route("coupon.index")}}' class="btn btn-outline-dark ml-3">Cancel</a>
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
    $("#discount_form").submit(function(event) {
        event.preventDefault();

		var formData = $(this).serializeArray();
        console.log("Serialized Form Data:", formData);


        $.ajax({
            url: '{{route("discount.store")}}',
            type: 'POST',
            data: $(this).serializeArray(), // Use correct form ID
            dataType: 'json', // 'datatype' should be 'dataType'
            success: function(response) {
                if (response['status'] == true) {
                    window.location.href = "{{route('discount.index')}}";
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