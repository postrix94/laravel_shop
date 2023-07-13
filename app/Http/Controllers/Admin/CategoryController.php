<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderByDesc('created_at')->paginate(10);
        return view('admin.categories.index', ['title' => 'All Categories', 'categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.categories.create', ['title' =>'Создать категорию', 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        $fields = $request->validated();
        $fields['slug'] = $fields['name'];
        Category::create($fields);

        return redirect()->route('admin.categories.index');
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
        $category = Category::where('slug', $slug)->firstOrFail();
        $categories = Category::all();

        return view('admin.categories.edit', ['title' =>'Редактировать категорию', 'category' => $category, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $fields = $request->validated();
        $fields['slug'] = $fields['name'];

        $category->updateOrFail($fields);

        return redirect()->route('admin.categories.edit', ['category' => $category->slug]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $this->middleware('permission:' . config('permission.access.categories.delete'));
        $category = Category::where('slug', $slug)->firstOrFail();

        if ($category->childs()->exists()) {
            $category->childs()->update(['parent_id' => null]);
        }

        $category->deleteOrFail();

        return redirect()->route('admin.categories.index');
    }
}
