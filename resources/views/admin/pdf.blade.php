<!DOCTYPE html>
<html lang="en">

<head>
    <title>Order PDF</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

</head>

<body>
    <div class="container-fluid">
        <h1>
            Order Details
        </h1>

        <table>
            <caption>Invoice Id: {{ $order->id }}</caption>
            <thead>
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Payment Status</th>
                <th>Delivery Status</th>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->email }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->product_title }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ $order->payment_status }}</td>
                    <td>{{ $order->delivery_status }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
