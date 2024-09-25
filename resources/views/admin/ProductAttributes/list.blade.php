@extends('admin.layout.app')

@section('content')

<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Products</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href='{{route("productattribute.create")}}' class="btn btn-primary">New Attributes</a>
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
            <form id="importproductform" action="" method="post" enctype="multipart/form-data">
                <div class="card-header">
                    <div class="card-tools">
                        <div class="input-group input-group" style="width: 250px;">
                            <input type="text" value='{{Request::get("keyword")}}' name="keyword"
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
                            <th width="60">Product</th>
                            <th width="60">Color</th>
                            <th width="60">Size</th>
                            <th width="80">Image</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Remaining Quantity</th>
                            <th>Sold Quantity</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($product_attributes->isNotEmpty())
                        @foreach($product_attributes as $prod_att)
                            <td>{{ $prod_att->product->title ?? 'N/A' }}</td>
                            <td>{{$prod_att->color->name ?? 'N/A'}}</td>
                            <td>{{$prod_att->size->name ?? 'N/A'}}</td>
                            <td>
                                @if(!empty($prod_att->image))
                                <img src="{{asset('upload/products/Attributes_images/'.$prod_att->image)}}" class="img-thumbnail"
                                    width="50">
                                @else
                                <img src="{{asset('admin-assets\img\default-150x150.png')}}" class="img-thumbnail"
                                    width="50">
                                @endif
                            </td>
                            <td>{{$prod_att->original_price}}</td>
                            <td>{{$prod_att->quantity}}</td>
                            <td>{{$prod_att->remaning_quantity}}</td>
                            <td>{{$prod_att->sold_quantity}}</td>
                            <!-- <td>
                                @if($prod_att->status==1)
                                <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                @else
                                <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                @endif
                            </td> -->
                            <td>
                                <a href='{{route("productattribute.edit", $prod_att->id)}}'>
                                    <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                        </path>
                                    </svg>
                                </a>
                                <a href='#' onclick="deleteproduct_att({{$prod_att->id}})" class="text-danger w-4 h-4 mr-1">
                                    <svg wire:loading.remove.delay="" wire:target=""
                                        class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path ath fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{$product_attributes->links()}}
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
@endsection
@section('customjs')
<script>
function deleteproduct_att(id) {

    var delurl = '{{route("productattribute.delete","ID")}}'.replace("ID", id);
    $.ajax({
        url: delurl,
        type: 'delete',
        data: {}, // Use correct form ID
        dataType: 'json', // 'datatype' should be 'dataType'
        success: function(response) {
            if (response['status']) {
                window.location.href = "{{route('productattribute.index')}}";
            }
        }

    });

}
</script>
@endsection