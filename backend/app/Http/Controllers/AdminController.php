<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $productCount  = Product::count();
        $categoryCount = Category::count();
        $orderCount    = Order::count();
        return response()->json([
            'products_count' => $productCount,
            'orders_count' => $orderCount,
            'categories_count' => $categoryCount,
        ]);
    }

    public function getStats()
    {
        $productCount  = Product::count();
        $categoryCount = Category::count();
        $orderCount    = Order::count();
        return response()->json([
            'products_count' => $productCount,
            'orders_count' => $orderCount,
            'categories_count' => $categoryCount,
        ]);
    }
}
