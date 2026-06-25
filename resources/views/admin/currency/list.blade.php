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
                        <h1>View Currencies</h1>
                    @else
                        <h1>Currencies</h1>
                    @endif
                </div>

                <div class="col-sm-6 text-right">
                    @if ($isMainAdmin)
                        <a href="{{ route('currency.create') }}" class="btn btn-primary">
                            New Currency
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
                        <div class="card-title">
                            <button class="btn btn-default" type="button"
                                onclick="window.location.href='{{ route('currency.index') }}'">
                                Reset
                            </button>
                        </div>

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
                                <th>Code</th>
                                <th>Exchange Rate</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>

                                @if ($isMainAdmin)
                                    <th width="100">Action</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @if ($currency->isNotEmpty())
                                @foreach ($currency as $curren)
                                    <tr>
                                        <td>{{ $curren->id }}</td>
                                        <td>{{ $curren->name }}</td>
                                        <td>{{ $curren->code }}</td>
                                        <td>{{ $curren->exchange_rate }}</td>

                                        <td>
                                            @if ($curren->status == 1)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>

                                        <td>{{ $curren->created_at }}</td>
                                        <td>{{ $curren->updated_at }}</td>

                                        @if ($isMainAdmin)
                                            <td>
                                                <a href="{{ route('currency.edit', $curren->id) }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <a href="#"
                                                    onclick="delecurrency({{ $curren->id }})"
                                                    class="text-danger ml-2">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="{{ $isMainAdmin ? 8 : 7 }}" class="text-center">
                                        Record Not Found
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    {{ $currency->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customjs')
    @if ($isMainAdmin)
        <script>
            function delecurrency(currency_id) {
                var delurl = "{{ route('currency.delete', 'ID') }}".replace("ID", currency_id);

                if (confirm("Are you sure you want to delete currency with ID " + currency_id + "?")) {
                    $.ajax({
                        url: delurl,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status) {
                                window.location.href = "{{ route('currency.index') }}";
                            } else {
                                alert('Failed to delete the currency.');
                            }
                        },
                        error: function() {
                            alert('Error occurred while deleting the currency.');
                        }
                    });
                }
            }
        </script>
    @endif
@endsection