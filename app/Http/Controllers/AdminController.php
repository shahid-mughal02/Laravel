<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use PDF;
use Notification;
use App\Notifications\SendEmailNotification;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function view_category()
    {
        if (Auth::id()) {
            $categories = Category::all();
            return view('admin.category', compact('categories'));
        } else {
            return redirect('login');
        }
    }

    public function add_category(Request $request)
    {
        if (Auth::id()) {
            $product = new category;
            $product->category = $request->category;

            $product->save();

            return redirect()->back()->with('message', 'Category added successfully');
        } else {
            return redirect('login');
        }
    }

    public function delete_category($id)
    {
        if (Auth::id()) {
            $category = Category::find($id);

            $category->delete();
            return redirect()->back();
        } else {
            return redirect('login');
        }
    }

    public function view_product()
    {
        if (Auth::id()) {
            $categories = Category::all();
            $products = Product::all();

            return view('admin.product', compact('categories', 'products'));
        } else {
            return redirect('login');
        }
    }

    public function add_product(Request $request)
    {
        if (Auth::id()) {
            $product = new product;

            $product->title = $request->title;
            $product->description = $request->description;
            $product->quantity = $request->quantity;
            $product->price = $request->price;
            $product->discount_price = $request->discount_price;
            $product->category = $request->category;

            //Handling Image
            $image = $request->image;
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move('product', $imagename);
            $product->image = $imagename;

            $product->save();

            return redirect()->back()->with('message', 'Product added successfully');
        } else {
            return redirect('login');
        }
    }

    public function edit_product($id)
    {
        if (Auth::id()) {
            $categories = Category::all();
            $product = Product::find($id);

            return view('admin.edit_product', compact('categories', 'product'));
        } else {
            return redirect('login');
        }
    }

    public function update_product(Request $request, $id)
    {
        if (Auth::id()) {
            $product = Product::find($id);

            $product->title = $request->title;
            $product->description = $request->description;
            $product->quantity = $request->quantity;
            $product->price = $request->price;
            $product->discount_price = $request->discount_price;
            $product->category = $request->category;

            //Handling Image
            $image = $request->image;
            if ($request->has('image')) {
                $imagename = time() . '.' . $image->getClientOriginalExtension();
                $request->image->move('product', $imagename);
                $product->image = $imagename;
            }

            $product->save();

            return redirect()->back()->with('message', 'Product updated successfully');
        } else {
            return redirect('login');
        }
    }

    public function delete_product($id)
    {
        $product = Product::find($id);

        $product->delete();
        return redirect()->back();
    }

    public function order()
    {
        $orders = Order::all();

        return view('admin.order', compact('orders'));
    }

    public function delivered($id)
    {
        $order = Order::find($id);

        if ($order->payment_status == 'Cash On Delivery') {
            $order->payment_status = 'Paid';
        } else {
            $order->payment_status = 'Cash On Delivery';
        }

        if ($order->delivery_status == 'Processing') {
            $order->delivery_status = 'Delivered';
        } else {
            $order->delivery_status = 'Processing';
        }

        $order->save();

        return redirect()->back();
    }

    public function delete_order($id)
    {
        $order = Order::find($id);

        $order->delete();
        return redirect()->back();
    }

    public function print_pdf($id)
    {
        $order = Order::find($id);
        $pdf = PDF::loadView('admin.pdf', compact('order'));

        return $pdf->download('order_details_' . $id . '.pdf');
    }

    public function send_email($id)
    {
        $order = Order::find($id);

        return view('admin.email_info', compact('order'));
    }

    public function send_user_email(Request $request, $id)
    {
        $order = Order::find($id);

        $details = [
            'greeting' => $request->email_title,
            'body' => $request->email_body,
            'button' => $request->email_button,
            'url' => $request->email_url,
            'end' => $request->email_end,
        ];

        Notification::send($order, new SendEmailNotification($details));

        return redirect()->back()->with('message', 'Email Sent Successfully');
    }

    public function search(Request $request)
    {
        $searchText = $request->search;

        $orders = order::where('name', 'LIKE', '%' . $searchText . '%')->orWhere('phone', 'LIKE', '%' . $searchText . '%')->orWhere('email', 'LIKE', '%' . $searchText . '%')->orWhere('product_title', 'LIKE', '%' . $searchText . '%')->orWhere('phone', 'LIKE', '%' . $searchText . '%')->get();

        return view('admin.order', compact('orders'));
    }
}
