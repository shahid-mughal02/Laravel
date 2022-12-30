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
    <link rel="shortcut icon" href="images/favicon.png" type="">
    <link rel="stylesheet" type="text/css" href="{{ asset('home/css/bootstrap.css') }}" />
    <link href="{{ asset('home/css/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('home/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('home/css/responsive.css') }}" rel="stylesheet" />
</head>

<body>
    @include('sweetalert::alert')
    <div class="hero_area">
        <!-- header section strats -->
        @include('home.partials.header')
        <!-- end header section -->
        <!-- slider section -->
        @include('home.partials.slider')
        <!-- end slider section -->
    </div>
    <!-- why section -->
    @include('home.partials.why')
    <!-- end why section -->

    <!-- arrival section -->
    @include('home.partials.arrival')
    <!-- end arrival section -->

    <!-- product section -->
    <form action="{{ url('search_product') }}" method="GET" class="mt-3 form-inline">
        @csrf
        <div class="form-group mx-auto" style="max-width: 500px;">
            <input type="text" class="form-control mb-0" id="search" placeholder="Search" name="search">
            <input type="submit" class="py-2 px-4">
        </div>
    </form>

    @include('home.partials.product')
    <!-- end product section -->

    <!-- Comment and reply Start -->
    <div class="container-fluid mb-5">
        <div class="container">
            <div id="comment">
                <div class="heading_container heading_center">
                    <h3>Comments</h3>
                </div>
                <form action="{{ url('add_comment') }}" method="POST">
                    @csrf
                    <textarea class="form-control p-3" name="comment" id="" cols="30" rows="5"
                        placeholder="Comment Something Here"></textarea>
                    <input type="submit" value="Comment" class="btn bg-danger">
                </form>
            </div>
            <div class="mt-3">
                <div class="heading_container">
                    <h3 class="h3">All Comments</h3>
                </div>
                @foreach ($comments as $comment)
                    <div class="user-comment bg-light p-3">
                        <b>{{ ucwords($comment->name) }}</b>
                        <p>{{ $comment->comment }}</p>
                        <a href="javascript::void(0)" class="btn text-primary" onclick="reply(this)"
                            data-commentid="{{ $comment->id }}">Reply</a>
                        @foreach ($replies as $reply)
                            @if ($reply->comment_id == $comment->id)
                                <div class="pl-3 py-2 mb-2 bg-white border">
                                    <b>{{ ucwords($reply->name) }}</b>
                                    <p>{{ $reply->reply }}</p>
                                    <a href="javascript::void(0)" class="btn text-primary" onclick="reply(this)"
                                        data-commentid="{{ $comment->id }}">Reply</a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
            <div id="reply" class="my-3" style="display: none;">
                <form action="{{ url('add_reply') }}" method="POST">
                    @csrf
                    <input type="text" id="commentId" name="commentId" hidden>
                    <textarea name="reply" name="reply" id="" cols="30" rows="5" class="form-control"
                        placeholder="Write something here"></textarea>
                    <div class="flex">
                        <input type="submit" value="Comment" class="btn ml-0 mr-2">
                        <a href="javascript::void(0)" class="btn btn-danger mx-0 py-3" onclick="closeReply()">Close</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Comment and reply End -->

    @include('home.partials.subscribe')
    <!-- subscribe section -->

    <!-- end subscribe section -->
    <!-- client section -->
    @include('home.partials.client')
    <!-- end client section -->
    <!-- footer start -->
    @include('home.partials.footer')
    <!-- footer end -->
    <div class="cpy_">
        <p>© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a></p>
    </div>
    <script src="home/js/jquery-3.4.1.min.js"></script>
    <script src="home/js/popper.min.js"></script>
    <script src="home/js/bootstrap.js"></script>
    <script src="home/js/custom.js"></script>

    <script>
        function reply(caller) {
            document.querySelector('#commentId').value = $(caller).attr('data-commentid')
            $('#reply').insertAfter($(caller));
            $('#reply').show();
        }

        function closeReply() {
            $('#reply').hide();
        }

        //Same Document Scroll Position after refresh
        document.addEventListener("DOMContentLoaded", function(event) {
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };
    </script>
</body>

</html>
