<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
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
                                        <strong>{{ $order->firstname . ' ' . $order->lastname }}</strong>
                                        <br>{{ $order->address }}<br>
                                        {{ $order->city }}, {{ $order->zip }}, {{ $order->countryName }}<br>
                                        {{ $order->email }}
                                    </address>
                                    <strong>Shipped Date : </strong>
                                    @if (!empty($order->shipping_date))
                                        {{ \Carbon\Carbon::parse($order->shipping_date)->format('d M, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </div>



                                <div class="col-sm-4 invoice-col">
                                    <!-- <b>Invoice #007612</b><br>
                                <br> -->
                                    <b>Order ID:</b> {{ $order->id }}<br>
                                    @if (!empty($isVendor))
                                        <b>My Store Total:</b> ${{ number_format($vendorTotal ?? 0, 2) }}<br>
                                    @else
                                        <b>Total:</b> ${{ number_format($order->grandtotal, 2) }}<br>
                                    @endif
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
                                            <th>{{ $item->name }}</th>
                                            <th>{{ number_format($item->price, 2) }}</th>
                                            <th>{{ number_format($item->quantity, 2) }}</th>
                                            <th>{{ number_format($item->total, 2) }}</th>
                                        </tr>
                                    @endforeach


                                    @if (!empty($isVendor))
                                        <tr>
                                            <th colspan="3" class="text-right">My Store Total:</th>
                                            <td>{{ number_format($vendorTotal ?? 0, 2) }}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <th colspan="3" class="text-right">Subtotal:</th>
                                            <td>{{ number_format($order->subtotal, 2) }}</td>
                                        </tr>

                                        <tr>
                                            <th colspan="3" class="text-right">Discount:</th>
                                            <td>{{ number_format($order->discount, 2) }}</td>
                                        </tr>

                                        <tr>
                                            <th colspan="3" class="text-right">Shipping:</th>
                                            <td>{{ number_format($order->shipping, 2) }}</td>
                                        </tr>

                                        <tr>
                                            <th colspan="3" class="text-right">Grand Total:</th>
                                            <td>{{ number_format($order->grandtotal, 2) }}</td>
                                        </tr>
                                    @endif




                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.card -->
    </section>
</body>

</html>
