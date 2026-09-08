@extends('layouts.app')
@section('title', 'Order Confirmed')
@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-stone-900 border border-stone-800 rounded-2xl p-10 text-center">
            <div class="w-20 h-20 mx-auto rounded-full bg-emerald-400/10 flex items-center justify-center text-4xl">
                ✓
            </div>

            <h1 class="text-3xl font-bold text-white mt-6">
                Order Placed Successfully!
            </h1>

            <p class="text-sm text-stone-500 mt-3">
                Thank you for shopping with Fashion Hub.
            </p>

            <div class="mt-8 p-5 rounded-xl bg-stone-950 border border-stone-800">
                <p class="text-xs uppercase tracking-widest text-stone-600">
                    Order Number
                </p>

                <p class="text-xl font-bold text-amber-400 mt-2">
                    {{ $order->order_number }}
                </p>
            </div>

            <div class="mt-6 flex flex-col sm:flex-row justify-center gap-3">
                <a href="{{ route('orders.show', $order) }}" class="px-5 py-3 rounded-xl bg-amber-400 hover:bg-amber-300 text-stone-950 font-semibold">
                    View Order
                </a>

                <a href="{{ route('products.index') }}" class="px-5 py-3 rounded-xl bg-stone-800 hover:bg-stone-700 text-stone-300 hover:text-white font-semibold">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>

@endsection
