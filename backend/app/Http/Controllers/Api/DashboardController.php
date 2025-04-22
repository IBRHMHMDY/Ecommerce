<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Welcome to the dashboard!'
        ]);
    }

    public function getStats()
    {
        // هنا يمكنك إضافة منطق لجلب إحصائيات معينة
        return response()->json([
            'users_count' => 100,
            'products_count' => 50,
            'orders_count' => 200,
        ]);
    }
}
