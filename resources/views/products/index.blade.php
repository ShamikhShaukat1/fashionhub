@extends('layouts.app')

@section('page', 'Products')
@section('heading', 'Fashion Catalog')
@section('content')

<div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
    <div>
        <h2 class="text-2xl font-semibold text-white">
            Fashion Catalog
        </h2>

    </div>
</div>


@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm flex items-center justify-between">
    <span>{{ session('success') }}</span>
    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-200 text-xs font-bold uppercase tracking-wider">
        Dismiss
    </button>
</div>
@endif

<div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl overflow-hidden shadow-xl">
    <div class="p-6 border-b border-stone-800/60 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-medium text-white">
                All Inventory Items
            </h3>
            <p class="text-xs text-stone-500 mt-0.5">
                Showing all registered atelier products
            </p>
        </div>

        <div class="text-xs text-stone-400 bg-stone-950/60 px-3 py-1.5 rounded-lg border border-stone-800 self-start sm:self-auto">
            Total Items: <span class="font-bold text-amber-400">{{ $products->total() ?? count($products) }}</span>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-stone-950/60">
                <tr class="border-b border-stone-800 text-[11px] uppercase tracking-wider text-stone-400">
                    <th class="p-4">Product Name</th>
                    <th class="p-4">Category</th>
                    <th class="p-4">Price</th>
                    <th class="p-4">Stock</th>
                    <th class="p-4">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-stone-800/50">
                @forelse($products as $product)
                <tr class="hover:bg-stone-800/30 transition">

                    <td class="p-4">
                        <div class="font-medium text-stone-200">
                            {{ $product->name }}
                        </div>
                        @if($product->color || $product->size)
                        <div class="text-xs text-stone-500 mt-0.5">
                            {{ implode(' • ', array_filter([$product->color, $product->size])) }}
                        </div>
                        @endif
                    </td>

                    <td class="p-4 text-sm text-stone-400">
                        {{ $product->category->name ?? '' . $product->category_id }}
                    </td>

                    <td class="p-4 text-sm font-medium">
                        <span class="text-amber-400">
                            ${{ number_format($product->price, 2) }}
                        </span>
                        @if($product->sale_price)
                        <span class="block text-xs text-stone-500 line-through">
                            ${{ number_format($product->sale_price, 2) }}
                        </span>
                        @endif
                    </td>

                    <td class="p-4 text-sm">
                        @if($product->stock <= 0)
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-rose-500/10 text-rose-400 border border-rose-500/20">
                            Out of Stock
                            </span>
                        @elseif($product->stock <= 5)
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                            {{ $product->stock }} left
                            </span>
                        @else
                            <span class="text-stone-300">
                                {{ $product->stock }} units
                            </span>
                        @endif
                    </td>

                    <td class="p-4 text-sm">
                        @if($product->status)
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                            Active
                        </span>
                        @else
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-stone-800 text-stone-400 border border-stone-700">
                            Inactive
                        </span>
                        @endif
                    </td>


                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-stone-500">
                        No products found in the atelier catalog.
                        <a href="{{ route('products.create') }}" class="text-amber-400 hover:underline ml-1">
                            Create one now
                        </a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($products, 'links') && $products->hasPages())
    <div class="p-4 border-t border-stone-800/60">
        {{ $products->links() }}
    </div>
    @endif

</div>

@endsection
