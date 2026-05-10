<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        $products = Product::with('category')->paginate(12);

        return view('categories', compact('categories', 'products'));
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::withCount('products')->get();
        $products = Product::where('category_id', $id)->with('category')->paginate(12);

        return view('categories', compact('category', 'categories', 'products'));
    }
}
