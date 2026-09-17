@extends('layouts.app')
@section('title', $product->name)
@section('page', 'Product Details')
@section('heading', 'Product Details')
@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="bg-stone-950 flex items-center justify-center p-8 min-h-[400px]">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="w-full max-w-md h-[400px] object-contain rounded-xl">
                    @else
                        <div
                            class="w-full max-w-md h-[400px] flex items-center justify-center bg-stone-900 rounded-xl border border-stone-800">
                            <span class="text-stone-500 text-lg">
                                No Image Available
                            </span>
                        </div>
                    @endif
                </div>

                <div class="p-8 flex flex-col justify-center">
                    @if ($product->category)
                        <p class="text-amber-400 text-sm font-semibold uppercase tracking-wider mb-3">
                            {{ $product->category->name }}
                        </p>
                    @endif

                    <h1 class="text-3xl md:text-4xl font-bold text-stone-100 mb-5">
                        {{ $product->name }}
                    </h1>

                    <div class="mb-6">
                        <span class="text-3xl font-bold text-amber-400">
                            ${{ number_format($product->price, 2) }}
                        </span>
                    </div>

                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-stone-200 mb-2">
                            Description
                        </h2>

                        <p class="text-stone-400 leading-relaxed">
                            {{ $product->description ?? 'No description available for this product.' }}
                        </p>

                    </div>

                    <div>
                        <a href="{{ route('products.index') }}"
                            class="inline-flex items-center px-5 py-3 bg-amber-400 hover:bg-amber-300 text-stone-950 font-semibold rounded-xl transition">
                            ← Back to Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
