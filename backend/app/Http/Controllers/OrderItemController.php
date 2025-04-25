<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function getOrderItems($id)
    {
        $orderItem = OrderItem::with('items.product')->findOrFail($id);
        return response()->json($orderItem->items);
    }
}
