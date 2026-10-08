@extends('layouts.app')
@section('title', 'Inventory History - Fashion Hub')
@section('page', 'Inventory')
@section('heading', 'Inventory History')
@section('content')

    <div class="max-w-7xl mx-auto space-y-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>

                <h2 class="text-2xl font-semibold text-stone-100">
                    {{ $product->name }}
                </h2>

                <p class="text-sm text-stone-400 mt-1">
                    Inventory transaction history
                </p>

            </div>

            <div class="flex gap-3">

                <a href="{{ route('admin.inventory.index') }}"
                    class="px-4 py-2 rounded-xl border border-stone-700 hover:bg-stone-800 text-stone-300 transition">
                    Back
                </a>

                <a href="{{ route('admin.inventory.create', ['product_id' => $product->id]) }}"
                    class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-semibold transition">
                    Adjust Stock
                </a>

            </div>

        </div>

        <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>

                    <p class="text-sm text-stone-400">
                        Current Stock
                    </p>

                    <p class="text-4xl font-bold text-stone-100 mt-2">
                        {{ $product->stock }}
                    </p>

                </div>

                <div>

                    @if ($product->stock == 0)
                        <span class="px-4 py-2 rounded-full bg-red-500/10 text-red-400 border border-red-500/20">
                            Out of Stock
                        </span>
                    @elseif($product->stock <= 5)
                        <span class="px-4 py-2 rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20">
                            Low Stock
                        </span>
                    @else
                        <span
                            class="px-4 py-2 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                            In Stock
                        </span>
                    @endif

                </div>

            </div>
        </div>

        <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-stone-800">
                        <tr class="text-left text-sm text-stone-400">
                            <th class="px-6 py-4">
                                Date
                            </th>

                            <th class="px-6 py-4">
                                Type
                            </th>

                            <th class="px-6 py-4">
                                Quantity
                            </th>

                            <th class="px-6 py-4">
                                Stock Before
                            </th>

                            <th class="px-6 py-4">
                                Stock After
                            </th>

                            <th class="px-6 py-4">
                                Reason
                            </th>

                            <th class="px-6 py-4">
                                User
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stone-800">
                        @forelse($transactions as $transaction)
                            <tr class="hover:bg-stone-800/40">
                                <td class="px-6 py-5 text-stone-400">
                                    {{ $transaction->created_at->format('d M Y, h:i A') }}
                                </td>

                                <td class="px-6 py-5">
                                    @php
                                        $typeLabels = [
                                            'stock_in' => 'Stock In',
                                            'stock_out' => 'Stock Out',
                                            'adjustment' => 'Adjustment',
                                            'return' => 'Return',
                                        ];
                                    @endphp

                                    <span class="text-stone-100">
                                        {{ $typeLabels[$transaction->type] ?? ucfirst($transaction->type) }}
                                    </span>
                                </td>

                                <td class="px-6 py-5">
                                    @if ($transaction->quantity_change > 0)
                                        <span class="text-emerald-400 font-semibold">
                                            +{{ $transaction->quantity_change }}
                                        </span>
                                    @elseif($transaction->quantity_change < 0)
                                        <span class="text-red-400 font-semibold">
                                            {{ $transaction->quantity_change }}
                                        </span>
                                    @else
                                        <span class="text-stone-400">
                                            0
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-5 text-stone-400">
                                    {{ $transaction->stock_before }}
                                </td>

                                <td class="px-6 py-5 text-stone-100 font-semibold">
                                    {{ $transaction->stock_after }}
                                </td>

                                <td class="px-6 py-5 text-stone-400">
                                    {{ $transaction->reason ?? '—' }}
                                </td>

                                <td class="px-6 py-5 text-stone-400">
                                    {{ $transaction->user->name ?? 'System' }}
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-stone-500">
                                    No inventory transactions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($transactions->hasPages())
                <div class="px-6 py-5 border-t border-stone-800">
                    {{ $transactions->links() }}
                </div>
            @endif

        </div>

    </div>

@endsection
