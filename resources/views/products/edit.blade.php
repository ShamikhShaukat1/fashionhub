@extends('layouts.app')
@section('page', 'Products')
@section('heading', 'Edit Product')
@section('content')

<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-semibold text-white">
                Edit Product Entry
            </h2>
            <p class="text-xs text-stone-400 mt-1">
                Updating details for: <span class="text-amber-400 font-medium">{{ $product->name }}</span>
            </p>
        </div>

        <a href="{{ route('products.index') }}"
           class="px-5 py-3 bg-stone-800 hover:bg-stone-700 text-stone-300 font-semibold text-xs uppercase tracking-widest rounded-xl transition">
            ← Back to Products
        </a>

    </div>

    @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-sm">
            <p class="font-semibold mb-2">Please correct the following errors:</p>
            <ul class="list-disc list-inside space-y-1 text-xs">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-6 sm:p-8 shadow-xl">
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <label class="block text-xs uppercase tracking-wider font-semibold text-stone-400 mb-2">
                        Product Name *
                    </label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                           class="w-full px-4 py-3 bg-stone-950/60 border border-stone-800 rounded-xl text-stone-200 text-sm focus:outline-none focus:border-amber-400 transition">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider font-semibold text-stone-400 mb-2">
                        Category ID *
                    </label>
                    <input type="number" name="category_id" value="{{ old('category_id', $product->category_id) }}" required
                           class="w-full px-4 py-3 bg-stone-950/60 border border-stone-800 rounded-xl text-stone-200 text-sm focus:outline-none focus:border-amber-400 transition">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider font-semibold text-stone-400 mb-2">
                        Stock Units *
                    </label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required
                           class="w-full px-4 py-3 bg-stone-950/60 border border-stone-800 rounded-xl text-stone-200 text-sm focus:outline-none focus:border-amber-400 transition">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider font-semibold text-stone-400 mb-2">
                        Regular Price ($) *
                    </label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required
                           class="w-full px-4 py-3 bg-stone-950/60 border border-stone-800 rounded-xl text-stone-200 text-sm focus:outline-none focus:border-amber-400 transition">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider font-semibold text-stone-400 mb-2">
                        Sale Price ($)
                    </label>
                    <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}"
                           class="w-full px-4 py-3 bg-stone-950/60 border border-stone-800 rounded-xl text-stone-200 text-sm focus:outline-none focus:border-amber-400 transition">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider font-semibold text-stone-400 mb-2">
                        Available Sizes
                    </label>
                    <input type="text" name="size" value="{{ old('size', $product->size) }}"
                           class="w-full px-4 py-3 bg-stone-950/60 border border-stone-800 rounded-xl text-stone-200 text-sm focus:outline-none focus:border-amber-400 transition">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider font-semibold text-stone-400 mb-2">
                        Color / Shade
                    </label>
                    <input type="text" name="color" value="{{ old('color', $product->color) }}"
                           class="w-full px-4 py-3 bg-stone-950/60 border border-stone-800 rounded-xl text-stone-200 text-sm focus:outline-none focus:border-amber-400 transition">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider font-semibold text-stone-400 mb-2">
                        Publishing Status
                    </label>
                    <select name="status"
                            class="w-full px-4 py-3 bg-stone-950 border border-stone-800 rounded-xl text-stone-200 text-sm focus:outline-none focus:border-amber-400 transition">
                        <option value="1" {{ old('status', $product->status) == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $product->status) == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider font-semibold text-stone-400 mb-2">
                        Product Image
                    </label>
                    @if($product->image)
                        <div class="flex items-center gap-3 mb-2">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image" class="w-10 h-10 object-cover rounded-lg border border-stone-800">
                            <span class="text-xs text-stone-500">Current Image</span>
                        </div>
                    @endif
                    <input type="file" name="image"
                           class="w-full px-3 py-2.5 bg-stone-950/60 border border-stone-800 rounded-xl text-stone-400 text-xs focus:outline-none focus:border-amber-400 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-stone-800 file:text-stone-200 hover:file:bg-stone-700 transition">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs uppercase tracking-wider font-semibold text-stone-400 mb-2">
                        Description
                    </label>
                    <textarea name="description" rows="4"
                              class="w-full px-4 py-3 bg-stone-950/60 border border-stone-800 rounded-xl text-stone-200 text-sm focus:outline-none focus:border-amber-400 transition">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>

            <div class="pt-4 border-t border-stone-800/80 flex items-center justify-end gap-4">
                <a href="{{ route('products.index') }}"
                   class="px-5 py-3 rounded-xl bg-stone-800 hover:bg-stone-700 text-stone-300 font-semibold text-xs uppercase tracking-wider transition">
                    Cancel
                </a>

                <button type="submit"
                        class="px-6 py-3 bg-amber-400 hover:bg-amber-300 text-stone-950 font-semibold text-xs uppercase tracking-widest rounded-xl transition">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
