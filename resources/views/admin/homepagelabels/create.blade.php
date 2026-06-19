@extends('admin.layout.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Homepage Label</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href='{{ route("homepage-labels.index") }}' class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <form action="" method="post" id="label_form">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <!-- Label Name -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="label_name">Label Name</label>
                                    <input type="text" name="label_name" id="label_name" class="form-control" placeholder="Trending Now">
                                    <p id="para_label_name"></p>
                                </div>
                            </div>

                            <!-- Label Key -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="label_key">Label Key</label>
                                    <input type="text" name="label_key" id="label_key" class="form-control" placeholder="trending-now">
                                    <p id="para_label_key"></p>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" checked>
                                        <label class="form-check-label" for="is_active">Is Active</label>
                                    </div>
                                    <p id="para_is_active"></p>
                                </div>
                            </div>

                            <!-- Sort Order -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sort_order">Sort Order</label>
                                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="0">
                                    <p id="para_sort_order"></p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button type="submit" id="submitLabelBtn" class="btn btn-primary">Create</button>
                    <a href='{{ route("homepage-labels.index") }}' class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
    </section>
@endsection


@section('customjs')
<script>
    $(document).ready(function () {
        $("#submitLabelBtn").click(function (event) {
            event.preventDefault();

            var formData = new FormData($('#label_form')[0]);

            $.ajax({
                url: '{{ route("homepage-labels.store") }}',
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
                    if (response.status === true) {
                        window.location.href = "{{ route('homepage-labels.index') }}";
                    } else {
                        let errors = response.errors;
                        $('#para_label_name').html(errors.label_name ?? '');
                        $('#para_label_key').html(errors.label_key ?? '');
                        $('#para_is_active').html(errors.is_active ?? '');
                        $('#para_sort_order').html(errors.sort_order ?? '');
                    }
                },
                error: function () {
                    console.log("Something went wrong");
                }
            });
        });
    });
</script>
@endsection
