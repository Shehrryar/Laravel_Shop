@extends('admin.layout.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Theme</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href='{{route("onboarding.index")}}' class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <form action="" method="post" id="theme_form">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="theme_name">Theme Name</label>
                                    <input type="text" name="theme_name" id="theme_name" class="form-control" placeholder="Theme Name">
                                    <p id="para_theme_name"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="theme_color_code">Theme Color Code</label>
                                    <input type="text" name="theme_color_code" id="theme_color_code" class="form-control" placeholder="#FFFFFF">
                                    <p id="para_theme_color_code"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="theme_status" id="theme_status" class="form-check-input" value="1" checked>
                                        <label class="form-check-label" for="theme_status">Theme Status</label>
                                    </div>
                                    <p id="para_theme_status"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="theme_isset_status" id="theme_isset_status" class="form-check-input" value="1">
                                        <label class="form-check-label" for="theme_isset_status">Theme Isset Status</label>
                                    </div>
                                    <p id="para_theme_isset_status"></p>
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
    </section>
@endsection
@section('customjs')
    <script>
        $(document).ready(function () {
            $("#getFormValuesButton").click(function (event) {
                event.preventDefault();
                var formData = new FormData($('#theme_form')[0]);
                $.ajax({
                    url: '{{route("onboarding.store")}}',
                    data: formData,
                    type: 'POST',
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
                            $('#para_theme_name').html(errors['theme_name'] ?? '');
                            $('#para_theme_color_code').html(errors['theme_color_code'] ?? '');
                            $('#para_theme_status').html(errors['theme_status'] ?? '');
                            $('#para_theme_isset_status').html(errors['theme_isset_status'] ?? '');
                        }
                    },
                    error: function (jqXHR, exception) {
                        console.log("Something went wrong");
                    }
                });
            });
        });
    </script>
@endsection
