@extends('layouts.app')
@section('title', 'Reports - Fashion Hub')
@section('page', 'Reports')
@section('heading', 'Reports & Analytics')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-white">Reports & Analytics</h2>
                <p class="text-sm text-stone-500 mt-1">Monitor sales, orders, customers and business performance.</p>
            </div>
            <div class="text-xs text-stone-500">Fashion Hub Administration</div>
        </div>

        <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-5 mb-8">
            <form method="GET" action="{{ route('admin.reports.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text- uppercase tracking-wider font-semibold text-stone-400 mb-2">Date
                            From</label>
                        <input type="date" name="date_from" value="{{ $dateFrom }}"
                            class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-3 text-sm text-stone-200 focus:outline-none focus:border-amber-400">
                    </div>
                    <div>
                        <label class="block text- uppercase tracking-wider font-semibold text-stone-400 mb-2">Date
                            To</label>
                        <input type="date" name="date_to" value="{{ $dateTo }}"
                            class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-3 text-sm text-stone-200 focus:outline-none focus:border-amber-400">
                    </div>
                    <div class="flex items-end gap-3">
                        <button type="submit"
                            class="flex-1 bg-amber-400 hover:bg-amber-300 text-stone-950 font-semibold text-xs uppercase tracking-wider rounded-xl px-4 py-3 transition">Generate
                            Report</button>
                        <a href="{{ route('admin.reports.index') }}"
                            class="px-4 py-3 border border-stone-800 rounded-xl text-xs font-semibold text-stone-400 hover:bg-stone-800 hover:text-white transition">Clear</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="mb-10">
            <h3 class="text-xl font-semibold text-white">Overview</h3>
            <p class="text-sm text-stone-500 mt-1 mb-5">Overall performance for the selected period.</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-5">
                    <div class="flex items-center justify-between"><span
                            class="text-xs uppercase tracking-wider text-stone-500">Total Orders</span>
                        <div class="w-9 h-9 rounded-lg bg-amber-400/10 text-amber-400 flex items-center justify-center">#
                        </div>
                    </div>
                    <div class="mt-4 text-3xl font-bold text-white">{{ number_format($totalOrders) }}</div>
                    <p class="text-xs text-stone-500 mt-2">Orders in selected period</p>
                </div>
                <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-5">
                    <div class="flex items-center justify-between"><span
                            class="text-xs uppercase tracking-wider text-stone-500">Total Sales</span>
                        <div class="w-9 h-9 rounded-lg bg-emerald-400/10 text-emerald-400 flex items-center justify-center">
                            $</div>
                    </div>
                    <div class="mt-4 text-3xl font-bold text-emerald-400">{{ number_format($totalRevenue, 2) }}</div>
                    <p class="text-xs text-stone-500 mt-2">From completed orders</p>
                </div>
                <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-5">
                    <div class="flex items-center justify-between"><span
                            class="text-xs uppercase tracking-wider text-stone-500">Customers</span>
                        <div class="w-9 h-9 rounded-lg bg-blue-400/10 text-blue-400 flex items-center justify-center">U
                        </div>
                    </div>
                    <div class="mt-4 text-3xl font-bold text-white">{{ number_format($totalCustomers) }}</div>
                    <p class="text-xs text-stone-500 mt-2">Registered customers</p>
                </div>
                <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-5">
                    <div class="flex items-center justify-between"><span
                            class="text-xs uppercase tracking-wider text-stone-500">Products</span>
                        <div class="w-9 h-9 rounded-lg bg-rose-400/10 text-rose-400 flex items-center justify-center">P
                        </div>
                    </div>
                    <div class="mt-4 text-3xl font-bold text-white">{{ number_format($totalProducts) }}</div>
                    <p class="text-xs text-stone-500 mt-2">Products in catalog</p>
                </div>
            </div>
        </div>

        <div class="mb-10">
            <h3 class="text-xl font-semibold text-white">Order Analytics</h3>
            <p class="text-sm text-stone-500 mt-1 mb-5">Monitor order status and daily order trends.</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
                <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-5">
                    <div class="flex items-center justify-between"><span class="text-sm font-semibold text-white">Pending
                            Orders</span><span
                            class="px-2.5 py-1 rounded-lg bg-amber-400/10 border border-amber-400/20 text-amber-400 text-xs">Pending</span>
                    </div>
                    <div class="text-3xl font-bold text-amber-400 mt-4">{{ number_format($pendingOrders) }}</div>
                    <p class="text-xs text-stone-500 mt-2">{{ $pendingPercentage }}% of total orders</p>
                </div>
                <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-5">
                    <div class="flex items-center justify-between"><span class="text-sm font-semibold text-white">Completed
                            Orders</span><span
                            class="px-2.5 py-1 rounded-lg bg-emerald-400/10 border border-emerald-400/20 text-emerald-400 text-xs">Completed</span>
                    </div>
                    <div class="text-3xl font-bold text-emerald-400 mt-4">{{ number_format($completedOrders) }}</div>
                    <p class="text-xs text-stone-500 mt-2">{{ $completedPercentage }}% of total orders</p>
                </div>
                <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-5">
                    <div class="flex items-center justify-between"><span class="text-sm font-semibold text-white">Cancelled
                            Orders</span><span
                            class="px-2.5 py-1 rounded-lg bg-rose-400/10 border border-rose-400/20 text-rose-400 text-xs">Cancelled</span>
                    </div>
                    <div class="text-3xl font-bold text-rose-400 mt-4">{{ number_format($cancelledOrders) }}</div>
                    <p class="text-xs text-stone-500 mt-2">{{ $cancelledPercentage }}% of total orders</p>
                </div>
            </div>

            <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl overflow-hidden">
                <div class="px-6 py-5 border-b border-stone-800/80">
                    <h4 class="text-base font-semibold text-white">Order Trends</h4>
                    <p class="text-xs text-stone-500 mt-1">Daily order status trends.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-stone-800/80 text- uppercase tracking-wider text-stone-500">
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4">Total</th>
                                <th class="px-6 py-4">Pending</th>
                                <th class="px-6 py-4">Completed</th>
                                <th class="px-6 py-4">Cancelled</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-800/60">
                            @forelse($orderTrends as $trend)
                                <tr class="hover:bg-stone-800/30 transition">
                                    <td class="px-6 py-4 text-sm text-white">{{ $trend->formatted_date }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-white">{{ $trend->total_orders }}</td>
                                    <td class="px-6 py-4 text-sm text-amber-400">{{ $trend->pending }}</td>
                                    <td class="px-6 py-4 text-sm text-emerald-400">{{ $trend->completed }}</td>
                                    <td class="px-6 py-4 text-sm text-rose-400">{{ $trend->cancelled }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-sm text-stone-500">No order trend
                                        data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mb-10">
            <h3 class="text-xl font-semibold text-white">Sales Analytics</h3>
            <p class="text-sm text-stone-500 mt-1 mb-5">Analyze completed sales.</p>
            @foreach (['dailySales' => 'Daily Sales', 'monthlySales' => 'Monthly Sales', 'yearlySales' => 'Yearly Sales'] as $key => $title)
                <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl overflow-hidden mb-6">
                    <div class="px-6 py-5 border-b border-stone-800/80">
                        <h4 class="text-base font-semibold text-white">{{ $title }}</h4>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-stone-800/80 text- uppercase tracking-wider text-stone-500">
                                    <th class="px-6 py-4">Period</th>
                                    <th class="px-6 py-4">Orders</th>
                                    <th class="px-6 py-4">Sales</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-800/60">
                                @forelse($$key as $sale)
                                    <tr class="hover:bg-stone-800/30 transition">
                                        <td class="px-6 py-4 text-sm text-white">{{ $sale->formatted_date }}</td>
                                        <td class="px-6 py-4 text-sm text-stone-300">{{ $sale->orders }}</td>
                                        <td class="px-6 py-4 text-sm font-semibold text-emerald-400">
                                            {{ $sale->total_formatted }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-10 text-center text-sm text-stone-500">No data.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mb-10">
            <h3 class="text-xl font-semibold text-white">Product Analytics</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 my-5">
                <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-5"><span
                        class="text-xs uppercase text-stone-500">Total Products</span>
                    <div class="mt-4 text-3xl font-bold text-white">{{ number_format($totalProducts) }}</div>
                </div>
                <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-5"><span
                        class="text-xs uppercase text-stone-500">Categories</span>
                    <div class="mt-4 text-3xl font-bold text-white">{{ number_format($totalCategories) }}</div>
                </div>
                <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-5"><span
                        class="text-xs uppercase text-stone-500">Low Stock</span>
                    <div class="mt-4 text-3xl font-bold text-rose-400">{{ number_format($lowStockCount) }}</div>
                </div>
            </div>

            <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl overflow-hidden mb-6">
                <div class="px-6 py-5 border-b border-stone-800/80">
                    <h4 class="text-base font-semibold text-white">Best Selling Products</h4>
                    <p class="text-xs text-stone-500 mt-1">Top 10 by quantity sold (completed orders)</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-stone-800/80 text- uppercase tracking-wider text-stone-500">
                                <th class="px-6 py-4">#</th>
                                <th class="px-6 py-4">Product</th>
                                <th class="px-6 py-4">Price</th>
                                <th class="px-6 py-4">Stock</th>
                                <th class="px-6 py-4">Sold</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-800/60">
                            @forelse($productPerformance as $i => $product)
                                <tr class="hover:bg-stone-800/30 transition">
                                    <td class="px-6 py-4 text-sm text-stone-500">{{ $i + 1 }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-white">{{ $product->name }}</td>
                                    <td class="px-6 py-4 text-sm text-emerald-400">Rs. {{ $product->price_formatted }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-stone-300">{{ $product->stock }}</td>
                                    <td class="px-6 py-4 text-sm text-amber-400">{{ $product->total_sold }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-sm text-stone-500">No data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl overflow-hidden">
                <div class="px-6 py-5 border-b border-stone-800/80">
                    <h4 class="text-base font-semibold text-white">Low Stock Products</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-stone-800/80 text- uppercase tracking-wider text-stone-500">
                                <th class="px-6 py-4">Product</th>
                                <th class="px-6 py-4">Stock</th>
                                <th class="px-6 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-800/60">
                            @forelse($lowStockProducts as $p)
                                <tr class="hover:bg-stone-800/30 transition">
                                    <td class="px-6 py-4 text-sm text-white">{{ $p->name }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-rose-400">{{ $p->stock }}</td>
                                    <td class="px-6 py-4"><span
                                            class="px-2.5 py-1 rounded-lg bg-rose-400/10 border border-rose-400/20 text-rose-400 text-xs">Low
                                            Stock</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-10 text-center text-sm text-stone-500">No low stock.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mb-10">
            <h3 class="text-xl font-semibold text-white">Customer Analytics</h3>
            <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl overflow-hidden mb-6 mt-5">
                <div class="px-6 py-5 border-b border-stone-800/80">
                    <h4 class="text-base font-semibold text-white">Top Customers</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-stone-800/80 text- uppercase tracking-wider text-stone-500">
                                <th class="px-6 py-4">#</th>
                                <th class="px-6 py-4">Customer</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Orders</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-800/60">
                            @forelse($topCustomers as $i => $c)
                                <tr class="hover:bg-stone-800/30 transition">
                                    <td class="px-6 py-4 text-sm text-stone-500">{{ $i + 1 }}</td>
                                    <td class="px-6 py-4 text-sm text-white">{{ $c->name }}</td>
                                    <td class="px-6 py-4 text-sm text-stone-400">{{ $c->email }}</td>
                                    <td class="px-6 py-4"><span
                                            class="px-2.5 py-1 rounded-lg bg-amber-400/10 border border-amber-400/20 text-amber-400 text-xs">{{ $c->orders_count }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-sm text-stone-500">No data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl overflow-hidden">
                <div class="px-6 py-5 border-b border-stone-800/80">
                    <h4 class="text-base font-semibold text-white">Customer Orders</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-stone-800/80 text- uppercase tracking-wider text-stone-500">
                                <th class="px-6 py-4">Customer</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Orders</th>
                                <th class="px-6 py-4">Latest Order</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-800/60">
                            @forelse($customerOrders as $c)
                                <tr class="hover:bg-stone-800/30 transition">
                                    <td class="px-6 py-4 text-sm text-white">{{ $c->name }}</td>
                                    <td class="px-6 py-4 text-sm text-stone-400">{{ $c->email }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-amber-400">{{ $c->orders_count }}</td>
                                    <td class="px-6 py-4 text-xs text-stone-400">
                                        {{ $c->latestOrder?->created_at?->format('d M Y, h:i A') ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-sm text-stone-500">No data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-6">
                <h3 class="text-base font-semibold text-white">Catalog Overview</h3>
                <div class="space-y-4 mt-5">
                    <div class="flex justify-between border-b border-stone-800 pb-4"><span
                            class="text-sm text-stone-400">Products</span><span
                            class="text-sm font-semibold text-white">{{ number_format($totalProducts) }}</span></div>
                    <div class="flex justify-between border-b border-stone-800 pb-4"><span
                            class="text-sm text-stone-400">Categories</span><span
                            class="text-sm font-semibold text-white">{{ number_format($totalCategories) }}</span></div>
                    <div class="flex justify-between"><span class="text-sm text-stone-400">Vendors</span><span
                            class="text-sm font-semibold text-white">{{ number_format($totalVendors) }}</span></div>
                </div>
            </div>
            <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-6">
                <h3 class="text-base font-semibold text-white">Order Summary</h3>
                <div class="space-y-4 mt-5">
                    <div class="flex justify-between"><span class="text-sm text-stone-400">Total Orders</span><span
                            class="text-sm font-semibold text-white">{{ number_format($totalOrders) }}</span></div>
                    <div class="flex justify-between"><span class="text-sm text-stone-400">Completed</span><span
                            class="text-sm font-semibold text-emerald-400">{{ number_format($completedOrders) }}</span>
                    </div>
                    <div class="flex justify-between"><span class="text-sm text-stone-400">Pending</span><span
                            class="text-sm font-semibold text-amber-400">{{ number_format($pendingOrders) }}</span></div>
                    <div class="flex justify-between"><span class="text-sm text-stone-400">Cancelled</span><span
                            class="text-sm font-semibold text-rose-400">{{ number_format($cancelledOrders) }}</span></div>
                </div>
            </div>
        </div>

        <div class="mb-10">
            <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl overflow-hidden">
                <div class="px-6 py-5 border-b border-stone-800/80">
                    <h3 class="text-base font-semibold text-white">Recent Orders</h3>
                    <p class="text-xs text-stone-500 mt-1">Latest 10 orders</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-stone-800/80 text- uppercase tracking-wider text-stone-500">
                                <th class="px-6 py-4">Order</th>
                                <th class="px-6 py-4">Customer</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-800/60">
                            @forelse($recentOrders as $order)
                                <tr class="hover:bg-stone-800/30 transition">
                                    <td class="px-6 py-4 text-sm font-semibold text-amber-400">#{{ $order->order_number }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-white">{{ $order->user_name }}</div>
                                        <div class="text-xs text-stone-500">{{ $order->user_email }}</div>
                                    </td>
                                    <td class="px-6 py-4"><span
                                            class="px-2.5 py-1 rounded-lg bg-{{ $order->status_color }}-400/10 border border-{{ $order->status_color }}-400/20 text-{{ $order->status_color }}-400 text-xs">{{ $order->status_label }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-stone-400">{{ $order->formatted_date }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-sm text-stone-500">No orders
                                        found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-8 bg-stone-900/60 border border-stone-800/80 rounded-2xl p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-stone-100">Export Report</h2>
                    <p class="text-sm text-stone-400 mt-1">Download current report as PDF.</p>
                </div>
                <a href="{{ route('admin.reports.export.pdf', request()->query()) }}"
                    class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-lg bg-amber-500 hover:bg-amber-400 text-stone-950 font-semibold transition">Download
                    PDF</a>
            </div>
        </div>
    </div>
@endsection
