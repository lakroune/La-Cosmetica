<?php

namespace App\DAOs;

use App\DTOs\OrderDTO;
use App\Models\Order;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderDAO
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function create(OrderDTO $dto): Order
    {
        return DB::transaction(function () use ($dto) {
            $totalPrice = 0;
            $orderItems = [];

            foreach ($dto->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    throw new Exception("Not enough stock for {$product->name}");
                }

                $unitPrice = $product->price;
                $totalPrice += $unitPrice * $item['quantity'];

                $orderItems[$product->id] = [
                    'quantity' => $item['quantity'],
                    'unit_price' => $unitPrice
                ];

                $product->decrement('stock', $item['quantity']);
            }

            $order = Order::create([
                'user_id' => $dto->user_id,
                'total_price' => $totalPrice,
                'status' => 'pending'
            ]);

            $order->products()->attach($orderItems);

            return $order->load('products');
        });
    }
}
