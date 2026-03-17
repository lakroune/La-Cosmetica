<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('products.view')) {
           
        }
        $products = Product::with('category')->get();
        return response()->json(["message" => "Products found successfully", "products" => $products], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        if (!auth()->user()->can('products.create')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $data = $request->validated();
        $product = Product::create($data);

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        if (!auth()->user()->can('products.view')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return response()->json(["message" => "Product found successfully", "product" => $product->load('category')], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        if (!auth()->user()->can('products.update')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $data = $request->validated();
        $product->update($data);
        return response()->json(["message" => "Product updated successfully", "product" => $product], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (!auth()->user()->can('products.delete')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 204);
    }
}
