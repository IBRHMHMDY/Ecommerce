<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // جلب كل الفئات
    public function index()
    {
        return response()->json(Category::all());
    }

    // إنشاء فئة جديدة
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = Category::create($data);

        return response()->json($category, 201);
    }

    // جلب فئة محددة
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    // تعديل فئة
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($data);

        return response()->json($category);
    }

    // حذف فئة
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'تم حذف الفئة']);
    }
}
