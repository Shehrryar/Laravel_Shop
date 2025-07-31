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
                            <h2 style="color:black;" class="mb-0">Address</h2>
                        </div>
                        <div class="card-body p-4">
                            <div class="row justify-content-center">
                                <form id="customer_address_form" action="" method="POST">
                                    @csrf
                                    <div class="col-12 mb-3">
                                        <label class="form-label font-weight-bold">Country</label>
                                        <select name="country_id" class="form-control" disabled>
                                            <option value="">Select Country</option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ (isset($customer_address->country_id) && $customer_address->country_id == $country->id) ? 'selected' : '' }}>
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label font-weight-bold">Apartment</label>
                                        <input name="apartment" type="text" class="form-control"
                                            value="{{ $customer_address->apartment ?? 'Not provided' }}" disabled>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label font-weight-bold">Address</label>
                                        <input name="address" type="text" class="form-control"
                                            value="{{ $customer_address->address ?? 'Not provided' }}" disabled>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label font-weight-bold">City</label>
                                        <input name="city" type="text" class="form-control"
                                            value="{{ $customer_address->city ?? 'Not provided' }}" disabled>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label font-weight-bold">State</label>
                                        <input name="state" type="text" class="form-control"
                                            value="{{ $customer_address->state ?? 'Not provided' }}" disabled>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label font-weight-bold">Zip</label>
                                        <input name="zip" type="text" class="form-control"
                                            value="{{ $customer_address->zip ?? 'Not provided' }}" disabled>
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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('customJs')
    <script>
        $(document).ready(function () {
            const editBtn = document.getElementById('editProfileBtn');
            const updateBtn = document.getElementById('updateProfileBtn');
            const inputs = document.querySelectorAll('.card-body input.form-control');
            const select = document.querySelector('.card-body select[name="country_id"]');
            editBtn.addEventListener('click', function () {
                inputs.forEach(input => input.disabled = false);
                if (select) select.disabled = false;
                editBtn.classList.add('d-none');
                updateBtn.classList.remove('d-none');
            });
            // Handle form submission for updating address
            $('#customer_address_form').on('submit', function (event) {
                event.preventDefault();
                $.ajax({
                    url: "{{ route('account.addressupdate') }}",
                    type: 'PUT',
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response.status === true) {
                            console.log('Address updated successfully');
                            inputs.forEach(input => input.disabled = true);
                            if (select) select.disabled = true;
                            editBtn.classList.remove('d-none');
                            updateBtn.classList.add('d-none');
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Address updated successfully!',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            alert('Failed to update address. Please try again.');
                        }
                    },
                    error: function () {
                        alert('An error occurred while updating the address.');
                    }
                });
            });
        });
        // Show update button and enable inputs on edit
        document.getElementById('updateProfileBtn').addEventListener('click', function () {
            $('#customer_address_form').submit();
        });
    </script>
    <!-- /.content -->
@endsection