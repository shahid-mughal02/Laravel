<!DOCTYPE html>
<html lang="en">

<head>
    <title>Email Notification</title>
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
            <div class="main-panel my-4">
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        <strong>Success!</strong> {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                    </div>
                @endif
                <h1 class="h3 text-center">
                    Send Email at <br>
                    {{ $order->email }}
                </h1>
                <div class="card-body">
                    <h4 class="card-title">Customise Email</h4>
                    <form action="{{ url('send_user_email', $order->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="email_title">Email Title: </label>
                            <input type="text" class="form-control" id="email_title" name="email_title"
                                placeholder="Add Title">
                        </div>
                        <div class="form-group">
                            <label for="email_body">Email Body: </label>
                            <textarea class="form-control" id="email_body" name="email_body" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="email_button">Email Button: </label>
                            <input type="text" class="form-control" id="email_button" name="email_button"
                                placeholder="Button Text">
                        </div>
                        <div class="form-group">
                            <label for="email_url">Email Url: </label>
                            <input type="text" class="form-control" id="email_url" name="email_url"
                                placeholder="Url">
                        </div>
                        <div class="form-group">
                            <label for="email_end">Email End: </label>
                            <input type="text" class="form-control" id="email_end" name="email_end"
                                placeholder="End">
                        </div>
                        <button type="submit" class="btn btn-lg btn-primary mr-2">Send Email</button>
                    </form>
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
