@extends('admin.layout.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit User</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href='{{route("users.index")}}' class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="" method="post" id="user_from" enctype="multipart/form-data">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name"
                                    value="{{$user_edit->name}}">
                                <p id="para_name"></p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="email"
                                    value="{{$user_edit->email}}">
                                <p id="para_email"></p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="password" value="{{$user_edit->password}}">
                                <p id="para_password"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="phone"
                                    value="{{$user_edit->phone}}">
                                <p id="para_phone"></p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>

                                <select id="status" name="status" class="form-control">
                                    <option {{($user_edit->status == 1) ? 'selected' : ''}} value="1">Active</option>
                                    <option {{($user_edit->status == 0) ? 'selected' : ''}} value="0">Block</option>
                                </select>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" id="getFormValuesButton" class="btn btn-primary">Update</button>
                <a href='{{route("users.index")}}' class="btn btn-outline-dark ml-3">Cancel</a>
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

    $("#user_from").click(function(event) {
        event.preventDefault();
        var formDataArray = $("#user_from").serializeArray();
        $.ajax({
            url: '{{route("users.update", $user_edit->id)}}',
            type: 'PUT',
            data: formDataArray, // Use correct form ID
            dataType: 'json', // 'datatype' should be 'dataType'
            success: function(response) {
                if (response['status'] === true) {
                    window.location.href = "{{ route('users.index') }}";
                } else {
                    var errors = response['errors'];
                    if (errors['name']) {
                        // $('#name').addClass('is-valid').siblings('p').addClass('invalid-feedback').html(errors['name']);

                        $('#para_name').html(errors['name']);

                    }
                    if (errors['email']) {
                        // $('#name').addClass('is-valid').siblings('p').addClass('invalid-feedback').html(errors['name']);

                        $('#para_email').html(errors['email']);
                    }

                    if (errors['phone']) {
                        // $('#name').addClass('is-valid').siblings('p').addClass('invalid-feedback').html(errors['name']);

                        $('#para_phone').html(errors['phone']);
                    }
                    if (errors['password']) {
                        // $('#name').addClass('is-valid').siblings('p').addClass('invalid-feedback').html(errors['name']);

                        $('#para_password').html(errors['password']);
                    }
                }
            },
            error: function(jqXHR, exception) {
                console.log("Something went wrong");
            }
        });
        // Further logic here
    });
});
</script>
<!-- /.content -->
@endsection