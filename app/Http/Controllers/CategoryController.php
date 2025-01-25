<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return view('admin.category.index', compact('category'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);

        Category::create([
            'name' => $request->name,
        ]);
        return redirect('/');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.update', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);

        $category = Category::find($id);
        $category->update([
            'name' => $request->name,
        ]);
        return redirect('/');
    }


    // public function index()
    // {
    //     $category = Category::all();
    //     return CategoryResource::collection($category);
    // }

    // public function create()
    // {
    //     return view('admin.category.create');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|unique:categories|max:255',
    //     ]);

    //     $category = Category::create([
    //         'name' => $request->name,
    //     ]);
    //     return response()->json($category);
    // }

    // public function edit($id)
    // {
    //     $category = Category::find($id);
    //     return response()->json($category);
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'name' => 'required|unique:categories|max:255',
    //     ]);

    //     $category = Category::find($id);
    //     $category->update([
    //         'name' => $request->name,
    //     ]);
    //     return response()->json($category);
    // }

    // public function destroy($id)
    // {
    //     $category = Category::find($id);
    //     $category->delete();
    //     return response()->json($category);
    // }
    
}
