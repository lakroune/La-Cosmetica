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
        $products = Product::with('category')->get();
        return response()->json($products, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        Gate::authorize('manage-products');
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);

        return response()->json([
            'message' => 'Produit ajouté avec succès',
            'product' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json($product, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        Gate::authorize('manage-products');
        $data = $request->validated();
        $product->update($data);
        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        Gate::authorize('manage-products');
        $product->delete();
        return response()->json(null, 204);
    }
}
