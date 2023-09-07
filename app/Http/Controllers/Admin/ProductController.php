<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderByDesc('created_at')->simplePaginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create', ['categories' => Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request, IProductRepository $repository )
    {
        return  $repository->create($request->validated())
            ? redirect()->route('admin.products.index')
            : redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $categories = Category::all();
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $slug, IProductRepository $repository)
    {
       $product = Product::where('slug', $slug)->firstOrFail();

       if((float) $request->get('price') !== $product->price) {

           $productInfo = [
               'message' => 'Изменилась цена!',
               'title' => $product->title,
               'url' => route('products.show', ['product' => $product->slug])

           ];

           event(new \App\Events\UserNotify(json_encode($productInfo)));
       }

       $repository->update($product, $request->validated());

       return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $product->categories()->detach();
        $product->delete();

        return redirect()->route('admin.products.index');
    }
}
