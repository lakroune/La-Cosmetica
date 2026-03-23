<?php

namespace App\Http\Controllers;

use App\DTOs\ProductDTO;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Exception;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productService->getAllProducts();
        return response()->json($products);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {

        try {
            $dto = ProductDTO::fromRequest($request);
            $product = $this->productService->createProduct($dto);

            return response()->json([
                'message' => 'Product created successfully',
                'data' => $product
            ], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        try {
            $product = $this->productService->getProductBySlug($slug);
            return response()->json($product);
        } catch (\Exception $e) {
            return response()->json(['error' => 'this product does not exist'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {

        $data = $request->validated();
        $product->update($data);
        return response()->json(["message" => "Product updated successfully", "product" => $product], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {

        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 204);
    }
}
