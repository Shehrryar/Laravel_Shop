@extends('admin.layout.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Onboarding</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href='{{route("onboarding.index")}}' class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="onboarding_form" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" id="image" class="form-control" placeholder="image">
                                    <p id="para_image"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="title">
                                    <p id="para_title"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="subtitle">Sub Title</label>
                                    <input type="text" name="subtitle" id="subtitle" class="form-control"
                                        placeholder="subtitle">
                                    <p id="para_subtitle"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" id="getFormValuesButton" class="btn btn-primary">Create</button>
                    <a href='{{route("onboarding.index")}}' class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
@section('customjs')
    <script>
        $(document).ready(function () {
            $("#getFormValuesButton").click(function (event) {
                event.preventDefault();
                var formData = new FormData($('#onboarding_form')[0]);
                $.ajax({
                    url: '{{route("onboarding.store")}}',
                    data: formData,
                    type: 'POST', // For PUT method, override belo
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'POST'
                    },
                    success: function (response) {
                        if (response['status'] === true) {
                            window.location.href = "{{ route('onboarding.index') }}";
                        } else {
                            var errors = response['errors'];
                            if (errors['name']) {
                                // $('#name').addClass('is-valid').siblings('p').addClass('invalid-feedback').html(errors['name']);
                                $('#para_image').html(errors['image']);
                            }
                            if (errors['email']) {
                                // $('#name').addClass('is-valid').siblings('p').addClass('invalid-feedback').html(errors['name']);
                                $('#para_title').html(errors['title']);
                            }
                            if (errors['phone']) {
                                // $('#name').addClass('is-valid').siblings('p').addClass('invalid-feedback').html(errors['name']);
                                $('#para_subtitle').html(errors['subtitle']);
                            }
                        }
                    },
                    error: function (jqXHR, exception) {
                        console.log("Something went wrong");
                    }
                });
                // Further logic here
            });
        });
    </script>
    <!-- /.content -->
@endsection