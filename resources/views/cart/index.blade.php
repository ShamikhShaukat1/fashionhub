@extends('layouts.app')
@section('title', 'Shopping Cart')
@section('content')

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-white">
                Shopping Cart
            </h1>

            <p class="text-sm text-stone-500 mt-1">
                Review your products before checkout.
            </p>
        </div>

        @if (session('success'))
            <div class="px-5 py-4 rounded-xl bg-emerald-400/10 border border-emerald-400/20 text-emerald-400 text-sm">
                {{ session('success') }}
            </div>
        @endif


        @if (session('error'))
            <div class="px-5 py-4 rounded-xl bg-red-400/10 border border-red-400/20 text-red-400 text-sm">
                {{ session('error') }}
            </div>
        @endif


        @if (count($cartItems))
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-stone-900 border border-stone-800 rounded-2xl overflow-hidden">
                    <div class="px-6 py-5 border-b border-stone-800">
                        <h2 class="text-sm uppercase tracking-widest font-semibold text-stone-300">
                            Cart Items
                        </h2>
                    </div>

                    <div class="divide-y divide-stone-800">
                        @foreach ($cartItems as $item)
                            @php
                                $product = $item['product'];
                            @endphp

                            <div class="p-6 flex flex-col md:flex-row gap-5">
                                <div class="w-full md:w-28 h-28 rounded-xl bg-stone-800 overflow-hidden shrink-0">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @endif
                                </div>

                                <div class="flex-1">
                                    <h3 class="text-white font-semibold">
                                        {{ $product->name }}
                                    </h3>

                                    <p class="text-sm text-amber-400 mt-1">
                                        Rs. {{ number_format($item['price'], 2) }}
                                    </p>

                                    <div class="flex flex-wrap items-center gap-3 mt-4">
                                        <form action="{{ route('cart.update', $product) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')

                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $product->stock }}" class="w-20 px-3 py-2 rounded-lg bg-stone-950 border border-stone-800 text-white text-sm">
                                            <button type="submit"
                                                class="px-3 py-2 rounded-lg bg-stone-800 hover:bg-stone-700 text-stone-300 text-xs font-semibold">
                                                Update
                                            </button>
                                        </form>

                                        <form action="{{ route('cart.remove', $product) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="px-3 py-2 rounded-lg bg-red-400/10 hover:bg-red-400/20 text-red-400 text-xs font-semibold">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="md:text-right">
                                    <p class="text-xs uppercase tracking-wider text-stone-600">
                                        Subtotal
                                    </p>

                                    <p class="text-lg font-semibold text-white mt-1">
                                        Rs. {{ number_format($item['subtotal'], 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>


                    <div class="p-6 border-t border-stone-800">
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit" onclick="return confirm('Are you sure you want to clear your cart?')" class="text-xs uppercase tracking-wider text-red-400 hover:text-red-300">
                                Clear Cart
                            </button>
                        </form>
                    </div>
                </div>

                <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6 h-fit">
                    <h2 class="text-sm uppercase tracking-widest font-semibold text-stone-300">
                        Order Summary
                    </h2>

                    <div class="space-y-4 mt-6">
                        <div class="flex justify-between">
                            <span class="text-sm text-stone-500">
                                Subtotal
                            </span>

                            <span class="text-sm text-white">
                                Rs. {{ number_format($subtotal, 2) }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-sm text-stone-500">
                                Shipping
                            </span>

                            <span class="text-sm text-white">
                                Rs. {{ number_format($shipping, 2) }}
                            </span>
                        </div>

                        <div class="border-t border-stone-800 pt-4 flex justify-between">
                            <span class="font-semibold text-white">
                                Total
                            </span>
                            <span class="text-lg font-bold text-amber-400">
                                Rs. {{ number_format($total, 2) }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('checkout') }}" class="block w-full text-center mt-6 px-5 py-3 rounded-xl bg-amber-400 hover:bg-amber-300 text-stone-950 font-semibold transition">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        @else
            <div class="bg-stone-900 border border-stone-800 rounded-2xl p-16 text-center">
                <div class="text-5xl mb-5">
                    🛒
                </div>
                <h2 class="text-xl font-semibold text-white">
                    Your Cart is Empty
                </h2>

                <p class="text-sm text-stone-500 mt-2">
                    Add some products to your cart before checkout.
                </p>

                <a href="{{ route('products.index') }}" class="inline-block mt-6 px-5 py-3 rounded-xl bg-amber-400 hover:bg-amber-300 text-stone-950 font-semibold">
                    Continue Shopping
                </a>
            </div>
        @endif
    </div>

@endsection
