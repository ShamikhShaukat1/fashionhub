@extends('layouts.app')
@section('title', 'Customer Dashboard - Fashion Hub')
@section('page', 'Dashboard')
@section('heading', 'My Dashboard')

@section('content')

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <h2 class="text-2xl font-semibold text-white">
                Welcome back, {{ $user->name }}!
            </h2>

            <p class="text-xs text-stone-400 mt-2">
                Explore products, discover categories and keep track of your orders.
            </p>
        </div>

        <a href="{{ route('products.index') }}"
            class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-amber-400 text-stone-950 text-sm font-semibold hover:bg-amber-300 transition">
            Browse Products
            <span>→</span>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach ([
            [
                'label' => 'My Total Spending',
                'value' => 'Rs. ' . number_format($totalSpent, 2),
                'description' => 'Total value of your orders',
                'icon' => '↗',
                'color' => 'text-amber-400',
            ],
            [
                'label' => 'My Orders',
                'value' => number_format($totalOrders),
                'description' => 'Orders placed by you',
                'icon' => '▤',
                'color' => 'text-sky-400',
            ],
            [
                'label' => 'Available Products',
                'value' => number_format($totalProducts),
                'description' => 'Active products in our store',
                'icon' => '◇',
                'color' => 'text-emerald-400',
            ],
            [
                'label' => 'Categories',
                'value' => number_format($totalCategories),
                'description' => 'Categories with available products',
                'icon' => '▦',
                'color' => 'text-violet-400',
            ],
        ] as $stat)
            <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-5 relative overflow-hidden">

                <div class="flex items-start justify-between gap-3">
                    <p class="text-[11px] uppercase tracking-wider font-semibold text-stone-400">
                        {{ $stat['label'] }}
                    </p>

                    <span class="text-xl {{ $stat['color'] }}">
                        {{ $stat['icon'] }}
                    </span>
                </div>

                <p class="text-xl sm:text-2xl font-bold mt-3 text-white break-words">
                    {{ $stat['value'] }}
                </p>

                <p class="text-[11px] text-stone-500 mt-2">
                    {{ $stat['description'] }}
                </p>

            </div>
        @endforeach

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <div class="lg:col-span-2 bg-stone-900/60 border border-stone-800/80 rounded-2xl p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                <div>
                    <h3 class="text-base font-semibold text-white">
                        My Spending Trend
                    </h3>

                    <p class="text-xs text-stone-500 mt-1">
                        Your order totals over the last six calendar months
                    </p>
                </div>

                <span class="text-xs text-stone-400 bg-stone-950 border border-stone-800 rounded-lg px-3 py-2">
                    Last 6 Months
                </span>
            </div>

            @php
                $maxSpending = max(1, (float) $monthlySpending->max('total'));
            @endphp

            <div class="h-56 flex items-end justify-between gap-3 pt-4 border-b border-stone-800/80 pb-2">
                @foreach ($monthlySpending as $bar)
                    <div class="flex-1 h-full flex flex-col items-center justify-end gap-2 group min-w-0">
                        <span class="text-[10px] text-stone-400 text-center break-words">
                            {{ number_format($bar['total'], 0) }}
                        </span>

                        <div class="w-full max-w-12 bg-stone-800 rounded-t-md overflow-hidden flex items-end"
                            style="height: 160px;">

                            <div class="w-full bg-amber-400/80 group-hover:bg-amber-400 rounded-t-md transition-all duration-300"
                                style="height: {{ $bar['total'] > 0 ? max(4, ($bar['total'] / $maxSpending) * 160) : 0 }}px;"
                                title="Rs. {{ number_format($bar['total'], 2) }}">
                            </div>

                        </div>

                        <span class="text-xs text-stone-500">
                            {{ $bar['month'] }}
                        </span>

                    </div>
                @endforeach

            </div>

            <div class="flex flex-wrap justify-between items-center gap-3 text-xs text-stone-400 pt-4">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-400 inline-block"></span>
                    <span>Monthly order total</span>
                </div>

                <span class="text-stone-500">
                    Amounts in PKR
                </span>

            </div>
        </div>

        <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-6">
            <h3 class="text-base font-semibold text-white mb-1">
                Product Categories
            </h3>

            <p class="text-xs text-stone-500 mb-6">
                Discover products by category
            </p>

            <div class="space-y-5">
                @forelse($categories as $cat)
                    @php
                        $share =
                            $totalProducts > 0 ? min(100, round(($cat->products_count / $totalProducts) * 100)) : 0;
                    @endphp

                    <div>
                        <div class="flex justify-between items-start gap-3 text-xs mb-2">
                            <span class="text-stone-300 font-medium">
                                {{ $cat->name }}
                            </span>

                            <span class="text-stone-400 whitespace-nowrap">
                                {{ $cat->products_count }} products
                            </span>
                        </div>

                        <div class="w-full bg-stone-950 rounded-full h-2 overflow-hidden">
                            <div class="bg-amber-400 h-full rounded-full transition-all duration-300"
                                style="width: {{ $share }}%;">
                            </div>
                        </div>
                    </div>

                @empty

                    <div class="py-8 text-center">
                        <p class="text-sm text-stone-400">
                            No categories available yet.
                        </p>
                    </div>
                @endforelse

            </div>

            <div class="mt-6 pt-4 border-t border-stone-800/60 text-center">
                <a href="{{ route('products.index') }}" class="text-xs text-amber-400 hover:text-amber-300 transition">
                    Explore All Products →
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-stone-900/60 border border-stone-800/80 rounded-2xl overflow-hidden">
            <div
                class="p-6 border-b border-stone-800/60 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">

                <div>
                    <h3 class="text-base font-semibold text-white">
                        Available Products
                    </h3>

                    <p class="text-xs text-stone-500 mt-1">
                        Discover products added to Fashion Hub
                    </p>
                </div>

                <a href="{{ route('products.index') }}" class="text-xs text-amber-400 hover:text-amber-300 transition">
                    View All Products →
                </a>

            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-stone-950/40">
                        <tr class="border-b border-stone-800 text-[11px] uppercase tracking-wider text-stone-400">
                            <th class="p-4">Product</th>
                            <th class="p-4">Category</th>
                            <th class="p-4">Price</th>
                            <th class="p-4">Availability</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stone-800/50">
                        @forelse($products as $product)
                            <tr class="hover:bg-stone-800/30 transition">
                                <td class="p-4">
                                    <a href="{{ route('products.show', $product) }}"
                                        class="text-sm font-medium text-stone-200 hover:text-amber-400 transition">
                                        {{ $product->name }}
                                    </a>
                                </td>

                                <td class="p-4 text-xs text-stone-400">
                                    {{ $product->category?->name ?? 'Uncategorized' }}
                                </td>

                                <td class="p-4 text-amber-400 font-medium text-xs whitespace-nowrap">
                                    Rs. {{ number_format($product->price, 2) }}
                                </td>

                                <td class="p-4">
                                    @if ($product->stock > 10)
                                        <span
                                            class="inline-block text-[10px] px-2.5 py-1 rounded-full border text-emerald-400 bg-emerald-500/10 border-emerald-500/20">
                                            In Stock
                                        </span>
                                    @elseif($product->stock > 0)
                                        <span
                                            class="inline-block text-[10px] px-2.5 py-1 rounded-full border text-amber-400 bg-amber-500/10 border-amber-500/20">
                                            Limited Stock
                                        </span>
                                    @else
                                        <span
                                            class="inline-block text-[10px] px-2.5 py-1 rounded-full border text-rose-400 bg-rose-500/10 border-rose-500/20">
                                            Out of Stock
                                        </span>
                                    @endif
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="p-8 text-center">

                                    <p class="text-sm text-stone-400">
                                        No products are available right now.
                                    </p>

                                    <p class="text-xs text-stone-500 mt-2">
                                        Please check again later.
                                    </p>

                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-stone-800/60">
                <a href="{{ route('products.index') }}" class="text-xs text-amber-400 hover:text-amber-300 transition">
                    Browse the complete catalog →
                </a>
            </div>

        </div>

        <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-6">
            <div class="flex items-center justify-between gap-3 mb-2">
                <h3 class="text-base font-semibold text-white">
                    My Recent Orders
                </h3>
                <span class="w-2 h-2 rounded-full bg-amber-400 inline-block"></span>
            </div>

            <p class="text-xs text-stone-500 mb-6">
                Your latest purchases
            </p>

            <div class="space-y-4">
                @forelse($recentOrders as $order)
                    <div class="p-4 bg-stone-950/40 border border-stone-800/60 rounded-xl">
                        <div class="flex justify-between items-start gap-3">
                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-stone-200 break-words">
                                    #{{ $order->order_number }}
                                </p>

                                <p class="text-[11px] text-stone-400 mt-2">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </p>

                            </div>

                            <span class="text-xs font-semibold text-amber-400 whitespace-nowrap">
                                Rs. {{ number_format($order->total, 2) }}
                            </span>
                        </div>

                        <div class="mt-3 pt-3 border-t border-stone-800/60">
                            <span class="text-[10px] text-stone-500">
                                {{ $order->created_at->format('d M Y, h:i A') }}
                            </span>
                        </div>
                    </div>

                @empty

                    <div class="text-center py-8">
                        <div class="text-3xl text-stone-600 mb-3">
                            ▤
                        </div>

                        <p class="text-sm text-stone-400">
                            You haven't placed any orders yet.
                        </p>

                        <p class="text-xs text-stone-500 mt-2">
                            Find something you love and place your first order.
                        </p>

                        <a href="{{ route('products.index') }}"
                            class="inline-block mt-4 text-xs text-amber-400 hover:text-amber-300 transition">
                            Explore Products →
                        </a>
                    </div>
                @endforelse

            </div>

            <div class="mt-6 pt-4 border-t border-stone-800/60">
                <p class="text-[11px] text-stone-500">
                    These orders belong to your account.
                </p>
            </div>
        </div>
    </div>

@endsection
