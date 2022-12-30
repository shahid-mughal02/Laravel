<!DOCTYPE html>
<html lang="en">

<head>
    <title>Product - Corona</title>
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
            <div class="main-panel mt-3 px-2">
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        <strong>Success!</strong> {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                    </div>
                @endif
                <h1>Product</h1>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Update Product</h4>
                                <form action="{{ url('/update_product', $product->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" id="title" placeholder="Title"
                                            name="title" value="{{ $product->title }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" rows="4" placeholder="Description" name="description">{{ $product->description }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" class="form-control" id="quantity" placeholder="Quantity"
                                            name="quantity" value="{{ $product->quantity }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="number" class="form-control" id="price" placeholder="Price"
                                            name="price" value="{{ $product->price }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="discount_price">Discount Price</label>
                                        <input type="number" class="form-control" id="discount_price"
                                            placeholder="Discount Price" name="discount_price"
                                            value="{{ $product->discount_price }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="category">Select Cetgory</label>
                                        <select class="form-control" id="category" name="category">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->category }}"
                                                    @if ($product->category == $category->category) selected @endif>
                                                    {{ $category->category }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <img src="/product/{{ $product->image }}" alt="{{ $product->title }}"
                                            width="300px">
                                    </div>
                                    <div class="form-group">
                                        <label>File upload</label>
                                        <input type="file" name="image" class="file-upload-default" id="image">
                                        <div class="input-group col-xs-12">
                                            <input type="text" class="form-control file-upload-info" disabled
                                                placeholder="Upload Image">
                                            <span class="input-group-append">
                                                <label class="file-upload-browse mb-0 btn btn-primary"
                                                    for="image">Upload</label>
                                            </span>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-warning mr-2">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    @include('admin.partials.scripts')
</body>

</html>
