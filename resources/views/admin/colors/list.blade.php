@extends('admin.layout.app')

@section('content')
    @php
        $adminUser = Auth::guard('admin')->user();
        $isVendor = $adminUser && (int) $adminUser->role === 3;
    @endphp

    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if ($isVendor)
                        <h1>My Store Colors</h1>
                    @else
                        <h1>Colors</h1>
                    @endif
                </div>

                <div class="col-sm-6 text-right">
                    <a href="{{ route('colorss.create') }}" class="btn btn-primary">New Color</a>
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
                                onclick="window.location.href='{{ route('colorss.index') }}'">Reset</button>
                        </div>

                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 250px;">
                                <input type="text" value="{{ Request::get('keyword') }}" name="keyword"
                                    class="form-control float-right" placeholder="Search">
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
                                <th>Hex Value</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Product</th>
                                <th>Status</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if ($colors->isNotEmpty())
                                @foreach ($colors as $color)
                                    <tr>
                                        <td>{{ $color->id }}</td>
                                        <td>{{ $color->name }}</td>
                                        <td>{{ $color->value }}</td>
                                        <td>
                                            <div style="width:30px;height:22px;border:1px solid #ddd;background-color: {{ $color->value }};"></div>
                                        </td>
                                        <td>{{ $color->size?->name ?? 'N/A' }}</td>
                                        <td>{{ $color->product?->title ?? 'Product not found' }}</td>
                                        <td>
                                            @if ($color->status == 1)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Blocked</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('colorss.edit', $color->id) }}">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <a href="#" onclick="deleteColor({{ $color->id }})" class="text-danger ml-2">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">Record Not Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    {{ $colors->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customjs')
    <script>
        function deleteColor(color_id) {
            var delurl = '{{ route('colorss.delete', 'ID') }}'.replace('ID', color_id);

            if (confirm('Are you sure you want to delete color ID ' + color_id + '?')) {
                $.ajax({
                    url: delurl,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            window.location.href = "{{ route('colorss.index') }}";
                        } else {
                            alert(response.message || 'Failed to delete color.');
                        }
                    },
                    error: function(jqXHR) {
                        console.log(jqXHR.responseText);
                        alert('Something went wrong.');
                    }
                });
            }
        }
    </script>
@endsection
