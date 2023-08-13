<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index() {}

    public function show(Category $category) {
        $product = $category->products;
    }
}
