<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
            margin: 0;
        }

        h1 {
            color: #333;
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        h2 {
            color: #666;
            font-size: 18px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table thead {
            background-color: #333;
            color: #fff;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .total-row th, .total-row td {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        .summary {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h1>Thanks for your order!</h1>
    <h2>Your Order ID is: {{$mailData['order']->id}}</h2>

    <h2>Products</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mailData['order']->items as $item)
                <tr>
                    <td>{{$item->name}}</td>
                    <td>{{number_format($item->price, 2)}}</td>
                    <td>{{number_format($item->qty, 2)}}</td>
                    <td>{{number_format($item->total, 2)}}</td>
                </tr>
            @endforeach
            <tr class="summary">
                <th colspan="3" class="text-right">Subtotal:</th>
                <td>{{number_format($mailData['order']->subtotal, 2)}}</td>
            </tr>
            <tr class="summary">
                <th colspan="3" class="text-right">Discount:</th>
                <td>{{number_format($mailData['order']->discount, 2)}}</td>
            </tr>
            <tr class="summary">
                <th colspan="3" class="text-right">Shipping:</th>
                <td>{{number_format($mailData['order']->shipping, 2)}}</td>
            </tr>
            <tr class="summary total-row">
                <th colspan="3" class="text-right">Grand Total:</th>
                <td>{{number_format($mailData['order']->grandtotal, 2)}}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
