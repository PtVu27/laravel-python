<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $product->increment('view');

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('product', compact('product', 'relatedProducts'));
    }
}
