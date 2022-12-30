<section class="product_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>
                Our <span>products</span>
            </h2>
        </div>
        <div class="row">
            @foreach ($products as $product)
                <div class="col-sm-6 col-md-4 col-lg-4">
                    <div class="box">
                        <div class="option_container">
                            <div class="options">
                                <a href="{{ url('product_details', $product->id) }}" class="option1">
                                    {{ $product->title }}
                                </a>
                                <form action="{{ url('add_cart', $product->id) }}" class="row px-3" method="POST">
                                    @csrf
                                    <input class="col-3" type="number" name="quantity" value="1" min="1">
                                    <input class="option2 col-8" type="submit" value="Add to Cart">
                                </form>
                            </div>
                        </div>
                        <div class="img-box">
                            <img src="{{ asset('product/' . $product->image) }}" alt="">
                        </div>
                        <div class="detail-box">
                            <h5 class="d-flex justify-content-between w-100">
                                @if ($product->discount_price != '')
                                    <del>
                                        ${{ $product->price }}
                                    </del>
                                    <span class="ml-2 text-danger">
                                        ${{ $product->discount_price }}
                                    </span>
                                @else
                                    ${{ $product->price }}
                                @endif
                            </h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-3">
            {!! $products->withQueryString()->links('pagination::bootstrap-5') !!}
        </div>
    </div>
</section>
