<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
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

        return view('cart', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $product = Product::findOrFail($productId);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        if ($request->ajax()) {
            $cartCount = array_sum(array_column($cart, 'quantity'));
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào giỏ hàng!',
                'cartCount' => $cartCount
            ]);
        }

        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    public function update(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $cart = session()->get('cart', []);

        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $quantity;
            }
        }

        session()->put('cart', $cart);

        if ($request->ajax()) {
            $product = Product::find($productId);
            $subtotal = $product ? $product->price * $quantity : 0;
            $total = 0;
            foreach ($cart as $id => $item) {
                $p = Product::find($id);
                if ($p) $total += $p->price * $item['quantity'];
            }
            $cartCount = array_sum(array_column($cart, 'quantity'));

            return response()->json([
                'success' => true,
                'subtotal' => $subtotal,
                'total' => $total,
                'cartCount' => $cartCount
            ]);
        }

        return redirect()->route('cart.index');
    }

    public function remove(Request $request)
    {
        $productId = $request->input('product_id');
        $cart = session()->get('cart', []);

        unset($cart[$productId]);
        session()->put('cart', $cart);

        if ($request->ajax()) {
            $total = 0;
            foreach ($cart as $id => $item) {
                $p = Product::find($id);
                if ($p) $total += $p->price * $item['quantity'];
            }
            $cartCount = array_sum(array_column($cart, 'quantity'));

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa sản phẩm khỏi giỏ hàng!',
                'total' => $total,
                'cartCount' => $cartCount
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm!');
    }

    public function count()
    {
        $cart = session()->get('cart', []);
        $count = array_sum(array_column($cart, 'quantity'));
        return response()->json(['count' => $count]);
    }
}
