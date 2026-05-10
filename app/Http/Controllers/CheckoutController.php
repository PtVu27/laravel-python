<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        $cartItems = [];
        $total = 0;

        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity']
                ];
                $total += $product->price * $item['quantity'];
            }
        }

        return view('checkout', compact('cartItems', 'total'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        $userId = auth()->check() ? auth()->id() : null;

        // Create order
        $order = Order::create([
            'code' => 'ORD-' . strtoupper(Str::random(8)),
            'status' => 'pending',
            'user_id' => $userId,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // Create order details
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);

                // Decrease product quantity
                $product->decrement('quantity', $item['quantity']);
            }
        }

        // Clear cart
        session()->forget('cart');

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Đặt hàng thành công!',
                'orderCode' => $order->code,
                'redirect' => route('home')
            ]);
        }

        return redirect()->route('home')->with('success', 'Đặt hàng thành công! Mã đơn hàng: ' . $order->code);
    }
}
