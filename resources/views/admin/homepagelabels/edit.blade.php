@extends('admin.layout.app')
@section('content')
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if (Auth::guard('admin')->user()?->role == 3)
                        <h1>Edit My Store Homepage Label</h1>
                    @else
                        <h1>Edit Homepage Label</h1>
                    @endif
                </div>
                <div class="col-sm-6 text-right">
                    <a href='{{ route('homepage-labels.index') }}' class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <form action="" method="post" id="label_edit_form">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <!-- Label Name -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="label_name">Label Name</label>
                                    <input type="text" name="label_name" id="label_name" value="{{ $label->label_name }}"
                                        class="form-control" placeholder="Label Name">
                                    <p id="para_label_name"></p>
                                </div>
                            </div>

                            <!-- Label Key -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="label_key">Label Key</label>
                                    <input type="text" name="label_key" id="label_key" value="{{ $label->label_key }}"
                                        class="form-control" placeholder="label-key">
                                    <p id="para_label_key"></p>
                                </div>
                            </div>

                            <!-- Is Active -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                            value="1" {{ $label->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">Is Active</label>
                                    </div>
                                    <p id="para_is_active"></p>
                                </div>
                            </div>

                            <!-- Sort Order -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sort_order">Sort Order</label>
                                    <input type="number" name="sort_order" id="sort_order" value="{{ $label->sort_order }}"
                                        class="form-control">
                                    <p id="para_sort_order"></p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button type="submit" id="updateLabelBtn" class="btn btn-primary">Update</button>
                    <a href='{{ route('homepage-labels.index') }}' class="btn btn-outline-dark ml-3">Cancel</a>
                </div>

            </form>
        </div>
    </section>
@endsection


@section('customjs')
    <script>
        $(document).ready(function() {

            $("#updateLabelBtn").click(function(event) {
                event.preventDefault();

                var formData = new FormData($('#label_edit_form')[0]);

                $.ajax({
                    url: '{{ route('homepage-labels.update', $label->id) }}',
                    type: 'POST', // Laravel PUT override
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'PUT'
                    },

                    success: function(response) {
                        if (response.status === true) {
                            window.location.href = "{{ route('homepage-labels.index') }}";
                            return;
                        }

                        if (response.notfound === true) {
                            window.location.href = "{{ route('homepage-labels.index') }}";
                            return;
                        }

                        var errors = response.errors || {};

                        if (errors.label_name) {
                            $('#para_label_name').html(errors.label_name[0] ?? errors
                                .label_name);
                        }

                        if (errors.label_key) {
                            $('#para_label_key').html(errors.label_key[0] ?? errors.label_key);
                        }

                        if (errors.is_active) {
                            $('#para_is_active').html(errors.is_active[0] ?? errors.is_active);
                        }

                        if (errors.sort_order) {
                            $('#para_sort_order').html(errors.sort_order[0] ?? errors
                                .sort_order);
                        }
                    },
                    error: function(jqXHR) {
                        console.log("Something went wrong", jqXHR.responseText);
                        alert('Something went wrong while updating homepage label.');
                    }
                });
            });

        });
    </script>
@endsection
