<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Notifications\GenericNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->paginate(5);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category = Category::create($validated);

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new GenericNotification(
                title: 'Category Created',
                message: 'Category "' . $category->name . '" has been created successfully.',
                type: 'success',
                url: route('admin.categories.index')
            ));
        }

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new GenericNotification(
                title: 'Category Updated',
                message: 'Category "' . $category->name . '" has been updated.',
                type: 'info',
                url: route('admin.categories.index')
            ));
        }

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function confirmDelete(Category $category)
    {
        $category->loadCount('products');

        return view('admin.categories.delete', compact('category'));
    }

    public function destroy(Category $category)
    {
        $categoryName = $category->name;

        $category->delete();

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new GenericNotification(
                title: 'Category Deleted',
                message: 'Category "' . $categoryName . '" has been deleted.',
                type: 'error',
                url: route('admin.categories.index')
            ));
        }

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
