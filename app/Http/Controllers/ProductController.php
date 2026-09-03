<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);

        return view('products.index', compact('products'));
    }
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function adminIndex()
    {
        $products = Product::latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $category = Category::pluck('name', 'id');
        return view('admin.products.create', compact('category'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required','integer'],
            'description' => ['nullable','string'],
            'price' => ['required','numeric','min:0'],
            'sale_price' => ['nullable','numeric','min:0'],
            'stock' => ['required','integer','min:0'],
            'size' => ['nullable','string','max:100'],
            'color' => ['nullable','string','max:100'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'status' => ['required','boolean'],
        ]);


        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');

        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success','Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit',compact('product'));
    }

    public function update(Request $request,Product $product)
    {

        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'category_id' => ['required','integer'],
            'description' => ['nullable','string'],
            'price' => ['required','numeric','min:0'],
            'sale_price' => ['nullable','numeric','min:0'],
            'stock' => ['required','integer','min:0'],
            'size' => ['nullable','string','max:100'],
            'color' => ['nullable','string','max:100'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'status' => ['required','boolean'],
        ]);


        if ($request->hasFile('image')) {

            if (
                $product->image &&
                Storage::disk('public')->exists($product->image)
            ) {
                Storage::disk('public')->delete($product->image);
            }


            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);
        return redirect()->route('admin.products.index')->with('success','Product updated successfully.');
    }
    public function delete(Product $product)
    {
        return view('admin.products.delete', compact('product'));
    }

    public function destroy(Product $product)
    {

        if (
            $product->image &&
            Storage::disk('public')->exists($product->image)
        ) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success','Product deleted successfully.');
    }
}
