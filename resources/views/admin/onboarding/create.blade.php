@extends('admin.layout.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if (Auth::guard('admin')->user()?->role == 3)
                        <h1>Create My Store Onboarding</h1>
                    @else
                        <h1>Create Onboarding</h1>
                    @endif
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('onboarding.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <form action="" method="post" id="onboarding_form" enctype="multipart/form-data">
                @csrf

                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                    <p id="para_image" class="text-danger"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                                    <p id="para_title" class="text-danger"></p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="subtitle">Subtitle</label>
                                    <textarea name="subtitle" id="subtitle" class="form-control" rows="4" placeholder="Subtitle"></textarea>
                                    <p id="para_subtitle" class="text-danger"></p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button type="submit" id="getFormValuesButton" class="btn btn-primary">Create</button>
                    <a href="{{ route('onboarding.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('customjs')
    <script>
        $(document).ready(function() {
            $("#getFormValuesButton").click(function(event) {
                event.preventDefault();

                $('#para_image').html('');
                $('#para_title').html('');
                $('#para_subtitle').html('');

                var formData = new FormData($('#onboarding_form')[0]);

                $.ajax({
                    url: '{{ route("onboarding.store") }}',
                    data: formData,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    dataType: 'json',

                    success: function(response) {
                        if (response.status === true) {
                            window.location.href = "{{ route('onboarding.index') }}";
                            return;
                        }

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

                    error: function(jqXHR) {
                        console.log(jqXHR.responseText);
                        alert('Something went wrong while saving onboarding.');
                    }
                });
            });
        });
    </script>
@endsection