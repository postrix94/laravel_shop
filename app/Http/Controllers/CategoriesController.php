<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index() {}

    public function show(string $slug) {
        $product = Category::where('slug', $slug)->firstOrFail();
    }
}
