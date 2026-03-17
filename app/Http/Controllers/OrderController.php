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
            $order = DB::transaction(function () use ($data) {
                $totalPrice = 0;

                $order = Order::create([
                    'total_price' => 0,
                    'status' => 'pending',
                    'user_id' => auth()->id(),
                ]);

                foreach ($data['products'] as $item) {
                    $product = Product::where('slug', $item['product_slug'])->firstOrFail();

                    $unitPrice = $product->price;
                    $linePrice = $item['quantity'] * $unitPrice;

                    $order->products()->attach($product->id, [
                        'quantity' => $item['quantity'],
                        'unit_price' => $unitPrice,
                    ]);

                    $totalPrice += $linePrice;
                    if ($product->stock < $item['quantity']) {
                        throw new \Exception("Product {$product->name} is out of stock.");
                    }
                    $product->decrement('stock', $item['quantity']);
                }

                $order->update(['total_price' => $totalPrice]);

                return $order;
            });

            return response()->json([
                'message' => 'Order created successfully',
                'order_id' => $order->id,
                'total_price' => $order->total_price
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create order: ' . $e->getMessage()], 400);
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
        Gate::authorize('cancel-order', $order);
        $order->delete();
        return response()->json(null, 204);
    }
}
