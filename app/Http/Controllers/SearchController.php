<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q', '');
        $categoryId = $request->input('category');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $sort = $request->input('sort', 'relevance');

        $products = Product::with('category');

        if ($query) {
            $products->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            });
        }

        if ($categoryId) {
            $products->where('category_id', $categoryId);
        }

        if ($minPrice) {
            $products->where('price', '>=', $minPrice);
        }

        if ($maxPrice) {
            $products->where('price', '<=', $maxPrice);
        }

        switch ($sort) {
            case 'price_asc':
                $products->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $products->orderBy('price', 'desc');
                break;
            case 'newest':
                $products->orderBy('created_at', 'desc');
                break;
            case 'popular':
                $products->orderBy('view', 'desc');
                break;
            default:
                if ($query) {
                    $products->orderByRaw("CASE WHEN name LIKE ? THEN 1 ELSE 2 END", ["%{$query}%"]);
                }
                $products->orderBy('created_at', 'desc');
                break;
        }

        $products = $products->paginate(12)->appends($request->query());
        $categories = Category::withCount('products')->get();

        return view('search', compact('products', 'categories', 'query', 'categoryId', 'minPrice', 'maxPrice', 'sort'));
    }
}
