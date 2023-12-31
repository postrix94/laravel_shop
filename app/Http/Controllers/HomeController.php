<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke() {
        $categories = Category::take(6)->get();
        $products = Product::orderByDesc('id')->take(6)->available()->get();

        return view('home', compact('categories', 'products'));
    }
}
