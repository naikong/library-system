<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        // Create a new category
        $category = new Category();
        $category->category_name = $request->input('category_name');
        $category->save();

        // Redirect back with a success message
        return redirect()->back()->with('book_create', 'Category added successfully!');
    }
}
