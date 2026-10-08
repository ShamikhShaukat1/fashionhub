@extends('layouts.app')
@section('title', 'Inventory - Fashion Hub')
@section('page', 'Inventory')
@section('heading', 'Inventory Management')
@section('content')

    <div class="max-w-7xl mx-auto space-y-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-semibold text-stone-100">
                    Inventory
                </h2>

                <p class="text-sm text-stone-400 mt-1">
                    Monitor stock levels and manage product inventory.
                </p>
            </div>

            <a href="{{ route('admin.inventory.create') }}"
                class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-semibold transition">
                + Adjust Stock
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-5 py-4 text-emerald-400">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
            <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-6">
                <p class="text-sm text-stone-400">
                    Total Products
                </p>

                <p class="text-3xl font-bold text-stone-100 mt-2">
                    {{ $totalProducts }}
                </p>
            </div>

            <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-6">
                <p class="text-sm text-stone-400">
                    Total Stock
                </p>

                <p class="text-3xl font-bold text-stone-100 mt-2">
                    {{ $totalStock }}
                </p>
            </div>

            <div class="bg-stone-900/60 border border-amber-500/20 rounded-2xl p-6">
                <p class="text-sm text-stone-400">
                    Low Stock
                </p>

                <p class="text-3xl font-bold text-amber-400 mt-2">
                    {{ $lowStockProducts }}
                </p>
            </div>

            <div class="bg-stone-900/60 border border-red-500/20 rounded-2xl p-6">
                <p class="text-sm text-stone-400">
                    Out of Stock
                </p>

                <p class="text-3xl font-bold text-red-400 mt-2">
                    {{ $outOfStockProducts }}
                </p>
            </div>

        </div>

        <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-stone-800">
                        <tr class="text-left text-sm text-stone-400">
                            <th class="px-6 py-4">
                                Product
                            </th>

                            <th class="px-6 py-4">
                                Current Stock
                            </th>

                            <th class="px-6 py-4">
                                Status
                            </th>

                            <th class="px-6 py-4 text-right">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stone-800">
                        @forelse($products as $product)
                            <tr class="hover:bg-stone-800/40 transition">
                                <td class="px-6 py-5">
                                    <div class="font-medium text-stone-100">
                                        {{ $product->name }}
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <span class="font-semibold text-stone-100">
                                        {{ $product->stock }}
                                    </span>
                                </td>

                                <td class="px-6 py-5">
                                    @if ($product->stock == 0)
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-red-500/10 text-red-400 border border-red-500/20">
                                            Out of Stock
                                        </span>
                                    @elseif($product->stock <= 5)
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                            Low Stock
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            In Stock
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ route('admin.inventory.show', $product) }}"
                                            class="px-3 py-2 rounded-lg bg-stone-800 hover:bg-stone-700 text-stone-300 text-sm transition">
                                            History
                                        </a>

                                        <a href="{{ route('admin.inventory.create', ['product_id' => $product->id]) }}"
                                            class="px-3 py-2 rounded-lg bg-amber-500 hover:bg-amber-400 text-stone-950 text-sm font-semibold transition">
                                            Adjust
                                        </a>
                                    </div>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-stone-500">
                                    No products found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($products->hasPages())
                <div class="px-6 py-5 border-t border-stone-800">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection
