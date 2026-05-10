<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('category')->orderBy('view', 'desc')->take(8)->get();
        $newProducts = Product::with('category')->orderBy('created_at', 'desc')->take(8)->get();
        $categories = Category::withCount('products')->get();

        return view('home', compact('featuredProducts', 'newProducts', 'categories'));
    }
}
