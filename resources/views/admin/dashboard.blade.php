@extends('layouts.app')
@section('page', 'Admin Dashboard')
@section('heading', 'Admin Dashboard')
@section('content')

    <div class="space-y-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-semibold text-white">
                    Welcome back, Admin
                </h2>

                <p class="text-sm text-stone-400 mt-1">
                    Here's what's happening with your FashionHub store.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2.5 bg-stone-900 border border-stone-800 hover:bg-stone-800 hover:border-amber-400/40 text-stone-300 hover:text-amber-400 text-xs font-semibold uppercase tracking-wider rounded-xl transition">
                    Categories
                </a>

                <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2.5 bg-amber-400 hover:bg-amber-300 text-stone-950 text-xs font-semibold uppercase tracking-wider rounded-xl transition">
                    Manage Products
                </a>
            </div>
        </div>

        @php
            $stats = [
                [
                    'title' => 'Total Products',
                    'value' => $totalProducts,
                    'description' => 'Products in your store',
                    'valueClass' => 'text-amber-400',
                    'iconBg' => 'bg-amber-400/10 border-amber-400/10',
                    'iconColor' => 'text-amber-400',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0v10l-8 4-8-4V7m16 0l-8 4m-8-4l8 4m0 0v10" />',
                ],
                [
                    'title' => 'Active Products',
                    'value' => $activeProducts,
                    'description' => 'Currently available',
                    'valueClass' => 'text-amber-400',
                    'iconBg' => 'bg-amber-400/10 border-amber-400/10',
                    'iconColor' => 'text-amber-400',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 13l4 4L19 7" />',
                ],
                [
                    'title' => 'Inactive Products',
                    'value' => $inactiveProducts,
                    'description' => 'Currently disabled',
                    'valueClass' => 'text-stone-200',
                    'iconBg' => 'bg-stone-800 border-stone-700',
                    'iconColor' => 'text-stone-400',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12" />',
                ],
                [
                    'title' => 'Low Stock',
                    'value' => $lowStockProducts,
                    'description' => 'Products need attention',
                    'valueClass' => 'text-amber-400',
                    'iconBg' => 'bg-amber-400/10 border-amber-400/10',
                    'iconColor' => 'text-amber-400',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v4m0 4h.01M10.3 4.6L2.9 17a2 2 0 001.7 3h14.8a2 2 0 001.7-3L13.7 4.6a2 2 0 00-3.4 0z" />',
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
            @foreach ($stats as $stat)
                <div class="bg-stone-900 border border-stone-800 rounded-2xl p-5 hover:border-amber-400/30 transition">
                    <div class="flex items-start justify-between">
                        <div class="min-w-0">
                            <p class="text-xs uppercase tracking-wider text-stone-500">
                                {{ $stat['title'] }}
                            </p>

                            <h3 class="text-3xl font-bold {{ $stat['valueClass'] }} mt-2">
                                {{ $stat['value'] }}
                            </h3>

                            <p class="text-xs text-stone-500 mt-2">
                                {{ $stat['description'] }}
                            </p>
                        </div>

                        <div class="w-11 h-11 shrink-0 rounded-xl border flex items-center justify-center {{ $stat['iconBg'] }}">
                            <svg class="w-5 h-5 {{ $stat['iconColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $stat['icon'] !!}
                            </svg>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-lg font-semibold text-white">
                            Product Status
                        </h3>

                        <p class="text-xs text-stone-500 mt-1">
                            Active and inactive products
                        </p>
                    </div>

                    <div class="w-9 h-9 rounded-lg bg-amber-400/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19V6m0 0l-3 3m3-3l3 3M15 5v13m0 0l-3-3m3 3l3-3" />
                        </svg>
                    </div>
                </div>

                <div class="relative h-72">
                    <canvas id="productStatusChart"></canvas>
                </div>
            </div>

            <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-lg font-semibold text-white">
                            Inventory Overview
                        </h3>

                        <p class="text-xs text-stone-500 mt-1">
                            Current stock condition
                        </p>
                    </div>

                    <div class="w-9 h-9 rounded-lg bg-amber-400/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3v18h18M7 16v-5m5 5V7m5 9V4" />
                        </svg>
                    </div>
                </div>

                <div class="relative h-72">
                    <canvas id="inventoryChart"></canvas>
                </div>

            </div>

        </div>

        <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-lg font-semibold text-white">
                        Products by Category
                    </h3>

                    <p class="text-xs text-stone-500 mt-1">
                        Product distribution across your categories
                    </p>
                </div>

                <a href="{{ route('admin.categories.index') }}" class="text-xs font-semibold text-amber-400 hover:text-amber-300">
                    Manage Categories
                </a>
            </div>

            <div class="relative h-80">
                @if ($categoryNames->isNotEmpty())
                    <canvas id="categoryChart"></canvas>
                @else
                    <div class="h-full flex items-center justify-center">
                        <div class="text-center">
                            <p class="text-sm text-stone-500">
                                No category data available.
                            </p>

                            <a href="{{ route('admin.categories.create') }}" class="inline-block mt-3 text-xs text-amber-400 hover:text-amber-300">
                                Create your first category →
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <div class="bg-stone-900 border border-stone-800 rounded-2xl overflow-hidden">
                <div class="px-6 py-5 border-b border-stone-800 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-white">
                            Recent Products
                        </h3>

                        <p class="text-xs text-stone-500 mt-1">
                            Latest products added
                        </p>
                    </div>

                    <a href="{{ route('admin.products.index') }}"
                        class="text-xs font-semibold text-amber-400 hover:text-amber-300">
                        View All
                    </a>
                </div>

                <div class="max-h-[360px] overflow-y-auto">
                    @forelse ($products as $product)
                        <div
                            class="px-6 py-4 border-b border-stone-800 last:border-b-0 flex items-center justify-between gap-4 hover:bg-stone-800/40 transition">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 shrink-0 rounded-xl bg-amber-400/10 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0v10l-8 4-8-4V7m16 0l-8 4m-8-4l8 4m0 0v10" />
                                    </svg>
                                </div>

                                <div class="min-w-0">
                                    <p
                                        class="text-sm font-medium text-stone-200 truncate">
                                        {{ $product->name }}
                                    </p>

                                    <div class="flex items-center gap-3 mt-1">
                                        <span class="text-xs text-stone-500">
                                            Stock:
                                            <span class="text-amber-400">
                                                {{ $product->stock }}
                                            </span>
                                        </span>

                                        <span class="text-[10px] uppercase tracking-wider {{ $product->status ? 'text-amber-400' : 'text-stone-500' }}">
                                            {{ $product->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('admin.products.edit', $product) }}" class="shrink-0 px-3 py-2 bg-stone-800 border border-stone-700 hover:bg-amber-400 hover:border-amber-400 hover:text-stone-950 text-stone-300 text-xs font-semibold rounded-lg transition">
                                Edit
                            </a>
                        </div>

                    @empty

                        <div class="px-6 py-12 text-center">
                            <p class="text-sm text-stone-500">
                                No products available.
                            </p>

                            <a href="{{ route('admin.products.create') }}" class="inline-block mt-3 text-xs text-amber-400 hover:text-amber-300">
                                Add your first product →
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="bg-stone-900 border border-stone-800 rounded-2xl overflow-hidden">
                <div class="px-6 py-5 border-b border-stone-800 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-white">
                            Recent Categories
                        </h3>

                        <p class="text-xs text-stone-500 mt-1">
                            Latest categories created
                        </p>
                    </div>

                    <a href="{{ route('admin.categories.index') }}" class="text-xs font-semibold text-amber-400 hover:text-amber-300">
                        View All
                    </a>
                </div>

                <div class="max-h-[360px] overflow-y-auto">
                    @forelse ($categories as $category)
                        <div class="px-6 py-4 border-b border-stone-800 last:border-b-0 flex items-center justify-between gap-4 hover:bg-stone-800/40 transition">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 shrink-0 rounded-xl bg-amber-400/10 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7a2 2 0 012-2h5l2 2h7a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                                    </svg>
                                </div>

                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-stone-200 truncate">
                                        {{ $category->name }}
                                    </p>

                                    <p class="text-xs text-stone-500 mt-1 truncate">
                                        {{ $category->description ?: 'No description available' }}
                                    </p>
                                </div>

                            </div>

                            <a href="{{ route('admin.categories.edit', $category) }}" class="shrink-0 px-3 py-2 bg-stone-800 border border-stone-700 hover:bg-amber-400 hover:border-amber-400 hover:text-stone-950 text-stone-300 text-xs font-semibold rounded-lg transition">
                                Edit
                            </a>
                        </div>

                    @empty

                        <div class="px-6 py-12 text-center">
                            <p class="text-sm text-stone-500">
                                No categories available.
                            </p>

                            <a href="{{ route('admin.categories.create') }}" class="inline-block mt-3 text-xs text-amber-400 hover:text-amber-300">
                                Add your first category →
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        @php
            $quickActions = [
                [
                    'title' => 'Add Product',
                    'description' => 'Create a new product',
                    'route' => 'admin.products.create',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v16m8-8H4" />',
                ],
                [
                    'title' => 'Add Category',
                    'description' => 'Create a new category',
                    'route' => 'admin.categories.create',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7a2 2 0 012-2h5l2 2h7a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />',
                ],
                [
                    'title' => 'Manage Inventory',
                    'description' => 'Review product stock',
                    'route' => 'admin.products.index',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3v18h18M7 16v-5m5 5V7m5 9V4" />',
                ],
            ];
        @endphp

        <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
            <div class="mb-5">
                <h3 class="text-lg font-semibold text-white">
                    Quick Actions
                </h3>

                <p class="text-xs text-stone-500 mt-1">
                    Quickly manage your FashionHub store
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach ($quickActions as $action)
                    <a href="{{ route($action['route']) }}" class="group p-4 bg-stone-950 border border-stone-800 hover:border-amber-400/40 rounded-xl transition">
                        <div class="w-10 h-10 rounded-lg bg-amber-400/10 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $action['icon'] !!}
                            </svg>
                        </div>

                        <p class="text-sm font-semibold text-white group-hover:text-amber-400 transition">
                            {{ $action['title'] }}
                        </p>

                        <p class="text-xs text-stone-500 mt-1">
                            {{ $action['description'] }}
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
            Chart.defaults.color = '#a8a29e';

            const colors = {
                primary: '#fbbf24',
                dark: '#44403c',
                darker: '#57534e',
                background: '#1c1917',
                border: '#44403c',
                grid: '#292524',
                text: '#a8a29e',
                white: '#ffffff',
                light: '#d6d3d1',
            };

            const tooltip = {
                backgroundColor: colors.background,
                borderColor: colors.border,
                borderWidth: 1,
                titleColor: colors.white,
                bodyColor: colors.light,
                padding: 12,
            };

            const barScales = {
                x: {
                    ticks: {
                        color: colors.text,
                        font: {
                            size: 11
                        },
                        maxRotation: 0,
                    },
                    grid: {
                        display: false
                    },
                },

                y: {
                    beginAtZero: true,
                    ticks: {
                        color: colors.text,
                        precision: 0,
                        font: {
                            size: 11
                        },
                    },
                    grid: {
                        color: colors.grid
                    },
                },
            };

            const productStatusCanvas = document.getElementById('productStatusChart');
            if (productStatusCanvas) {
                new Chart(productStatusCanvas, {
                    type: 'doughnut',
                    data: {

                        labels: [
                            'Active',
                            'Inactive'
                        ],
                        datasets: [{
                            data: [
                                @json($activeProducts),
                                @json($inactiveProducts)
                            ],
                            backgroundColor: [
                                colors.primary,
                                colors.dark
                            ],
                            borderColor: colors.background,
                            borderWidth: 4,
                            hoverOffset: 7
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '72%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: colors.text,
                                    padding: 20,
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip
                        }
                    }
                });
            }

            const inventoryCanvas = document.getElementById('inventoryChart');
            if (inventoryCanvas) {
                new Chart(inventoryCanvas, {
                    type: 'bar',
                    data: {
                        labels: [
                            'Healthy Stock',
                            'Low Stock',
                            'Out of Stock'
                        ],
                        datasets: [{
                            data: [
                                @json($healthyStockProducts),
                                @json($lowStockProducts),
                                @json($outOfStockProducts)
                            ],
                            backgroundColor: [
                                colors.primary,
                                colors.text,
                                colors.darker
                            ],
                            borderRadius: 8,
                            borderSkipped: false,
                            maxBarThickness: 55
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: barScales,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip
                        }
                    }
                });
            }

            const categoryCanvas = document.getElementById('categoryChart');
            if (categoryCanvas) {
                new Chart(categoryCanvas, {
                    type: 'bar',
                    data: {
                        labels: @json($categoryNames),
                        datasets: [{
                            label: 'Products',
                            data: @json($categoryProductCounts),
                            backgroundColor: colors.primary,
                            borderRadius: 8,
                            borderSkipped: false,
                            maxBarThickness: 55
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: barScales,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip
                        }
                    }
                });
            }
        });
    </script>
@endsection
