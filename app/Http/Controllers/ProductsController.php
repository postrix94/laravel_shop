<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index() {}

    public function show(string $slug) {
        $product = Product::where('slug',$slug)->firstOrFail();

        return view('products.show', compact('product'));
    }
}
