@extends('admin.layout.app')

@section('content')
    @php
        $adminUser = Auth::guard('admin')->user();
        $isMainAdmin = $adminUser && (int) $adminUser->role === 2;
        $isVendor = $adminUser && (int) $adminUser->role === 3;
    @endphp
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if ($isVendor)
                        <h1>View Languages</h1>
                    @else
                        <h1>Languages</h1>
                    @endif
                </div>
                <div class="col-sm-6 text-right">
                    @if ($isMainAdmin)
                        <a href='{{ route('language.create') }}' class="btn btn-primary">New Language</a>
                    @endif
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            @include('admin.message')
            <div class="card">
                <form action="" method="get">

                    <div class="card-header">

                        <div class="card-title">
                            <button class="btn btn-default" type="button"
                                onclick="window.location.href='{{ route('language.index') }}'">Reset</button>
                        </div>


                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 250px;">
                                <input type="text" value='{{ Request::get('keyword') }}' name="keyword"
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
                                <th>Slug</th>
                                <th>ISO Code</th>
                                <th width="100">Status</th>
                                @if ($isMainAdmin)
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                            @if ($language->isNotEmpty())
                                @foreach ($language as $lang)
                                    <tr>
                                        <td>{{ $lang->id }}</td>
                                        <td>{{ $lang->name }}</td>
                                        <td>{{ $lang->slug }}</td>
                                        <td>{{ $lang->Isocode }}</td>

                                        <td>
                                            @if ($lang->status == 1)
                                                <svg class="text-success-500 h-6 w-6 text-success"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @else
                                                <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                            @endif
                                        </td>
                                        @if ($isMainAdmin)
                                            <td>
                                                <a href="{{ route('language.edit', $lang->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    Edit
                                                </a>

                                                <a href="javascript:void(0)" onclick="deletelanguage({{ $lang->id }})"
                                                    class="btn btn-danger btn-sm">
                                                    Delete
                                                </a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">
                                        Record Not Found
                                    </td>
                                </tr>
                            @endif


                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">

                    {{ $language->links() }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>

@endsection

@section('customjs')
    <script>
        function delelang(lang_id) {

            var delurl = '{{ route('language.delete', 'ID') }}'.replace("ID", lang_id);

            if (confirm("Are you sure you want to delete " + lang_id)) {
                $.ajax({

                    url: delurl,
                    type: 'delete',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json', // 'datatype' should be 'dataType'
                    success: function(response) {

                        if (response['status']) {
                            window.location.href = "{{ route('language.index') }}";
                        }
                    }

                });
            }
        }
    </script>
@endsection
