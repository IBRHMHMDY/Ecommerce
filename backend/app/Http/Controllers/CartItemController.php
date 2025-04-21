<?php
namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
    // عرض العربة
    public function index()
    {
        $user = Auth::user();

        $items = CartItem::with('product')
                    ->where('user_id', $user->id)
                    ->get();

        return response()->json($items);
    }

    // إضافة منتج للعربة أو تحديث الكمية
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $user = Auth::user();

        $cartItem = CartItem::updateOrCreate(
            ['user_id' => $user->id, 'product_id' => $request->product_id],
            ['quantity' => $request->quantity]
        );

        return response()->json($cartItem);
    }

    // تعديل كمية منتج
    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $item = CartItem::findOrFail($id);

        if ($item->user_id !== Auth::id()) {
            return response()->json(['message' => 'غير مصرح'], 403);
        }

        $item->update(['quantity' => $request->quantity]);

        return response()->json($item);
    }

    // حذف منتج من العربة
    public function destroy($id)
    {
        $item = CartItem::findOrFail($id);

        if ($item->user_id !== Auth::id()) {
            return response()->json(['message' => 'غير مصرح'], 403);
        }

        $item->delete();

        return response()->json(['message' => 'تم حذف المنتج من العربة']);
    }
}
