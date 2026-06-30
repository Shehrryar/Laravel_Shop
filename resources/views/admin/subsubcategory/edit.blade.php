@extends('admin.layout.app')
@section('content')
    <!-- Content Header (Page header) -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if (Auth::guard('admin')->user()?->role == 3)
                        <h1>Edit My Store Sub Category Level 3</h1>
                    @else
                        <h1>Edit Sub Category Level 3</h1>
                    @endif
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('subsubcategories.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form name="subsubcategoryform" id="subsubcategoryform">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name">Category</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Select Category</option>
                                        @foreach ($cat_data as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ $subsubcat->category_id == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <p id="para_cat"></p>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name">Sub Category</label>
                                    <select name="subcategory" id="subcategory" class="form-control">
                                        <option value="">Select Sub Category</option>
                                        @foreach ($subcat_data as $subcat)
                                            <option value="{{ $subcat->id }}"
                                                {{ $subsubcat->subcategory_id == $subcat->id ? 'selected' : '' }}>
                                                {{ $subcat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <p id="para_subcat"></p>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input value="{{ $subsubcat->name }}" type="text" name="name" id="name"
                                        class="form-control" placeholder="Name">
                                </div>
                                <p id="para_name"></p>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Slug</label>
                                    <input value="{{ $subsubcat->slug }}" type="text" name="slug" id="slug"
                                        class="form-control" placeholder="Slug">
                                </div>
                                <p id="para_slug"></p>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="1" {{ $subsubcat->status == 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ $subsubcat->status == 0 ? 'selected' : '' }}>Block
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button id="getFormValuesButton" type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('subsubcategories.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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
        $("#getFormValuesButton").click(function(event) {
            event.preventDefault();

            $('#para_name').html('');
            $('#para_slug').html('');
            $('#para_cat').html('');
            $('#para_subcat').html('');
            $('#para_status').html('');

            var formDataArray = $("#subsubcategoryform").serializeArray();

            $.ajax({
                url: '{{ route("subsubcategory.update", $subsubcat->id) }}',
                type: 'PUT',
                data: formDataArray,
                dataType: 'json',

                success: function(response) {
                    if (response.status === true) {
                        window.location.href = "{{ route('subsubcategories.index') }}";
                        return;
                    }

                    if (response.notfound === true) {
                        window.location.href = "{{ route('subsubcategories.index') }}";
                        return;
                    }

                    var errors = response.errors || {};

                    if (errors.name) {
                        $('#para_name').html(errors.name[0] ?? errors.name);
                    }

                    if (errors.slug) {
                        $('#para_slug').html(errors.slug[0] ?? errors.slug);
                    }

                    if (errors.category) {
                        $('#para_cat').html(errors.category[0] ?? errors.category);
                    }

                    if (errors.subcategory) {
                        $('#para_subcat').html(errors.subcategory[0] ?? errors.subcategory);
                    }

                    if (errors.status) {
                        $('#para_status').html(errors.status[0] ?? errors.status);
                    }
                },

                error: function(jqXHR) {
                    console.log(jqXHR.responseText);
                    alert('Something went wrong while updating Sub Category Level 3.');
                }
            });
        });

        $("#name").change(function() {
            var element = $(this).val();

            $("button[type=submit]").prop('disabled', true);

            $.ajax({
                url: '{{ route("getslug") }}',
                type: 'GET',
                data: {
                    title: element
                },
                dataType: 'json',

                success: function(response) {
                    $("button[type=submit]").prop('disabled', false);

                    if (response.status === true) {
                        $("#slug").val(response.slug);
                    }
                },

                error: function() {
                    $("button[type=submit]").prop('disabled', false);
                    console.log("Slug generation failed");
                }
            });
        });

        $("#category").change(function() {
            var categoryId = $(this).val();

            $("#subcategory").html('<option value="">Select Sub Category</option>');

            if (categoryId == '') {
                return;
            }

            $.ajax({
                url: '{{ route("productsubcat.index") }}',
                type: 'GET',
                data: {
                    category_id: categoryId
                },
                dataType: 'json',

                success: function(response) {
                    if (response.status === true) {
                        $.each(response.SubCategory, function(key, item) {
                            $("#subcategory").append(
                                '<option value="' + item.id + '">' + item.name + '</option>'
                            );
                        });
                    }
                },

                error: function(jqXHR) {
                    console.log(jqXHR.responseText);
                }
            });
        });
    });
</script>
@endsection