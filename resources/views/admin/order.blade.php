<!DOCTYPE html>
<html lang="en">

<head>
    <title>Order Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('admin.partials.style')
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        @include('admin.partials.sidebar')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            @include('admin.partials.header')
            <!-- partial -->
            <div class="main-panel">
                <form action="{{ url('search') }}" method="GET" class="m-4 form-inline">
                    @csrf
                    <div class="form-group mx-auto" style="max-width: 500px;">
                        <input type="text" class="form-control" id="search" placeholder="Search" name="search">
                        <button type="submit" class="btn btn-primary mr-2" style="height: 38px;">Submit</button>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>User</th>
                                <th>Image</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>PDF</th>
                                <th>Send Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->product_title }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td><img src="/product/{{ $order->image }}" alt="{{ $order->product_title }}">
                                    </td>
                                    <td>{{ $order->quantity }}</td>
                                    <td>{{ $order->price }}</td>
                                    <td>{{ $order->email }}</td>
                                    <td>
                                        @if ($order->payment_status != 'Paid')
                                            <span class="btn btn-info">
                                                {{ $order->payment_status }}
                                            </span>
                                        @else
                                            <span class="btn btn-success">
                                                {{ $order->payment_status }}
                                            </span>
                                        @endif
                                        @if ($order->delivery_status != 'Delivered')
                                            <a onclick="return confirm('Are you sure you want to change the status')"
                                                href="{{ url('delivered', $order->id) }}" class="btn btn-danger">
                                                {{ $order->delivery_status }}
                                            </a>
                                        @else
                                            <a onclick="return confirm('Are you sure you want to change the status')"
                                                href="{{ url('delivered', $order->id) }}" class="btn btn-primary">
                                                {{ $order->delivery_status }}
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('delete_order', $order->id) }}" class="badge badge-danger"
                                            onclick="return confirm('Are you sure to delet this')">Delete</a>
                                    </td>
                                    <td>
                                        <a href="{{ url('print_pdf', $order->id) }}"
                                            class="badge badge-secondary text-dark">Download</a>
                                    </td>
                                    <td>
                                        <a href="{{ url('send_email', $order->id) }}" class="badge badge-warning">Send
                                            Email</a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center text-white">
                                    <td colspan="10" style="font-size: 30px;">Orders Not Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                @include('admin.partials.footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    @include('admin.partials.scripts')
</body>

</html>
