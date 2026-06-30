@extends('admin.layout.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if (Auth::guard('admin')->user()?->role == 3)
                        <h1>Edit My Store Onboarding</h1>
                    @else
                        <h1>Edit Onboarding</h1>
                    @endif
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('onboarding.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="put" id="onboarding_form" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" id="image" class="form-control"
                                        placeholder="image">
                                    <p id="para_image"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title" value="{{ $onboard_edit->title }}"
                                        class="form-control" placeholder="title">
                                    <p id="para_title"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="subtitle">Sub Title</label>
                                    <input type="text" name="subtitle" value="{{ $onboard_edit->subtitle }}"
                                        id="subtitle" class="form-control" placeholder="subtitle">
                                    <p id="para_subtitle"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" id="getFormValuesButton" class="btn btn-primary">Update</button>
                    <a href='{{ route('onboarding.index') }}' class="btn btn-outline-dark ml-3">Cancel</a>
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
                            var formData = new FormData($('#onboarding_form')[0]);
                            $.ajax({
                                    url: '{{ route('onboarding.update', $onboard_edit->id) }}',
                                    type: 'POST', // For PUT method, override below
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    dataType: 'json',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'X-HTTP-Method-Override': 'PUT'
                                    },
                                    success: function(response) {
                                        if (response['status'] === true) {
                                            window.location.href = "{{ route('onboarding.index') }}";
                                        } else {
                                            var errors = response.errors || {};
                                            if (errors.image) {
                                                $('#para_image').html(errors.image[0] ?? errors.image);
                                            }

                                            if (errors.title) {
                                                $('#para_title').html(errors.title[0] ?? errors.title);
                                            }

                                            if (errors.subtitle) {
                                                $('#para_subtitle').html(errors.subtitle[0] ?? errors.subtitle);
                                            }
                                        },
                                        error: function(jqXHR, exception) {
                                            console.log("Something went wrong", jqXHR.responseText);
                                        }
                                    });
                            });
                    });
    </script>
    <!-- /.content -->
@endsection
