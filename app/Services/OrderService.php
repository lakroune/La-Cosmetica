<?php

namespace App\Services;

use App\DAOs\OrderDAO;
use App\DTOs\OrderDTO;
use Exception;
use Illuminate\Support\Facades\Log;

class OrderService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected OrderDAO $orderDAO)
    {
        //
    }

    public function placeOrder(OrderDTO $dto)
    {
        try {
            $order = $this->orderDAO->create($dto);

            Log::info("Order created successfully: " . $order->id);

            return $order;
        } catch (Exception $e) {
            throw new Exception("Failed to create order: " . $e->getMessage());
        }
    }
}
