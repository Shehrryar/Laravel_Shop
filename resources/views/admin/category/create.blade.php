@extends('admin.layout.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if (Auth::guard('admin')->user()?->role == 3)
                        <h1>Create My Store Category</h1>
                    @else
                        <h1>Create Category</h1>
                    @endif
                </div>
                <div class="col-sm-6 text-right">
                    <a href='{{ route('categories.index') }}' class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="category_from" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Name">
                                    <p id="para_name"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input readonly type="text" name="slug" id="slug" class="form-control"
                                        placeholder="Slug">
                                    <p id="para_slug"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="hidden" name="image_id" id="image_id" value="">
                                    <label for="image">Image</label>
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.<br><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">
                                            Block
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" id="getFormValuesButton" class="btn btn-primary">Create</button>
                    <a href='{{ route('categories.index') }}' class="btn btn-outline-dark ml-3">Cancel</a>
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
                $('#para_status').html('');

                var formDataArray = $("#category_from").serializeArray();

                $.ajax({
                    url: '{{ route('categories.store') }}',
                    type: 'POST',
                    data: formDataArray,
                    dataType: 'json',

                    success: function(response) {
                        if (response.status === true) {
                            window.location.href = "{{ route('categories.index') }}";
                            return;
                        }

                        var errors = response.errors || {};

                        if (errors.name) {
                            $('#para_name').html(errors.name[0] ?? errors.name);
                        }

                        if (errors.slug) {
                            $('#para_slug').html(errors.slug[0] ?? errors.slug);
                        }

                        if (errors.status) {
                            $('#para_status').html(errors.status[0] ?? errors.status);
                        }
                    },

                    error: function(jqXHR) {
                        console.log(jqXHR.responseText);
                        alert('Something went wrong while saving category.');
                    }
                });
            });

            $("#name").change(function() {
                var element = $(this).val();

                $("button[type=submit]").prop('disabled', true);

                $.ajax({
                    url: '{{ route('getslug') }}',
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

        Dropzone.autoDiscover = false;

        const dropzone = $("#image").dropzone({
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });
            },

            url: "{{ route('temp-images.create') }}",
            maxFiles: 1,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function(file, response) {
                $("#image_id").val(response.image_id);
            }
        });
    </script>
@endsection
