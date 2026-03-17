<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        if (!auth()->user()->can('categories.create')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $data = $request->validated();
        $category = Category::create($data);

        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        if (!auth()->user()->can('categories.view')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return response()->json($category, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        if (!auth()->user()->can('categories.update')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $data = $request->validated();
        $category->update($data);
        return response()->json($category, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if (!auth()->user()->can('categories.delete')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $category->delete();
        return response()->json(null, 204);
    }
}
