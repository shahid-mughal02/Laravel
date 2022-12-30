<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use Session;
use Stripe;
use App\Models\Comment;
use App\Models\Reply;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{

    public function index()
    {
        $products = Product::paginate(3);
        $comments = Comment::orderby('id', 'DESC')->get();
        $replies = Reply::all();

        return view('home.index', compact('products', 'comments', 'replies'));
    }

    public function redirect()
    {
        $usertype = Auth::user()->usertype;

        if ($usertype == '1') {
            $total_products = Product::all()->count();
            $total_orders = Order::all()->count();
            $total_users = User::all()->count();

            $orders = Order::all();
            $total_revenue = 0;

            foreach ($orders as $order) {
                $total_revenue = $total_revenue + $order->price;
            }

            $delivered = Order::where('delivery_status', '=', 'Delivered')->get()->count();
            $processing = Order::where('delivery_status', '=', 'Processing')->get()->count();

            return view('admin.home', compact('total_products', 'total_orders', 'total_users', 'total_revenue', 'delivered', 'processing'));
        } else {
            $products = Product::paginate(3);

            $comments = Comment::orderby('id', 'DESC')->get();
            $replies = Reply::all();

            return view('home.index', compact('products', 'comments', 'replies'));
        }
    }

    public function product_details($id)
    {
        $product = Product::find($id);

        return view('home.product_details', compact('product'));
    }

    public function add_cart(Request $request, $id)
    {
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;

            $product = Product::find($id);

            $product_exist_id = cart::where('product_id', '=', $id)->where('user_id', '=', $userid)->get('id')->first();

            if ($product_exist_id) {
                $cart = Cart::find($product_exist_id->id);
                $quantity = $cart->quantity;
                $cart->quantity = $quantity + $request->quantity;

                if ($product->discount_price != null) {
                    $cart->price = $product->discount_price * $cart->quantity;
                } else {
                    $cart->price = $product->price * $cart->quantity;
                }


                $cart->save();

                Alert::success('Product Added Successfully', 'We have add product to the cart.');

                return redirect()->back();
            } else {
                $cart = new cart;
                $cart->name = $user->name;
                $cart->email = $user->email;
                $cart->phone = $user->phone;
                $cart->address = $user->address;
                $cart->user_id = $user->id;

                $cart->product_id = $product->id;
                $cart->product_title = $product->title;
                $cart->quantity = $product->quantity;

                if ($product->discount_price != null) {
                    $cart->price = $product->discount_price * $request->quantity;
                } else {
                    $cart->price = $product->price * $request->quantity;
                }
                $cart->image = $product->image;

                $cart->save();

                Alert::success('Product Added Successfully', 'We have add product to the cart.');

                return redirect()->back();
            }
        } else {
            return redirect('login');
        }
    }

    public function show_cart()
    {
        if (Auth::id()) {
            $cart = Cart::all();
            $id = Auth::user()->id;

            $cart = cart::where('user_id', '=', $id)->get();

            return view('home.show_cart', compact('cart'));
        } else {
            return view('home.show_cart');
        }
    }

    public function delete_cart($id)
    {
        $cart = Cart::find($id);

        $cart->delete();
        return redirect()->back();
    }

    public function cash_order()
    {
        $user = Auth::user();
        $user_id = $user->id;

        $data = Cart::where('user_id', '=', $user_id)->get();

        //For Inserting Multiple data
        foreach ($data as $data) {
            $order = new order;

            $order->name = $data->name;
            $order->email = $data->email;
            $order->phone = $data->phone;
            $order->product_title = $data->product_title;
            $order->quantity = $data->quantity;
            $order->price = $data->price;
            $order->user_id = $data->user_id;
            $order->image = $data->image;
            $order->product_id = $data->product_id;
            $order->payment_status = 'Cash On Delivery';
            $order->delivery_status = 'Processing';

            $order->save();

            //Empty Cart
            $cart_id = $data->id;
            $cart = Cart::find($cart_id);
            $cart->delete();
        }

        return redirect()->back()->with('message', 'Your Order Successfully Received');
    }

    public function stripe($total_price)
    {
        return view('home.stripe', compact('total_price'));
    }

    public function stripePost(Request $request, $total_price)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create([
            "amount" => $total_price * 100, // 100 mean 100 cents which make the price as USD
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Thanks for purchase."
        ]);



        $user = Auth::user();
        $user_id = $user->id;

        $data = Cart::where('user_id', '=', $user_id)->get();

        //For Inserting Multiple data
        foreach ($data as $data) {
            $order = new order;

            $order->name = $data->name;
            $order->email = $data->email;
            $order->phone = $data->phone;
            $order->product_title = $data->product_title;
            $order->quantity = $data->quantity;
            $order->price = $data->price;
            $order->user_id = $data->user_id;
            $order->product_id = $data->product_id;
            $order->payment_status = 'Paid';
            $order->delivery_status = 'Processing';

            $order->save();

            //Empty Cart
            $cart_id = $data->id;
            $cart = Cart::find($cart_id);
            $cart->delete();

            Session::flash('success', 'Payment successful!');

            return back();
        }
    }

    public function show_order()
    {
        if (Auth::id()) {
            $order = Order::all();
            $id = Auth::user()->id;

            $order = Order::where('user_id', '=', $id)->get();

            return view('home.show_order', compact('order'));
        } else {
            return redirect('login');
        }
    }

    public function cancel_order($id)
    {
        $order = Order::find($id);
        $order->payment_status = 'Refund is in progress.';
        $order->delivery_status = 'You canceled the order.';

        $order->save();
        return redirect()->back();
    }

    public function add_comment(Request $request)
    {
        if (Auth::id()) {
            $comment  = new comment;
            $comment->name = Auth::user()->name;
            $comment->user_id = Auth::user()->id;
            $comment->comment = $request->comment;

            $comment->save();

            return redirect()->back();
        } else {
            return redirect('login');
        }
    }

    public function add_reply(Request $request)
    {
        if (Auth::id()) {
            $reply  = new reply;
            $reply->name = Auth::user()->name;
            $reply->user_id = Auth::user()->id;
            $reply->comment_id = $request->commentId;
            $reply->reply = $request->reply;

            $reply->save();

            return redirect()->back();
        } else {
            return redirect('login');
        }
    }

    public function search_product(Request $request)
    {
        $searchText = $request->search;

        $products = product::where('title', 'LIKE', '%' . $searchText . '%')->paginate(3);

        $comments = Comment::orderby('id', 'DESC')->get();
        $replies = Reply::all();

        return view('home.index', compact('products', 'comments', 'replies'));
    }

    public function all_product(Request $request)
    {
        $searchText = $request->search;
        $products = product::where('title', 'LIKE', '%' . $searchText . '%')->paginate(10);

        $products = Product::paginate(10);
        $comments = Comment::orderby('id', 'DESC')->get();
        $replies = Reply::all();

        return view('home.all_product', compact('products', 'comments', 'replies'));
    }
}
