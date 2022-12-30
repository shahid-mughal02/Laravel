<!DOCTYPE html>
<html>

<head>
    <title>Famms - Fashion HTML Template</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="{{ asset('homeimages/favicon.png') }}" type="">
    <link rel="stylesheet" type="text/css" href="{{ asset('home/css/bootstrap.css') }}" />
    <link href="{{ asset('home/css/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('home/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('home/css/responsive.css') }}" rel="stylesheet" />
</head>

<body>
    <!-- header section strats -->
    @include('home.partials.header')
    <!-- end header section -->
    <section class="product_section my-4">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>
                    Order
                </h2>
            </div>
            @if (session()->has('message'))
                <div class="alert alert-success">
                    <strong>Success!</strong> {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                </div>
            @endif
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Payment Status</th>
                        <th>Delivery Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total_price = 0; ?>
                    @foreach ($order as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->product_title }}</td>
                            <td>
                                <img src="{{ asset('/product/' . $item->image) }}" alt="{{ $item->product_title }}"
                                    width="50px">
                            </td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->payment_status }}</td>
                            <td>{{ $item->delivery_status }}</td>
                            <td>
                                @if ($item->delivery_status == 'Processing')
                                    <a href="{{ url('/cancel_order', $item->id) }}"
                                        onclick="return confirm('Are you sure you want to Cancel the order.')"
                                        class="btn btn-danger">Cancel</a>
                                @else
                                    <span class="btn btn-success">Completed</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <?php $total_price = $total_price + $item->price; ?>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($total_price != 0)
                <div class="alert text-center h3 text-white" style="background-color: #f7444e;">
                    Price: <strong>$<?= $total_price ?></strong>
                </div>
            @endif

            <div class="my-5">
                <strong class="h3">Proceed to Order</strong>
                <div class="btn- btn-group w-100 mt-2">
                    <a href="{{ url('/cash_order') }}" class="btn btn-success">Cash on Delivery</a>
                    <a href="{{ url('/stripe', $total_price) }}" class="btn btn-warning">Pay Via Card</a>
                </div>
            </div>
        </div>
    </section>

    @include('home.partials.footer')
    <!-- footer end -->
    <div class="cpy_">
        <p>© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a></p>
    </div>
    <script src="home/js/jquery-3.4.1.min.js"></script>
    <script src="home/js/popper.min.js"></script>
    <script src="home/js/bootstrap.js"></script>
    <script src="home/js/custom.js"></script>
</body>

</html>
