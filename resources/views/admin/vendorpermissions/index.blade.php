@extends('admin.layout.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Vendor Permissions</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Vendor Name</th>
                                <th>Email</th>
                                <th>Store</th>
                                <th>Products</th>
                                <th>Orders</th>
                                <th>Chat</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($vendors as $vendor)
                                @php
                                    $permissions = $vendor->permissions ?? [];
                                @endphp

                                <tr>
                                    <td>{{ $vendor->id }}</td>
                                    <td>{{ $vendor->name }}</td>
                                    <td>{{ $vendor->email }}</td>
                                    <td>{{ $vendor->store?->store_name ?? 'No Store' }}</td>

                                    <td>
                                        @if (!empty($permissions['products']))
                                            <span class="badge badge-success">Allowed</span>
                                        @else
                                            <span class="badge badge-danger">Blocked</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if (!empty($permissions['orders']))
                                            <span class="badge badge-success">Allowed</span>
                                        @else
                                            <span class="badge badge-danger">Blocked</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if (!empty($permissions['chat']))
                                            <span class="badge badge-success">Allowed</span>
                                        @else
                                            <span class="badge badge-danger">Blocked</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('vendor.permissions.edit', $vendor->id) }}"
                                            class="btn btn-sm btn-primary">
                                            Manage Permissions
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No vendors found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
@endsection