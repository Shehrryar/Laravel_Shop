@extends('admin.layout.app')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Order: #{{$order->id}}</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('order.index')}}" class="btn btn-primary">Back</a>
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
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header pt-3">
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <h1 class="h5 mb-3">Shipping Address</h1>
                                <address>
                                    <strong>{{$order->firstname . " " . $order->lastname}}</strong>
                                    <br>{{$order->address}}<br>
                                    {{$order->city}}, {{$order->zip}}, {{$order->countryName}}<br>
                                    {{$order->email}}
                                </address>
                                <strong>Shipped Date : </strong>
                                @if (!empty($order->shipping_date))
                                    {{\Carbon\Carbon::parse($order->shipping_date)->format('d M, Y')}}
                                @else
                                    N/A
                                @endif
                            </div>



                            <div class="col-sm-4 invoice-col">
                                <!-- <b>Invoice #007612</b><br>
                                <br> -->
                                <b>Order ID:</b> {{$order->id}}<br>
                                <b>Total:</b> ${{number_format($order->grandtotal, 2)}}<br>
                                <b>Status:</b>
                                @if ($order->status == 'pending')
                                    <span class="badge bg-danger">Pending</span>
                                @elseif($order->status == 'shipped')
                                    <span class="badge bg-info">Shipped</span>
                                @elseif($order->status == 'delivered')
                                    <span class="badge bg-success">Delivered </span>
                                @else
                                    <span class="badge bg-danger">Cancelled </span>
                                @endif
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-3">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Price</td>
                                    <td>Quantity</td>
                                    <td>Amount</td>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($orderitems as $item)
                                    <tr>
                                        <th>{{$item->name}}</th>
                                        <th>{{number_format($item->price, 2)}}</th>
                                        <th>{{number_format($item->qty, 2)}}</th>
                                        <th>{{number_format($item->total, 2)}}</th>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="3" class="text-right">Subtotal:</th>
                                    <td>{{number_format($order->subtotal, 2)}}</td>
                                </tr>

                                <tr>
                                    <th colspan="3" class="text-right">Discount:</th>
                                    <td>{{number_format($order->discount, 2)}}</td>
                                </tr>

                                <tr>
                                    <th colspan="3" class="text-right">Shipping:</th>
                                    <td>{{number_format($order->shipping, 2)}}</td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right">Grand Total:</th>
                                    <td>{{number_format($order->grandtotal, 2)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <form action="" id="changeorderstatusform" name="changeorderstatusform" method="post">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Order Status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option value="delivered" {{($order->status == 'delivered') ? 'selected' : ''}}>
                                        Delivered</option>
                                    <option value="pending" {{($order->status == 'pending') ? 'selected' : ''}}>Pending
                                    </option>
                                    <option value="shipped" {{($order->status == 'shipped') ? 'selected' : ''}}>Shipped
                                    </option>
                                    <option value="cancelled" {{($order->status == 'cancelled') ? 'selected' : ''}}>
                                        Cancelled
                                    </option>
                                    <!-- <option value="" >Cancelled</option> -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="">Shipped Date</label>
                                <input value="{{ $order->shipped_date}}" class="form-control" type="datetime-local"
                                    name="shipped_date" id="shipped_date">
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card">
                    <form action="" method="post" name="sentInvoiceEmail" id="sentInvoiceEmail" >
                    <div class="card-body">
                        <h2 class="h4 mb-3">Send Inovice Email</h2>
                        <div class="mb-3">
                            <select name="userType" id="userType" class="form-control">
                                <option value="customer">Customer</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary">Send</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
@endsection
@section('customjs')

<script>
    $("#changeorderstatusform").submit(function (event) {
        event.preventDefault();
        $.ajax({
            url: '{{route('order.changeorderstatus', $order->id)}}',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function (response) {
                window.location.href = '{{route("order.detail", $order->id)}}';
            }

        });
    });
    
    $("#sentInvoiceEmail").submit(function (event) {
        event.preventDefault();
        $.ajax({
            url: '{{route('order.sendinvoiceemail', $order->id)}}',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function (response) {
                window.location.href = '{{route("order.detail", $order->id)}}';
            }

        });
    });
</script>
@endsection