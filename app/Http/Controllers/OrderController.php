<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $orders = Order::with('products')->where('user_id', auth()->id())->get();
        return response()->json($orders, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();

        try {
            DB::transaction(function () use ($data, &$order, &$price) {
                $price = 0;
                $order = Order::create([
                    'total_price' => 0,
                    'status' => 'pending',
                    'user_id' => auth()->id(),
                ]);

                foreach ($data['products'] as $product) {
                    $produit = Product::find($product['product_id']);
                    $unitPrice = $produit->price;

                    $order->products()->attach($product['product_id'], [
                        'quantity' => $product['quantity'],
                        'unit_price' => $unitPrice,
                    ]);

                    $price += $product['quantity'] * $unitPrice;
                }

                $order->update(['total_price' => $price]);
            });

            return response()->json([
                'message' => 'Order created successfully',
                'total_price' => $price
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        Gate::authorize('view-order', $order);
        return response()->json($order->load('products'), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        Gate::authorize('manage-orders');
        $data = $request->validated();
        $order->update($data);
        return response()->json($order, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}
