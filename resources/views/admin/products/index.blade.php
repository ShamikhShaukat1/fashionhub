@extends('layouts.app')
@section('page', 'Products')
@section('heading', 'Fashion Catalog')
@section('content')

    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-stone-100">
                    Products
                </h1>

                <p class="text-stone-400 mt-1">
                    Manage your product inventory
                </p>
            </div>
            <a href="{{ route('admin.products.create') }}"
                class="px-5 py-3 bg-amber-400 hover:bg-amber-300 text-stone-950 font-semibold text-xs uppercase tracking-widest rounded-xl transition inline-flex items-center justify-center">
                + Add Product
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 px-4 py-3 rounded-xl bg-green-500/10 border border-green-500/30 text-green-400">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-stone-900 border border-stone-800 rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-stone-800/60 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-medium text-white">
                        All Products Items
                    </h3>
                    <p class="text-xs text-stone-500 mt-0.5">
                        Showing all registered atelier products
                    </p>
                </div>

                <div class="text-xs text-stone-400 bg-stone-950/60 px-3 py-1.5 rounded-lg border border-stone-800">
                    Total Items:
                    <span class="font-bold text-amber-400">
                        {{ $products->total() }}
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-stone-800">
                        <tr>
                            <th class="text-left px-6 py-4 text-xs uppercase tracking-widest text-stone-400 font-semibold">
                                Product Name
                            </th>

                            <th class="text-left px-6 py-4 text-xs uppercase tracking-widest text-stone-400 font-semibold">
                                Category
                            </th>

                            <th class="text-left px-6 py-4 text-xs uppercase tracking-widest text-stone-400 font-semibold">
                                Price
                            </th>

                            <th class="text-left px-6 py-4 text-xs uppercase tracking-widest text-stone-400 font-semibold">
                                Stock
                            </th>

                            <th class="text-left px-6 py-4 text-xs uppercase tracking-widest text-stone-400 font-semibold">
                                Status
                            </th>

                            <th class="text-right px-6 py-4 text-xs uppercase tracking-widest text-stone-400 font-semibold">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($products as $product)
                            <tr class="border-t border-stone-800 hover:bg-stone-800/50 transition">
                                <td class="px-6 py-5">
                                    <div class="font-semibold text-stone-100">
                                        {{ $product->name }}
                                    </div>
                                    @if ($product->color || $product->size)
                                        <div class="text-xs text-stone-500 mt-1">
                                            {{ implode(' • ', array_filter([$product->color, $product->size])) }}
                                        </div>
                                    @endif
                                </td>

                                <td class="px-6 py-5 text-stone-400">
                                    @if ($product->category)
                                        {{ $product->category->name }}
                                    @else
                                        Category #{{ $product->category_id }}
                                    @endif
                                </td>

                                <td class="px-6 py-5">
                                    <div class="text-amber-400 font-medium">
                                        ${{ number_format($product->price, 2) }}
                                    </div>

                                    @if ($product->sale_price)
                                        <div class="text-xs text-stone-500 mt-1">
                                            Sale:
                                            ${{ number_format($product->sale_price, 2) }}
                                        </div>
                                    @endif
                                </td>

                                <td class="px-6 py-5">
                                    @if ($product->stock <= 0)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-500/10 border border-red-500/20 text-red-400">
                                            Out of Stock
                                        </span>
                                    @elseif($product->stock <= 5)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 border border-amber-500/20 text-amber-400">
                                            {{ $product->stock }} left
                                        </span>
                                    @else
                                        <span class="text-stone-300">
                                            {{ $product->stock }} units
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-5">
                                    @if ($product->status)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-500/10 border border-green-500/20 text-green-400">
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-500/10 border border-red-500/20 text-red-400">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ route('admin.products.edit', $product) }}"
                                            class="px-4 py-2 bg-amber-400 hover:bg-amber-300 text-stone-950 text-xs font-semibold uppercase tracking-wider rounded-lg transition">
                                            Edit
                                        </a>

                                        <a href="{{ route('admin.products.delete', $product) }}"
                                            class="px-4 py-2 bg-red-500/10 hover:bg-red-500 border border-red-500/30 hover:border-red-500 text-red-400 hover:text-white text-xs font-semibold uppercase tracking-wider rounded-lg transition">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="text-stone-500 text-lg">
                                        No products found.
                                    </div>

                                    <a href="{{ route('admin.products.create') }}"
                                        class="inline-block mt-4 text-amber-400 hover:text-amber-300 text-sm">
                                        Create your first product
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


            @if ($products->hasPages())
                <div class="mt-6 px-6 pb-6">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
