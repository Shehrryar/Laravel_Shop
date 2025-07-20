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
                                <!-- User Info Display -->
                                <div class="col-12 mb-3">
                                    <label class="form-label font-weight-bold">Country</label>
                                    <input type="text" class="form-control"
                                        value="{{ Auth::user()->country_id ?? 'Not provided' }}" disabled>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label font-weight-bold">Apartment</label>
                                    <input type="text" class="form-control"
                                        value="{{ Auth::user()->apartment ?? 'Not provided' }}" disabled>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label font-weight-bold">Address</label>
                                    <input type="text" class="form-control"
                                        value="{{ Auth::user()->address ?? 'Not provided' }}" disabled>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label font-weight-bold">City</label>
                                    <input type="text" class="form-control"
                                        value="{{ Auth::user()->city ?? 'Not provided' }}" disabled>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label font-weight-bold">State</label>
                                    <input type="text" class="form-control"
                                        value="{{ Auth::user()->state ?? 'Not provided' }}" disabled>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label font-weight-bold">Zip</label>
                                    <input type="text" class="form-control"
                                        value="{{ Auth::user()->zip ?? 'Not provided' }}" disabled>
                                </div>
                                <!-- Edit Profile Button -->
                                <div class="col-12 text-end mt-4">
                                    <button type="button" class="btn btn-primary" id="editProfileBtn">
                                        <i class="fas fa-edit me-2"></i>Edit Profile
                                    </button>
                                    <button type="button" class="btn btn-success d-none" id="updateProfileBtn">
                                        <i class="fas fa-save me-2"></i>Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('customjs')
    <script>

        $(document).ready(function () {

            alert('This is the address page. You can manage your addresses here.');
        });

        // document.addEventListener('DOMContentLoaded', function () {
        //     const editBtn = document.getElementById('editProfileBtn');
        //     const updateBtn = document.getElementById('updateProfileBtn');
        //     const inputs = document.querySelectorAll('.card-body input.form-control');
        //     editBtn.addEventListener('click', function () {
        //         inputs.forEach(input => input.disabled = false);
        //         editBtn.classList.add('d-none');
        //         updateBtn.classList.remove('d-none');
        //     });
        // });
    </script>
    <!-- /.content -->
@endsection