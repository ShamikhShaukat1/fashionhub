@extends('layouts.app')
@section('title', 'Orders')
@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white">
                    Orders
                </h1>

                <p class="text-sm text-stone-500 mt-1">
                    Manage customer orders and order status.
                </p>
            </div>
        </div>

        @if (session('success'))
            <div class="px-5 py-4 rounded-xl bg-emerald-400/10 border border-emerald-400/20 text-emerald-400 text-sm">
                {{ session('success') }}
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

        <div class="bg-stone-900 border border-stone-800 rounded-2xl p-5">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs uppercase tracking-wider text-stone-500 mb-2">
                        Search Orders
                    </label>

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Order number, customer name or email..." class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white placeholder-stone-600 focus:outline-none focus:border-amber-400 transition">
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-wider text-stone-500 mb-2">
                        Status
                    </label>

                    <select name="status" class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white focus:outline-none focus:border-amber-400 transition">
                        <option value="">
                            All Statuses
                        </option>

                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>
                            Confirmed
                        </option>

                        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>
                            Processing
                        </option>

                        <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>
                            Shipped
                        </option>

                        <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>
                            Delivered
                        </option>

                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>
                            Cancelled
                        </option>

                    </select>
                </div>

                <div class="md:col-span-3 flex gap-3">
                    <button type="submit" class="px-5 py-3 rounded-xl bg-amber-400 hover:bg-amber-300 text-stone-950 text-sm font-semibold transition">
                        Filter Orders
                    </button>

                    <a href="{{ route('admin.orders.index') }}" class="px-5 py-3 rounded-xl bg-stone-800 hover:bg-stone-700 text-stone-300 hover:text-white text-sm font-semibold transition">
                        Clear
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-stone-900 border border-stone-800 rounded-2xl overflow-hidden">
            <div class="px-6 py-5 border-b border-stone-800 flex items-center justify-between">
                <div>
                    <h2 class="text-sm uppercase tracking-widest font-semibold text-stone-300">
                        All Orders
                    </h2>

                    <p class="text-xs text-stone-600 mt-1">
                        {{ $orders->total() }} total orders
                    </p>
                </div>
            </div>


            @if ($orders->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-stone-950">
                            <tr>
                                <th class="px-6 py-4 text-[10px] uppercase tracking-widest text-stone-500 font-semibold">
                                    Order
                                </th>

                                <th class="px-6 py-4 text-[10px] uppercase tracking-widest text-stone-500 font-semibold">
                                    Customer
                                </th>

                                <th class="px-6 py-4 text-[10px] uppercase tracking-widest text-stone-500 font-semibold">
                                    Items
                                </th>

                                <th class="px-6 py-4 text-[10px] uppercase tracking-widest text-stone-500 font-semibold">
                                    Total
                                </th>

                                <th class="px-6 py-4 text-[10px] uppercase tracking-widest text-stone-500 font-semibold">
                                    Payment
                                </th>

                                <th class="px-6 py-4 text-[10px] uppercase tracking-widest text-stone-500 font-semibold">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-[10px] uppercase tracking-widest text-stone-500 font-semibold text-right">
                                    Action
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-stone-800">
                            @forelse($orders as $order)
                                @php
                                    $statusClass = match ($order->status) {
                                        'pending' => 'bg-yellow-400/10 text-yellow-400',
                                        'confirmed' => 'bg-blue-400/10 text-blue-400',
                                        'processing' => 'bg-purple-400/10 text-purple-400',
                                        'shipped' => 'bg-indigo-400/10 text-indigo-400',
                                        'delivered' => 'bg-emerald-400/10 text-emerald-400',
                                        'cancelled' => 'bg-red-400/10 text-red-400',
                                        default => 'bg-stone-800 text-stone-400',
                                    };

                                    $paymentClass = match ($order->payment_status) {
                                        'paid' => 'bg-emerald-400/10 text-emerald-400',
                                        'failed' => 'bg-red-400/10 text-red-400',
                                        'refunded' => 'bg-purple-400/10 text-purple-400',
                                        default => 'bg-yellow-400/10 text-yellow-400',
                                    };

                                @endphp

                                <tr class="hover:bg-stone-800/40 transition">
                                    <td class="px-6 py-5">
                                        <div>
                                            <p class="text-sm font-semibold text-white">
                                                {{ $order->order_number }}
                                            </p>

                                            <p class="text-xs text-stone-600 mt-1">
                                                {{ $order->created_at->format('d M Y, h:i A') }}
                                            </p>
                                        </div>
                                    </td>

                                    <td class="px-6 py-5">
                                        @if ($order->customer)
                                            <div>
                                                <p class="text-sm font-medium text-stone-200">
                                                    {{ $order->customer->name }}
                                                </p>

                                                <p class="text-xs text-stone-600 mt-1">
                                                    {{ $order->customer->email }}
                                                </p>
                                            </div>
                                        @else
                                            <span class="text-sm text-stone-600">
                                                Customer Deleted
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-5">
                                        <span class="text-sm font-medium text-stone-300">
                                            {{ $order->items->count() }}
                                        </span>

                                        <span class="text-xs text-stone-600">
                                            {{ $order->items->count() === 1 ? 'item' : 'items' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-5">
                                        <p class="text-sm font-semibold text-amber-400">
                                            Rs. {{ number_format($order->total, 2) }}
                                        </p>
                                    </td>

                                    <td class="px-6 py-5">
                                        <div class="space-y-2">
                                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $paymentClass }}">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>

                                            @if ($order->payment_method)
                                                <p class="text-[11px] text-stone-600 uppercase">
                                                    {{ str_replace('_', ' ', $order->payment_method) }}
                                                </p>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-5">
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-5 text-right">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-stone-800 hover:bg-amber-400 text-stone-300 hover:text-stone-950 text-xs font-semibold transition">
                                            View Order
                                        </a>
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 rounded-2xl bg-stone-800 flex items-center justify-center text-2xl mb-4">
                                                🛒
                                            </div>

                                            <h3 class="text-lg font-semibold text-white">
                                                No Orders Found
                                            </h3>

                                            <p class="text-sm text-stone-600 mt-2 max-w-md">
                                                There are no orders matching your current search or filter.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($orders->hasPages())
                    <div class="px-6 py-5 border-t border-stone-800">
                        {{ $orders->links() }}
                    </div>
                @endif
            @else
                <div class="px-6 py-16 text-center">
                    <div
                        class="flex flex-col items-center justify-center">
                        <div class="w-16 h-16 rounded-2xl bg-stone-800 flex items-center justify-center text-2xl mb-4">
                            🛒
                        </div>

                        <h3 class="text-lg font-semibold text-white">
                            No Orders Found
                        </h3>

                        <p class="text-sm text-stone-600 mt-2">
                            No orders are available yet.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
