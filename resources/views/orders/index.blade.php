@extends('layouts.app')
@section('title', 'My Orders')
@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-white">
                My Orders
            </h1>

            <p class="text-sm text-stone-500 mt-1">
                View and track your orders.
            </p>
        </div>


        @if (session('success'))
            <div class="px-5 py-4 rounded-xl bg-emerald-400/10 border border-emerald-400/20 text-emerald-400 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($orders->count())
            <div class="bg-stone-900 border border-stone-800 rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-stone-950">
                            <tr>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-stone-500">
                                    Order
                                </th>

                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-stone-500">
                                    Date
                                </th>

                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-stone-500">
                                    Total
                                </th>

                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-stone-500">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-stone-500 text-right">
                                    Action
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-stone-800">
                            @foreach ($orders as $order)
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

                                <tr class="hover:bg-stone-800/40">
                                    <td class="px-6 py-5">
                                        <p class="text-sm font-semibold text-white">
                                            {{ $order->order_number }}
                                        </p>
                                    </td>

                                    <td class="px-6 py-5">
                                        <p class="text-sm text-stone-400">
                                            {{ $order->created_at->format('d M Y') }}
                                        </p>
                                    </td>

                                    <td class="px-6 py-5">
                                        <p class="text-sm font-semibold text-amber-400">
                                            Rs. {{ number_format($order->total, 2) }}
                                        </p>
                                    </td>

                                    <td class="px-6 py-5">
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>


                                    <td class="px-6 py-5 text-right">
                                        <a href="{{ route('orders.show', $order) }}" class="inline-flex px-4 py-2 rounded-lg bg-stone-800 hover:bg-amber-400 text-stone-300 hover:text-stone-950 text-xs font-semibold transition">
                                            View Order
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-5 border-t border-stone-800">
                    {{ $orders->links() }}
                </div>
            </div>
        @else
            <div class="bg-stone-900 border border-stone-800 rounded-2xl p-16 text-center">
                <div class="text-5xl mb-5">
                    📦
                </div>

                <h2 class="text-xl font-semibold text-white">
                    No Orders Yet
                </h2>

                <p class="text-sm text-stone-500 mt-2">
                    You haven't placed any orders yet.
                </p>

                <a href="{{ route('products.index') }}"
                    class="inline-block mt-6 px-5 py-3 rounded-xl bg-amber-400 hover:bg-amber-300 text-stone-950 font-semibold">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>

@endsection
