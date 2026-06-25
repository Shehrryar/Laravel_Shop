@extends('admin.layout.app')

@section('content')
    @php
        $adminUser = Auth::guard('admin')->user();
        $isMainAdmin = $adminUser && (int) $adminUser->role === 2;
        $isVendor = $adminUser && (int) $adminUser->role === 3;
    @endphp

    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if ($isVendor)
                        <h1>My Customers</h1>
                    @else
                        <h1>Users</h1>
                    @endif
                </div>

                <div class="col-sm-6 text-right">
                    @if ($isMainAdmin)
                        <a href="{{ route('users.create') }}" class="btn btn-primary">
                            New User
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @include('admin.message')

            <div class="card">
                <form action="" method="get">
                    <div class="card-header">
                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 250px;">
                                <input type="text"
                                    value="{{ Request::get('keyword') }}"
                                    name="keyword"
                                    class="form-control float-right"
                                    placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone No.</th>
                                <th width="100">Status</th>

                                @if ($isMainAdmin)
                                    <th width="100">Action</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @if ($users->isNotEmpty())
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>

                                        <td>
                                            @if ($user->status == 1)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Blocked</span>
                                            @endif
                                        </td>

                                        @if ($isMainAdmin)
                                            <td>
                                                <a href="{{ route('users.edit', $user->id) }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <a href="#"
                                                    onclick="deleuser({{ $user->id }})"
                                                    class="text-danger ml-2">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="{{ $isMainAdmin ? 6 : 5 }}" class="text-center">
                                        Record Not Found
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customjs')
    @if ($isMainAdmin)
        <script>
            function deleuser(user_id) {
                var delurl = "{{ route('users.delete', 'ID') }}".replace("ID", user_id);

                if (confirm("Are you sure you want to delete " + user_id + "?")) {
                    $.ajax({
                        url: delurl,
                        type: "DELETE",
                        data: {},
                        dataType: "json",
                        success: function(response) {
                            if (response.status) {
                                window.location.href = "{{ route('users.index') }}";
                            }
                        }
                    });
                }
            }
        </script>
    @endif
@endsection