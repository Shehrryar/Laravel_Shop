@extends('admin.layout.app')

@section('content')
    <!-- Content Header (Page header) -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if (Auth::guard('admin')->user()?->role == 3)
                        <h1>Create My Store Sub Category</h1>
                    @else
                        <h1>Create Sub Category</h1>
                    @endif
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('subcategories.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form name="subcategoryform" id="subcategoryform">
				@csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name">Category</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Select a Category</option>
                                        @if ($cat_data->isNotEmpty())
                                            @foreach ($cat_data as $cati_data)
                                                <option value="{{ $cati_data->id }}">{{ $cati_data->name }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>
                                <p id="para_cat"></p>


                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Name">

                                </div>
                                <p id="para_name"></p>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control"
                                        placeholder="Slug">

                                </div>
                                <p id="para_slug"></p>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button id="getFormValuesButton" type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('subcategories.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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
            $('#para_status').html('');

            var formDataArray = $("#subcategoryform").serializeArray();

            $.ajax({
                url: '{{ route("subcategory.store") }}',
                type: 'POST',
                data: formDataArray,
                dataType: 'json',

                success: function(response) {
                    if (response.status === true) {
                        window.location.href = "{{ route('subcategories.index') }}";
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

                    if (errors.status) {
                        $('#para_status').html(errors.status[0] ?? errors.status);
                    }
                },

                error: function(jqXHR) {
                    console.log(jqXHR.responseText);
                    alert('Something went wrong while saving subcategory.');
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
    });
</script>
@endsection
