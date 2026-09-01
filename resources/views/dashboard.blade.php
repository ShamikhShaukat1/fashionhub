@extends('layouts.app')
@section('page', 'Dashboard')
@section('heading', 'Analytics & Overview')
@section('content')

<div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
    <div>
        <h2 class="text-2xl font-semibold text-white">
            Fashion Hub Analytics
        </h2>
        <p class="text-xs text-stone-400 mt-1">
            Real-time sales tracking, data analytics, and inventory management
        </p>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @foreach([
    ['label' => 'Total Revenue', 'value' => '$124,500', 'change' => '+14.2%', 'trend' => 'up', 'color' => 'text-emerald-400', 'sub' => 'vs last month'],
    ['label' => 'Total Orders', 'value' => '1,420', 'change' => '+8.1%', 'trend' => 'up', 'color' => 'text-emerald-400', 'sub' => 'vs last month'],
    ['label' => 'Avg. Order Value', 'value' => '$87.67', 'change' => '-2.3%', 'trend' => 'down', 'color' => 'text-rose-400', 'sub' => 'vs last month'],
    ['label' => 'Low Stock Items', 'value' => '3 Items', 'change' => 'Requires Action', 'trend' => 'warning', 'color' => 'text-amber-400', 'sub' => 'Reorder soon'],
    ] as $stat)
    <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-5 relative overflow-hidden">
        <div class="flex justify-between items-start">
            <p class="text-[11px] uppercase tracking-wider font-semibold text-stone-400">
                {{ $stat['label'] }}
            </p>
            <span class="text-[10px] font-medium px-2 py-0.5 rounded-full {{ $stat['trend'] === 'up' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : ($stat['trend'] === 'down' ? 'bg-rose-500/10 text-rose-400 border border-rose-500/20' : 'bg-amber-500/10 text-amber-400 border border-amber-500/20') }}">
                {{ $stat['change'] }}
            </span>
        </div>
        <p class="text-2xl font-bold mt-2 text-white">
            {{ $stat['value'] }}
        </p>
        <p class="text-[11px] text-stone-500 mt-1">
            {{ $stat['sub'] }}
        </p>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

    <div class="lg:col-span-2 bg-stone-900/60 border border-stone-800/80 rounded-2xl p-6 flex flex-col justify-between">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-base font-semibold text-white">Sales & Revenue Trend</h3>
                <p class="text-xs text-stone-500">Monthly performance analytics</p>
            </div>
            <select class="bg-stone-950 border border-stone-800 text-stone-300 text-xs rounded-lg px-3 py-1.5 focus:outline-none focus:border-amber-400">
                <option>Last 6 Months</option>
                <option>Last Year</option>
            </select>
        </div>

        <div class="h-48 flex items-end justify-between gap-3 pt-4 border-b border-stone-800/80 pb-2">
            @foreach([
            ['month' => 'Jan', 'height' => 'h-24', 'val' => '$14k'],
            ['month' => 'Feb', 'height' => 'h-32', 'val' => '$18k'],
            ['month' => 'Mar', 'height' => 'h-28', 'val' => '$16k'],
            ['month' => 'Apr', 'height' => 'h-40', 'val' => '$22k'],
            ['month' => 'May', 'height' => 'h-36', 'val' => '$20k'],
            ['month' => 'Jun', 'height' => 'h-44', 'val' => '$26k'],
            ] as $bar)
            <div class="flex-1 flex flex-col items-center gap-2 group">
                <span class="text-[10px] text-stone-400 opacity-0 group-hover:opacity-100 transition">{{ $bar['val'] }}</span>
                <div class="w-full bg-amber-400/20 group-hover:bg-amber-400 rounded-t-md transition-all duration-300 {{ $bar['height'] }}"></div>
                <span class="text-xs text-stone-500">{{ $bar['month'] }}</span>
            </div>
            @endforeach
        </div>

        <div class="flex justify-between items-center text-xs text-stone-400 pt-4">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-400 inline-block"></span>
                <span>Gross Revenue</span>
            </div>
            <span class="text-stone-500">Peak performance: June ($26,000)</span>
        </div>
    </div>

    <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-6">
        <h3 class="text-base font-semibold text-white mb-1">Top Selling Categories</h3>
        <p class="text-xs text-stone-500 mb-6">Distribution by revenue share</p>

        <div class="space-y-4">
            @foreach([
            ['category' => 'Outerwear', 'share' => '42%', 'width' => 'w-[42%]', 'color' => 'bg-amber-400'],
            ['category' => 'Evening Wear', 'share' => '28%', 'width' => 'w-[28%]', 'color' => 'bg-amber-500'],
            ['category' => 'Footwear', 'share' => '18%', 'width' => 'w-[18%]', 'color' => 'bg-amber-600'],
            ['category' => 'Accessories', 'share' => '12%', 'width' => 'w-[12%]', 'color' => 'bg-amber-700'],
            ] as $cat)
            <div>
                <div class="flex justify-between text-xs mb-1.5">
                    <span class="text-stone-300 font-medium">{{ $cat['category'] }}</span>
                    <span class="text-stone-400">{{ $cat['share'] }}</span>
                </div>
                <div class="w-full bg-stone-950 rounded-full h-2 overflow-hidden">
                    <div class="{{ $cat['color'] }} h-full rounded-full {{ $cat['width'] }}"></div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6 pt-4 border-t border-stone-800/60 text-center">
            <a href="#" class="text-xs text-amber-400 hover:underline">View Detailed Breakdown →</a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <div class="lg:col-span-2 bg-stone-900/60 border border-stone-800/80 rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-stone-800/60 flex justify-between items-center">
            <div>
                <h3 class="text-base font-semibold text-white">Products</h3>
                <p class="text-xs text-stone-500 mt-0.5">Manage inventory and product listings</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-xs text-amber-400 hover:underline">View All Products</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-stone-950/40">
                    <tr class="border-b border-stone-800 text-[11px] uppercase tracking-wider text-stone-400">
                        <th class="p-4">Item Name</th>
                        <th class="p-4">Category</th>
                        <th class="p-4">Price</th>
                        <th class="p-4">Stock Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-800/50">

                    @forelse($products as $product)

                    <tr class="hover:bg-stone-800/30 transition">

                        <td class="p-4 font-medium text-stone-200">
                            {{ $product->name }}
                        </td>

                        <td class="p-4 text-xs text-stone-400">
                            {{ $product->category_id }}
                        </td>

                        <td class="p-4 text-amber-400 font-medium text-xs">
                            ${{ number_format($product->price, 2) }}
                        </td>

                        <td class="p-4">
                            @if($product->stock > 10)
                                <span class="text-[10px] px-2.5 py-1 rounded-full border text-emerald-400 bg-emerald-500/10 border-emerald-500/20">
                                    {{ $product->stock }} in stock
                                </span>
                            @elseif($product->stock > 0)
                                <span class="text-[10px] px-2.5 py-1 rounded-full border text-rose-400 bg-rose-500/10 border-rose-500/20">
                                    {{ $product->stock }} in stock
                                </span>
                            @else
                                <span class="text-[10px] px-2.5 py-1 rounded-full border text-red-400 bg-red-500/10 border-red-500/20">
                                    Out of stock
                                </span>
                            @endif

                        </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="5" class="p-8 text-center text-stone-500">
                            No products found.
                        </td>
                    </tr>

                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-white">Recent Activity</h3>
            <span class="flex h-2 w-2 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
        </div>

        <div class="space-y-4">
            @foreach([
            ['order' => '#ORD-9421', 'item' => 'Tailored Leather Trench', 'time' => '12 mins ago', 'amount' => '$890.00'],
            ['order' => '#ORD-9420', 'item' => 'Silk Midnight Gown', 'time' => '45 mins ago', 'amount' => '$450.00'],
            ['order' => '#ORD-9419', 'item' => 'Cashmere Knit Sweater', 'time' => '2 hours ago', 'amount' => '$210.00'],
            ] as $activity)
            <div class="p-3 bg-stone-950/40 border border-stone-800/40 rounded-xl flex justify-between items-center">
                <div>
                    <p class="text-xs font-semibold text-stone-200">{{ $activity['order'] }}</p>
                    <p class="text-[11px] text-stone-400">{{ $activity['item'] }}</p>
                    <span class="text-[10px] text-stone-500">{{ $activity['time'] }}</span>
                </div>
                <span class="text-xs font-semibold text-amber-400">{{ $activity['amount'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

</div>

@endsection
