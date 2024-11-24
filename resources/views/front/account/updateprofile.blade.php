@extends('front.layouts.app')
@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                <li class="breadcrumb-item">Edit Profile</li>
            </ol>
        </div>
    </div>
</section>
<section class="section-11">
    <div class="container mt-5">
        <div class="row">
            @include('front.account.sidebar.sidebar')
            <div class="col-md-9">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h2 class="h5 mb-0">Edit Profile</h2>
                    </div>
                    <div class="card-body p-4">
                        <form id="updateprofileform" enctype="multipart/form-data">
                            <div class="row">
                                <!-- Profile Image -->
                                <div class="col-12 text-center mb-4">
                                    <img src="{{ Auth::user()->image ? asset(Auth::user()->image)  : asset('/upload/user/default_user_image.png') }}"
                                        alt="Profile Image" class="img-fluid rounded-circle border"
                                        style="object-fit: cover; max-width: 100%; height: 90%; width: 30%;">
                                    <div class="mt-2">
                                        <label for="profile_image" class="btn btn-secondary btn-sm">Change Image</label>
                                        <input type="file" name="profile_image" id="profile_image" class="d-none">
                                    </div>
                                </div>
                                <!-- Name -->
                                <div class="col-12 mb-3">
                                    <label for="name" class="form-label font-weight-bold">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name', Auth::user()->name) }}">
                                </div>
                                <!-- Email -->
                                <div class="col-12 mb-3">
                                    <label for="email" class="form-label font-weight-bold">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ old('email', Auth::user()->email) }}" readonly>
                                </div>
                                <!-- Phone -->
                                <div class="col-12 mb-3">
                                    <label for="phone" class="form-label font-weight-bold">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                        value="{{ old('phone', Auth::user()->phone) }}">
                                </div>
                                <!-- Address -->
                                <div class="col-12 mb-3">
                                    <label for="address" class="form-label font-weight-bold">Address</label>
                                    <textarea name="address" id="address" class="form-control"
                                        rows="4">{{ old('address', Auth::user()->address) }}</textarea>
                                </div>
                                <!-- Submit Button -->
                                <div class="col-12 text-end mt-4">
                                    <button id="getFormValuesButton"  class="btn btn-primary">Save Change</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('customJs')
<script type="text/javascript">
$('#updateprofileform').submit(function (event) {
    event.preventDefault(); // Prevent default form submission
    let formData = new FormData(this); // Use FormData for file and input fields
    formData.append('_method', 'PUT'); // Add `_method` for PUT requests in Laravel
    $.ajax({
        url: '{{ route("account.updateProfileData") }}', // Ensure this route is correct
        type: 'POST', // Use POST as PUT requires `_method`
        data: formData,
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Let the browser set the Content-Type
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}" // CSRF token for Laravel security
        },
        dataType: 'json',
        success: function (response) {
            if(response.status === true){
            console.log(response.status);
                window.location.href = "{{route('account.profile')}}";
            }
        },
    });
});
</script>
@endsection