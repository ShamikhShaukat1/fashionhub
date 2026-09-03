@extends('layouts.app')
@section('page', 'Products')
@section('heading', 'Add New Product')
@section('content')


<div class="w-full max-w-5xl mx-auto">
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-white">
            Create Product Entry
        </h2>

        <p class="text-xs text-stone-400 mt-1">
            Add a new fashion item to your atelier catalog
        </p>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-sm">
        <p class="font-semibold mb-2">
            Please correct the following errors:
        </p>

        <ul class="list-disc list-inside space-y-1 text-xs">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="w-full bg-stone-900/60 border border-stone-800/80 rounded-2xl p-6 sm:p-8">
        <form
            action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <label class="block text-xs uppercase tracking-wider font-semibold text-stone-400 mb-2"> Product Name * </label>
                    <input
                        type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Silk Midnight Gown"
                        class="w-full px-4 py-3 bg-stone-950/60 border border-stone-800 rounded-xl text-stone-200 text-sm focus:outline-none focus:border-amber-400 transition placeholder:text-stone-600">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider font-semibold text-stone-400 mb-2"> Category * </label>
                    <select
                        name="category_id" required class="w-full px-4 py-3 bg-stone-950 border border-stone-800 rounded-xl text-stone-200 text-sm focus:outline-none focus:border-amber-400 transition cursor-pointer">
                        <option value="" disabled {{ old('category_id') ? '' : 'selected' }} class="bg-stone-900 text-stone-500">
                            Select category
                        </option>

                        @foreach($category as $id => $name)
                            <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }} class="bg-stone-900 text-stone-200">
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider font-semibold text-stone-400 mb-2"> Stock Units * </label>
                    <input type="number" name="stock" value="{{ old('stock') }}" required placeholder="0"
                        class="w-full px-4 py-3 bg-stone-950/60 border border-stone-800 rounded-xl text-stone-200 text-sm focus:outline-none focus:border-amber-400 transition placeholder:text-stone-600">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider font-semibold text-stone-400 mb-2"> Regular Price ($) * </label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" required placeholder="0.00"
                        class="w-full px-4 py-3 bg-stone-950/60 border border-stone-800 rounded-xl text-stone-200 text-sm focus:outline-none focus:border-amber-400 transition placeholder:text-stone-600">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider font-semibold text-stone-400 mb-2"> Sale Price ($) </label>
                    <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price') }}" placeholder="0.00"
                        class="w-full px-4 py-3 bg-stone-950/60 border border-stone-800 rounded-xl text-stone-200 text-sm focus:outline-none focus:border-amber-400 transition placeholder:text-stone-600">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider font-semibold text-stone-400 mb-2"> Available Sizes </label>
                    <input type="text" name="size" value="{{ old('size') }}" placeholder="S, M, L, XL"
                        class="w-full px-4 py-3 bg-stone-950/60 border border-stone-800 rounded-xl text-stone-200 text-sm focus:outline-none focus:border-amber-400 transition placeholder:text-stone-600">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider font-semibold text-stone-400 mb-2"> Color / Shade </label>
                    <input type="text" name="color" value="{{ old('color') }}" placeholder="e.g. Midnight Black"
                        class="w-full px-4 py-3 bg-stone-950/60 border border-stone-800 rounded-xl text-stone-200 text-sm focus:outline-none focus:border-amber-400 transition placeholder:text-stone-600">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider font-semibold text-stone-400 mb-2"> Publishing Status </label>
                    <select name="status" class="w-full px-4 py-3 bg-stone-950 border border-stone-800 rounded-xl text-stone-200 text-sm focus:outline-none focus:border-amber-400 transition">
                        <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs uppercase tracking-wider font-semibold text-stone-400 mb-2">
                        Description
                    </label>
                    <textarea name="description" rows="4" placeholder="Describe the material, fit, and craftsmanship..."
                        class="w-full px-4 py-3 bg-stone-950/60 border border-stone-800 rounded-xl text-stone-200 text-sm focus:outline-none focus:border-amber-400 transition placeholder:text-stone-600">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="pt-4 border-t border-stone-800/80 flex items-center justify-end gap-4">

                <a
                    href="{{ route ('admin.products.index') }}"
                    class="px-5 py-3 rounded-xl bg-stone-800 hover:bg-stone-700 text-stone-300 font-semibold text-xs uppercase tracking-wider transition">
                    Cancel
                </a>

                <button
                    type="submit"
                    class="px-6 py-3 bg-amber-400 hover:bg-amber-300 text-stone-950 font-semibold text-xs uppercase tracking-widest rounded-xl transition">
                    Save Product
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
