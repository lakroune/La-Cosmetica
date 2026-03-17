<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $stats = [
            'total_sales' => DB::table('orders')
                ->where('status', 'completed')
                ->sum('total_price'),

            'popular_products' => DB::table('order_products') // تصحيح اسم الجدول هنا
                ->join('products', 'order_products.product_id', '=', 'products.id')
                ->select('products.name', DB::raw('SUM(order_products.quantity) as qty'))
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('qty')
                ->limit(5)
                ->get(),

            'categories_chart' => DB::table('categories')
                ->leftJoin('products', 'categories.id', '=', 'products.category_id')
                ->select('categories.name', DB::raw('count(products.id) as count'))
                ->groupBy('categories.id', 'categories.name')
                ->get(),
        ];

        return response()->json([
            "message" => "Statistics retrieved successfully",
            "data" => $stats
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
