@extends('layouts.app')
@section('content')
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

        $paymentClass = match ($order->payment_status) {
            'paid'     => 'text-emerald-400',
            'failed'   => 'text-red-400',
            'refunded' => 'text-purple-400',
            default    => 'text-yellow-400',
        };

        $paymentMethod = match ($order->payment_method) {
            'cash_on_delivery' => 'Cash on Delivery',
            default            => $order->payment_method ? ucwords(str_replace('_', ' ', $order->payment_method)) : 'Not specified'};

    @endphp

    <div class="min-h-screen bg-stone-950 text-stone-100">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
                <div>
                    <a href="{{ route('admin.orders.index') }}"
                        class="inline-flex items-center text-sm text-stone-500 hover:text-amber-400 transition">
                        ← Back to Orders
                    </a>

                    <h1 class="text-3xl font-bold text-white mt-3">
                        Order #{{ $order->order_number }}
                    </h1>

                    <p class="text-sm text-stone-500 mt-1">
                        Placed on
                        {{ $order->created_at->format('d M Y, h:i A') }}
                    </p>
                </div>

                <div>
                    <span class="inline-flex px-4 py-2 rounded-full text-sm font-semibold {{ $statusClass }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>

            @if (session('success'))
                <div
                    class="mb-6 px-5 py-4 rounded-xl bg-emerald-400/10 border border-emerald-400/20 text-emerald-400">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 px-5 py-4 rounded-xl bg-red-400/10 border border-red-400/20 text-red-400">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 px-5 py-4 rounded-xl bg-red-400/10 border border-red-400/20 text-red-400">
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <div class="xl:col-span-2 space-y-6">
                    <div class="bg-stone-900 border border-stone-800 rounded-2xl overflow-hidden">
                        <div class="px-6 py-5 border-b border-stone-800">
                            <h2 class="text-lg font-semibold text-white">
                                Order Items
                            </h2>

                            <p class="text-xs text-stone-500 mt-1">
                                Products included in this order
                            </p>
                        </div>

                        <div class="divide-y divide-stone-800">
                            @forelse($order->items as $item)
                                <div class="px-6 py-5 flex items-center gap-5 hover:bg-stone-800/20 transition">
                                    <div class="w-20 h-20 rounded-xl bg-stone-800 overflow-hidden flex-shrink-0">
                                        @if ($item->product && $item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-stone-600 text-2xl">
                                                📦
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-white truncate">
                                            {{ $item->product_name }}
                                        </h3>

                                        <p class="text-sm text-stone-500 mt-1">
                                            Quantity: {{ $item->quantity }}
                                        </p>

                                        @if ($item->product)
                                            <p class="text-xs text-stone-600 mt-1">
                                                Product ID: {{ $item->product->id }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="text-right flex-shrink-0">
                                        <p class="text-sm text-stone-500">
                                            Rs.{{ number_format($item->price, 2) }}
                                            ×
                                            {{ $item->quantity }}
                                        </p>

                                        <p class="font-semibold text-amber-400 mt-1">
                                            Rs.{{ number_format($item->subtotal, 2) }}
                                        </p>
                                    </div>
                                </div>

                            @empty

                                <div class="px-6 py-10 text-center">
                                    <p class="text-sm text-stone-500">
                                        No items found for this order.
                                    </p>
                                </div>
                            @endforelse
                        </div>

                        <div class="px-6 py-6 border-t border-stone-800">
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-stone-500">
                                    Subtotal
                                </span>

                                <span class="text-sm text-stone-300">
                                    Rs.{{ number_format($order->subtotal, 2) }}
                                </span>
                            </div>

                            <div class="flex justify-between py-2">
                                <span class="text-sm text-stone-500">
                                    Shipping
                                </span>

                                <span class="text-sm text-stone-300">
                                    Rs.{{ number_format($order->shipping_amount, 2) }}
                                </span>
                            </div>

                            <div class="flex justify-between pt-4 mt-3 border-t border-stone-800">
                                <span class="font-semibold text-white">
                                    Total
                                </span>

                                <span class="text-xl font-bold text-amber-400">
                                    Rs.{{ number_format($order->total, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
                        <h2 class="text-lg font-semibold text-white mb-5">
                            Shipping Information
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs uppercase tracking-wider text-stone-600 mb-2">
                                    Name
                                </p>

                                <p class="text-sm text-stone-300">
                                    {{ $order->shipping_name }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-wider text-stone-600 mb-2">
                                    Email
                                </p>

                                <p class="text-sm text-stone-300 break-all">
                                    {{ $order->shipping_email }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-wider text-stone-600 mb-2">
                                    Phone
                                </p>

                                <p class="text-sm text-stone-300">
                                    {{ $order->shipping_phone }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-wider text-stone-600 mb-2">
                                    City
                                </p>

                                <p class="text-sm text-stone-300">
                                    {{ $order->shipping_city }}
                                </p>
                            </div>

                            <div class="md:col-span-2">
                                <p class="text-xs uppercase tracking-wider text-stone-600 mb-2">
                                    Address
                                </p>

                                <p class="text-sm text-stone-300">
                                    {{ $order->shipping_address }}
                                </p>
                            </div>

                            @if ($order->shipping_postal_code)
                                <div>
                                    <p class="text-xs uppercase tracking-wider text-stone-600 mb-2">
                                        Postal Code
                                    </p>

                                    <p class="text-sm text-stone-300">
                                        {{ $order->shipping_postal_code }}
                                    </p>
                                </div>
                            @endif

                            @if ($order->notes)
                                <div class="md:col-span-2">
                                    <p class="text-xs uppercase tracking-wider text-stone-600 mb-2">
                                        Customer Notes
                                    </p>

                                    <div class="p-4 rounded-xl bg-stone-950 border border-stone-800">
                                        <p class="text-sm text-stone-300 whitespace-pre-line">
                                            {{ $order->notes }}
                                        </p>

                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
                        <h2 class="text-lg font-semibold text-white mb-5">
                            Customer
                        </h2>

                        <div class="flex items-center gap-4 mb-5">
                            <div class="w-12 h-12 rounded-full bg-amber-400 text-stone-950 flex items-center justify-center font-bold flex-shrink-0">
                                {{ strtoupper(substr($order->shipping_name, 0, 1)) }}
                            </div>

                            <div class="min-w-0">
                                <p class="font-semibold text-white truncate">
                                    {{ $order->shipping_name }}
                                </p>

                                <p class="text-xs text-stone-500 truncate">
                                    {{ $order->shipping_email }}
                                </p>
                            </div>
                        </div>

                        @if ($order->customer)
                            <a href="{{ route('admin.customers.show', $order->customer) }}" class="block w-full text-center px-4 py-3 rounded-xl bg-stone-800 hover:bg-stone-700 text-stone-300 hover:text-white text-sm font-semibold transition">
                                View Customer
                            </a>
                        @endif
                    </div>

                    <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
                        <h2 class="text-lg font-semibold text-white mb-5">
                            Update Order
                        </h2>

                        <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <label
                                class="block text-xs uppercase tracking-wider text-stone-500 mb-2">
                                Order Status
                            </label>

                            <select name="status" class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white focus:border-amber-400 focus:ring-0 mb-4">
                                @foreach (['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                                    <option value="{{ $status }}" @selected($order->status === $status)>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit" class="w-full px-4 py-3 rounded-xl bg-amber-400 hover:bg-amber-300 text-stone-950 font-semibold text-sm transition">
                                Update Status
                            </button>
                        </form>
                    </div>

                    <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
                        <h2 class="text-lg font-semibold text-white mb-5">
                            Payment
                        </h2>

                        <div class="space-y-4">
                            <div class="flex justify-between gap-4">
                                <span class="text-sm text-stone-500">
                                    Method
                                </span>

                                <span class="text-sm text-stone-300 text-right">
                                    {{ $paymentMethod }}
                                </span>
                            </div>

                            <div class="flex justify-between gap-4">
                                <span class="text-sm text-stone-500">
                                    Status
                                </span>

                                <span
                                    class="text-sm font-semibold {{ $paymentClass }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
                        <h2 class="text-lg font-semibold text-white mb-5">
                            Order Information
                        </h2>

                        <div class="space-y-4">
                            <div class="flex justify-between gap-4">
                                <span class="text-sm text-stone-500">
                                    Order Number
                                </span>

                                <span class="text-sm font-medium text-stone-300 text-right break-all">
                                    {{ $order->order_number }}
                                </span>
                            </div>

                            <div class="flex justify-between gap-4">
                                <span class="text-sm text-stone-500">
                                    Items
                                </span>

                                <span class="text-sm text-stone-300">
                                    {{ $order->items->sum('quantity') }}
                                </span>
                            </div>

                            <div class="flex justify-between gap-4">
                                <span class="text-sm text-stone-500">
                                    Placed
                                </span>

                                <span
                                    class="text-sm text-stone-300 text-right">
                                    {{ $order->created_at->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-red-500/5 border border-red-500/10 rounded-2xl p-6">
                        <h2 class="font-semibold text-red-400">
                            Danger Zone
                        </h2>

                        <p
                            class="text-xs text-stone-500 mt-2 mb-5">
                            Permanently delete this order and all its items.
                        </p>

                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this order? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="w-full px-4 py-3 rounded-xl bg-red-500 hover:bg-red-400 text-white font-semibold text-sm transition">
                                Delete Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
