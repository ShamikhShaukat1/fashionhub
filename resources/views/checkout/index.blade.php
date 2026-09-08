@extends('layouts.app')
@section('title', 'Checkout')
@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-white">
                Checkout
            </h1>

            <p class="text-sm text-stone-500 mt-1">
                Enter your shipping information and place your order.
            </p>
        </div>

        @if (session('error'))
            <div class="px-5 py-4 rounded-xl bg-red-400/10 border border-red-400/20 text-red-400 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="px-5 py-4 rounded-xl bg-red-400/10 border border-red-400/20 text-red-400 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.place') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-stone-900 border border-stone-800 rounded-2xl p-6">
                    <h2 class="text-sm uppercase tracking-widest font-semibold text-stone-300 mb-6">
                        Shipping Information
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs uppercase tracking-wider text-stone-500 mb-2">
                                Full Name
                            </label>
                            <input type="text" name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}" required class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white focus:outline-none focus:border-amber-400">
                        </div>

                        <div>
                            <label class="block text-xs uppercase tracking-wider text-stone-500 mb-2">
                                Email
                            </label>
                            <input type="email" name="shipping_email" value="{{ old('shipping_email', auth()->user()->email) }}" required class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white focus:outline-none focus:border-amber-400">
                        </div>

                        <div>
                            <label class="block text-xs uppercase tracking-wider text-stone-500 mb-2">
                                Phone
                            </label>
                            <input type="text" name="shipping_phone" value="{{ old('shipping_phone') }}" placeholder="03001234567" required class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white placeholder-stone-700 focus:outline-none focus:border-amber-400">
                        </div>

                        <div>
                            <label class="block text-xs uppercase tracking-wider text-stone-500 mb-2">
                                City
                            </label>
                            <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" placeholder="Multan" required class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white placeholder-stone-700 focus:outline-none focus:border-amber-400">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs uppercase tracking-wider text-stone-500 mb-2">
                                Shipping Address
                            </label>

                            <textarea name="shipping_address" rows="3" required placeholder="House / Street / Area" class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white placeholder-stone-700 focus:outline-none focus:border-amber-400">{{ old('shipping_address') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs uppercase tracking-wider text-stone-500 mb-2">
                                Postal Code
                            </label>

                            <input type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code') }}" placeholder="60000" class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white placeholder-stone-700 focus:outline-none focus:border-amber-400">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs uppercase tracking-wider text-stone-500 mb-2">
                                Payment Method
                            </label>

                            <div class="p-4 rounded-xl bg-stone-950 border border-amber-400/30">
                                <label class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" value="cash_on_delivery" checked>
                                    <span class="text-sm text-white">
                                        Cash on Delivery
                                    </span>
                                </label>

                                <p class="text-xs text-stone-600 mt-2 ml-6">
                                    Pay when your order is delivered.
                                </p>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs uppercase tracking-wider text-stone-500 mb-2">
                                Order Notes
                                <span class="normal-case text-stone-700">
                                    (Optional)
                                </span>
                            </label>

                            <textarea name="notes" rows="3" placeholder="Any special instructions..." class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white placeholder-stone-700 focus:outline-none focus:border-amber-400">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6 h-fit">
                    <h2 class="text-sm uppercase tracking-widest font-semibold text-stone-300">
                        Your Order
                    </h2>

                    <div class="space-y-4 mt-6">
                        @foreach ($cartItems as $item)
                            <div class="flex justify-between gap-4">
                                <div>
                                    <p class="text-sm text-white">
                                        {{ $item['product']->name }}
                                    </p>

                                    <p class="text-xs text-stone-600">
                                        {{ $item['quantity'] }} ×
                                        Rs. {{ number_format($item['price'], 2) }}
                                    </p>
                                </div>

                                <p class="text-sm text-stone-300">
                                    Rs. {{ number_format($item['subtotal'], 2) }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-stone-800 mt-6 pt-5 space-y-3">
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

                        <div class="flex justify-between border-t border-stone-800 pt-4">
                            <span class="font-semibold text-white">
                                Total
                            </span>

                            <span class="text-lg font-bold text-amber-400">
                                Rs. {{ number_format($total, 2) }}
                            </span>
                        </div>
                    </div>


                    <button type="submit" class="w-full mt-6 px-5 py-3 rounded-xl bg-amber-400 hover:bg-amber-300 text-stone-950 font-semibold transition">
                        Place Order
                    </button>

                    <a href="{{ route('cart.index') }}" class="block text-center mt-3 text-xs text-stone-500 hover:text-white">
                        ← Back to Cart
                    </a>
                </div>
            </div>
        </form>
    </div>

@endsection
