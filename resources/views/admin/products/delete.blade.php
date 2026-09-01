@extends('layouts.app')
@section('page', 'Delete Confirmation')

@section('content')
<div class="max-w-2xl mx-auto mt-8">
    <div class="bg-stone-900/80 border border-stone-800 rounded-2xl p-6 md:p-8 backdrop-blur-sm">

        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 rounded-xl bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-400 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-white">Delete Product Confirmation</h2>
                <p class="text-xs text-stone-400 mt-0.5">This action cannot be undone and will remove the item permanently.</p>
            </div>
        </div>

        <div class="p-4 bg-stone-950/60 border border-stone-800/80 rounded-xl mb-6 space-y-3">
            <div class="flex justify-between items-center text-xs">
                <span class="text-stone-400">Product Name</span>
                <span class="font-semibold text-stone-200">{{ $product->name }}</span>
            </div>
            <div class="flex justify-between items-center text-xs">
                <span class="text-stone-400">Category ID</span>
                <span class="font-mono text-stone-300">CAT-{{ str_pad($product->category_id, 3, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="flex justify-between items-center text-xs">
                <span class="text-stone-400">Price</span>
                <span class="font-mono font-bold text-amber-400">${{ number_format($product->price, 2) }}</span>
            </div>
            <div class="flex justify-between items-center text-xs">
                <span class="text-stone-400">Stock Available</span>
                <span class="text-stone-300">{{ $product->stock }} units</span>
            </div>
        </div>

        <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3">
            <a href="{{ route('admin.products.index') }}"
               class="w-full sm:w-auto px-5 py-2.5 bg-stone-800 hover:bg-stone-700 text-stone-300 text-xs font-semibold rounded-xl transition text-center border border-stone-700">
                Cancel, Keep Product
            </a>

            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="w-full sm:w-auto">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full sm:w-auto px-5 py-2.5 bg-rose-500 hover:bg-rose-600 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition shadow-lg shadow-rose-500/20">
                    Confirm & Delete
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
