<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        Category::create([
            'name' => $request->name
        ]);

        return back()->with('success', 'Kategori kopi ditambahkan');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Kategori kopi dihapus');
    }
}
