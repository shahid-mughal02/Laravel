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
                    {{ $product->title }}
                </h2>
            </div>
            <div class="row">
                <div class="col">
                    <div class="img-box">
                        <img class="mx-auto" src="{{ asset('product/' . $product->image) }}" alt="">
                    </div>
                    <div class="detail-box">
                        <h5 class="d-flex justify-content-between w-100">
                            @if ($product->discount_price != '')
                                <del>
                                    Price: ${{ $product->price }}
                                </del>
                                <span class="ml-2 text-danger">
                                    Discount Price: ${{ $product->discount_price }}
                                </span>
                            @else
                                Price: ${{ $product->price }}
                            @endif
                        </h5>
                        <p>{{ $product->description }}</p>
                    </div>
                    <div>
                        <p class="lead">
                            Category: <strong class="d-inline-block"
                                style="font-weight: 700">{{ $product->category }}</strong>
                        </p>
                    </div>
                    <div>
                        <p class="lead">
                            Quantity: <strong class="d-inline-block"
                                style="font-weight: 700">{{ $product->quantity }}</strong>
                        </p>
                    </div>
                    <div class="options">
                        <form action="{{ url('add_cart', $product->id) }}" class="row px-3" method="POST">
                            @csrf
                            <input class="col-3" type="number" name="quantity" value="1" min="1">
                            <input class="option2 col-8" type="submit" value="Add to Cart">
                        </form>
                    </div>
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
