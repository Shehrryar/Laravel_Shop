@extends('admin.layout.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Vendor Permissions</h1>
                </div>

                <div class="col-sm-6 text-right">
                    <a href="{{ route('vendor.permissions.index') }}" class="btn btn-primary">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card mb-3">
                <div class="card-body">
                    <h4>{{ $vendor->name }}</h4>
                    <p class="mb-1"><strong>Email:</strong> {{ $vendor->email }}</p>
                    <p class="mb-0"><strong>Store:</strong> {{ $vendor->store?->store_name ?? 'No Store' }}</p>
                </div>
            </div>

            <form action="{{ route('vendor.permissions.update', $vendor->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Allowed Functionalities</h3>
                    </div>

                    <div class="card-body">
                        @php
                            $permissions = $vendor->permissions ?? [];
                        @endphp

                        <div class="row">
                            @foreach ($availablePermissions as $key => $label)
                                <div class="col-md-4">
                                    <div class="custom-control custom-switch mb-3">
                                        <input type="checkbox"
                                            class="custom-control-input"
                                            id="permission_{{ $key }}"
                                            name="permissions[{{ $key }}]"
                                            value="1"
                                            {{ !empty($permissions[$key]) ? 'checked' : '' }}>

                                        <label class="custom-control-label" for="permission_{{ $key }}">
                                            {{ $label }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            Save Permissions
                        </button>

                        <a href="{{ route('vendor.permissions.index') }}" class="btn btn-outline-dark ml-2">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>

        </div>
    </section>
@endsection