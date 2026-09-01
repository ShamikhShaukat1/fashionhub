@extends('layouts.app')
@section('page', 'Admin Dashboard')
@section('heading', 'Admin Dashboard')
@section('content')

<div class="mb-8">
    <h2 class="text-2xl font-semibold text-white">
        Welcome to Admin Dashboard
    </h2>

    <p class="text-sm text-stone-400 mt-2">
        Manage your FashionHub products and inventory.
    </p>

</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
        <p class="text-xs uppercase tracking-wider text-stone-500">
            Total Products
        </p>

        <h3 class="text-3xl font-bold text-white mt-2">
            {{ $totalProducts }}
        </h3>

    </div>

    <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
        <p class="text-xs uppercase tracking-wider text-stone-500">
            Active Products
        </p>

        <h3 class="text-3xl font-bold text-emerald-400 mt-2">
            {{ $activeProducts }}
        </h3>

    </div>

    <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
        <p class="text-xs uppercase tracking-wider text-stone-500">
            Inactive Products
        </p>

        <h3 class="text-3xl font-bold text-stone-400 mt-2">
            {{ $inactiveProducts }}
        </h3>

    </div>

    <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
        <p class="text-xs uppercase tracking-wider text-stone-500">
            Low Stock
        </p>

        <h3 class="text-3xl font-bold text-amber-400 mt-2">
            {{ $lowStockProducts }}
        </h3>

    </div>

</div>

<div class="mt-8 bg-stone-900 border border-stone-800 rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-stone-800">

        <h3 class="text-lg font-semibold text-white">
            Recent Products
        </h3>

    </div>

    <div class="divide-y divide-stone-800">
        @forelse($products as $product)

        <div class="p-5 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-stone-200">
                    {{ $product->name }}
                </p>

                <p class="text-xs text-stone-500 mt-1">
                    Stock: {{ $product->stock }}
                </p>

            </div>

            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-xs text-amber-400 hover:underline">
                Edit
            </a>

        </div>

        @empty

        <div class="p-6 text-center text-stone-500">
            No products available.
        </div>

        @endforelse

    </div>
</div>

<div class="mt-6">
    <a href="{{ route('admin.products.index') }}" class="inline-flex px-5 py-3 bg-amber-400 hover:bg-amber-300 text-stone-950 font-semibold text-xs uppercase tracking-widest rounded-xl">
        Manage Products
    </a>

</div>

@endsection
