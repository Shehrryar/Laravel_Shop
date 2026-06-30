@extends('admin.layout.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if (Auth::guard('admin')->user()?->role == 3)
                        <h1>Edit My Store Promotion</h1>
                    @else
                        <h1>Edit Promotion</h1>
                    @endif
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('promotion.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form name="editpromotionform" id="editpromotionform" method="POST">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" placeholder="Enter promotion description">{{ $promotion->description }}</textarea>
                                </div>
                                <p id="para_description"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button id="getFormValuesButton" type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('promotion.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
@endsection
@section('customjs')
<script>
    $(document).ready(function() {
        $("#getFormValuesButton").click(function(event) {
            event.preventDefault();

            $('#para_description').html('');

            var formDataArray = $("#editpromotionform").serializeArray();

            $.ajax({
                url: '{{ route("promotion.update", $promotion->id) }}',
                type: 'PUT',
                data: formDataArray,
                dataType: 'json',

                success: function(response) {
                    if (response.status === true) {
                        window.location.href = "{{ route('promotion.index') }}";
                        return;
                    }

                    if (response.notfound === true) {
                        window.location.href = "{{ route('promotion.index') }}";
                        return;
                    }

                    var errors = response.errors || {};

                    if (errors.description) {
                        $('#para_description').html(errors.description[0] ?? errors.description);
                    }
                },

                error: function(jqXHR) {
                    console.log(jqXHR.responseText);
                    alert('Something went wrong while updating promotion.');
                }
            });
        });
    });
</script>
@endsection
