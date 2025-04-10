@extends('admin.layout.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Promotion</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('promotion.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form name="promotionform" id="promotionform" method="POST">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <!--
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                    <p id="para_status"></p>
                                </div> -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="4"
                                        placeholder="Enter description"></textarea>
                                </div>
                                <p id="para_description"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button id="getFormValuesButton" type="submit" class="btn btn-primary">Add</button>
                    <a href="{{route('promotion.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
@endsection
@section('customjs')
    <script>
        $(document).ready(function () {
            $("#getFormValuesButton").click(function (event) {
                event.preventDefault();
                var formDataArray = $("#promotionform").serializeArray();
                $.ajax({
                    url: '{{route("promotion.store")}}',
                    type: 'POST',
                    data: formDataArray,
                    dataType: 'json',
                    success: function (response) {
                        if (response['status'] == true) {
                        } else {
                            var errors = response['errors'];
                            if (errors['description']) {
                                $('#para_description').html(errors['description']);
                            }
                        }
                    },
                    error: function (jqXHR, exception) {
                        console.log("Something went wrong");
                    }
                });
            });
        });
    </script>
    <!-- /.content -->
@endsection