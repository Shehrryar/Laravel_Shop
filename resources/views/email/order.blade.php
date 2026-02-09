<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Email</title>
</head>

<body>

    <h1>Thanks for your order!</h1>
    <h2>Your Order ID is: {{ $order->id }}</h2>

    <address>
        <strong>{{ $order->firstname }} {{ $order->lastname }}</strong><br>
        {{ $order->address }}<br>
        {{ $order->city }}, {{ $order->zip }}<br>
        {{ $order->email }}
    </address>

    <h2>Products</h2>

    <table width="100%" border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th align="left">Name</th>
                <th align="left">Price</th>
                <th align="left">Quantity</th>
                <th align="left">Amount</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach

            <tr>
                <td colspan="3" align="right"><strong>Subtotal:</strong></td>
                <td>{{ number_format($order->subtotal, 2) }}</td>
            </tr>

            <tr>
                <td colspan="3" align="right"><strong>Discount:</strong></td>
                <td>{{ number_format($order->discount, 2) }}</td>
            </tr>

            <tr>
                <td colspan="3" align="right"><strong>Shipping:</strong></td>
                <td>{{ number_format($order->shipping, 2) }}</td>
            </tr>

            <tr>
                <td colspan="3" align="right"><strong>Grand Total:</strong></td>
                <td><strong>{{ number_format($order->grandtotal, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

</body>
</html>
