@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                <li class="breadcrumb-item">Settings</li>
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
                        <h2 class="h5 mb-0">Personal Information</h2>
                    </div>
                    <div class="card-body p-4">
                        <div class="row justify-content-center">
                            <!-- Profile Image -->
                            <div class="col-12 text-center mb-4">
                                <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('/upload/user/default_user_image.png') }}" 
                                     alt="Profile Image" 
                                     class="img-fluid rounded-circle border" 
                                     style="object-fit: cover; max-width: 100%; height: 90%; width: 30%;">
                            </div>
                            <!-- User Info Display -->
                            <div class="col-12 mb-3">
                                <label for="name" class="form-label font-weight-bold">Name</label>
                                <div class="p-2 border rounded bg-light">{{ Auth::user()->name }}</div>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="email" class="form-label font-weight-bold">Email</label>
                                <div class="p-2 border rounded bg-light">{{ Auth::user()->email }}</div>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="phone" class="form-label font-weight-bold">Phone</label>
                                <div class="p-2 border rounded bg-light">{{ Auth::user()->phone ?? 'Not provided' }}</div>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="address" class="form-label font-weight-bold">Address</label>
                                <div class="p-2 border rounded bg-light">{{ Auth::user()->address ?? 'Not provided' }}</div>
                            </div>

                            <!-- Edit Profile Button -->
                            <div class="col-12 text-end mt-4">
                                <a href="{{route('account.profileEdit')}}"  class="btn btn-primary">
                                    <i class="fas fa-edit me-2"></i>Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
