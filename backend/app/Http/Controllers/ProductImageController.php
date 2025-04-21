<?php
namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $path = $request->file('image')->store('products', 'public');

        $image = ProductImage::create([
            'product_id' => $request->product_id,
            'image_url' => '/storage/' . $path
        ]);

        return response()->json($image, 201);
    }

    public function destroy($id)
    {
        $image = ProductImage::findOrFail($id);

        // حذف الملف من التخزين
        $imagePath = str_replace('/storage/', '', $image->image_url);
        Storage::disk('public')->delete($imagePath);

        $image->delete();

        return response()->json(['message' => 'تم حذف الصورة']);
    }
}
