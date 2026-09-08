@extends('layouts.app')
@section('title', 'Order Details')
@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-widest text-stone-600">
                    Order Details
                </p>

                <h1 class="text-2xl font-bold text-white mt-1">
                    {{ $order->order_number }}
                </h1>

                <p class="text-sm text-stone-500 mt-1">
                    Placed on {{ $order->created_at->format('d M Y, h:i A') }}
                </p>
            </div>

            @php
                $statusClass = match ($order->status) {
                    'pending'    => 'bg-yellow-400/10 text-yellow-400',
                    'confirmed'  => 'bg-blue-400/10 text-blue-400',
                    'processing' => 'bg-purple-400/10 text-purple-400',
                    'shipped'    => 'bg-indigo-400/10 text-indigo-400',
                    'delivered'  => 'bg-emerald-400/10 text-emerald-400',
                    'cancelled'  => 'bg-red-400/10 text-red-400',
                    default      => 'bg-stone-800 text-stone-400',
                };
            @endphp

            <span class="inline-flex px-4 py-2 rounded-full text-sm font-semibold {{ $statusClass }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        <div class="bg-stone-900 border border-stone-800 rounded-2xl overflow-hidden">
            <div class="px-6 py-5 border-b border-stone-800">
                <h2 class="text-sm uppercase tracking-widest font-semibold text-stone-300">
                    Ordered Products
                </h2>
            </div>

            <div class="divide-y divide-stone-800">
                @foreach ($order->items as $item)
                    <div class="p-6 flex flex-col md:flex-row gap-5">
                        <div class="w-20 h-20 rounded-xl bg-stone-800 overflow-hidden shrink-0">
                            @if ($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                            @endif
                        </div>

                        <div class="flex-1">
                            <h3 class="text-white font-semibold">
                                {{ $item->product_name }}
                            </h3>

                            <p class="text-sm text-stone-500 mt-1">
                                {{ $item->quantity }}
                                ×
                                Rs. {{ number_format($item->price, 2) }}
                            </p>
                        </div>


                        <div class="md:text-right">
                            <p class="text-lg font-semibold text-amber-400">
                                Rs. {{ number_format($item->subtotal, 2) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
                <h2 class="text-sm uppercase tracking-widest font-semibold text-stone-300">
                    Shipping Information
                </h2>

                <div class="space-y-4 mt-6">
                    <div>
                        <p class="text-xs uppercase tracking-wider text-stone-600">
                            Name
                        </p>

                        <p class="text-sm text-white mt-1">
                            {{ $order->shipping_name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs uppercase tracking-wider text-stone-600">
                            Email
                        </p>

                        <p class="text-sm text-white mt-1">
                            {{ $order->shipping_email }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs uppercase tracking-wider text-stone-600">
                            Phone
                        </p>

                        <p class="text-sm text-white mt-1">
                            {{ $order->shipping_phone }}
                        </p>
                    </div>


                    <div>
                        <p class="text-xs uppercase tracking-wider text-stone-600">
                            Address
                        </p>

                        <p class="text-sm text-white mt-1">
                            {{ $order->shipping_address }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs uppercase tracking-wider text-stone-600">
                            City
                        </p>

                        <p class="text-sm text-white mt-1">
                            {{ $order->shipping_city }}
                            @if ($order->shipping_postal_code)
                                - {{ $order->shipping_postal_code }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
                <h2 class="text-sm uppercase tracking-widest font-semibold text-stone-300">
                    Order Summary
                </h2>

                <div class="space-y-4 mt-6">
                    <div class="flex justify-between">
                        <span class="text-sm text-stone-500">
                            Subtotal
                        </span>

                        <span class="text-sm text-white">
                            Rs. {{ number_format($order->subtotal, 2) }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-sm text-stone-500">
                            Shipping
                        </span>

                        <span class="text-sm text-white">
                            Rs. {{ number_format($order->shipping_amount, 2) }}
                        </span>
                    </div>

                    <div class="flex justify-between border-t border-stone-800 pt-4">
                        <span class="font-semibold text-white">
                            Total
                        </span>

                        <span class="text-xl font-bold text-amber-400">
                            Rs. {{ number_format($order->total, 2) }}
                        </span>
                    </div>

                    <div class="border-t border-stone-800 pt-4">
                        <p class="text-xs uppercase tracking-wider text-stone-600">
                            Payment
                        </p>

                        <p class="text-sm text-white mt-1">
                            {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                        </p>

                        <p class="text-xs text-yellow-400 mt-1">
                            {{ ucfirst($order->payment_status) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>


        @if ($order->notes)
            <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
                <p class="text-xs uppercase tracking-wider text-stone-600">
                    Order Notes
                </p>

                <p class="text-sm text-stone-300 mt-2">
                    {{ $order->notes }}
                </p>
            </div>
        @endif

        <div>
            <a href="{{ route('orders.index') }}" class="inline-flex px-5 py-3 rounded-xl bg-stone-800 hover:bg-stone-700 text-stone-300 hover:text-white text-sm font-semibold">
                ← Back to My Orders
            </a>
        </div>
    </div>

@endsection
