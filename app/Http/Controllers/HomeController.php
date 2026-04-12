<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::with(['products' => function ($query) {
            $query->where('is_available', true);
        }])->get();

        $products = Product::where('is_available', true)->get();

        return view('pages.home', compact('categories', 'products'));
    }
}
