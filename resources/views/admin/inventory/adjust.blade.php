@extends('layouts.app')

@section('title', 'Adjust Inventory - Fashion Hub')

@section('page', 'Inventory')

@section('heading', 'Adjust Inventory')

@section('content')

    <div class="max-w-3xl mx-auto">

        <div class="bg-stone-900/60 border border-stone-800/80 rounded-2xl p-8">

            <div class="mb-8">

                <h2 class="text-2xl font-semibold text-stone-100">
                    Inventory Adjustment
                </h2>

                <p class="text-sm text-stone-400 mt-1">
                    Add, remove or correct product stock.
                </p>

            </div>

            @if ($errors->any())

                <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 p-5">

                    <ul class="space-y-1 text-sm text-red-400">

                        @foreach ($errors->all() as $error)
                            <li>
                                {{ $error }}
                            </li>
                        @endforeach

                    </ul>

                </div>

            @endif

            <form method="POST" action="{{ route('admin.inventory.store') }}" class="space-y-6">

                @csrf

                {{-- Product --}}
                <div>

                    <label class="block text-sm text-stone-400 mb-2">
                        Product
                    </label>

                    <select name="product_id" required
                        class="w-full bg-stone-800 border border-stone-700 rounded-xl px-4 py-3 text-stone-100 focus:outline-none focus:border-amber-500">

                        <option value="">
                            Select Product
                        </option>

                        @foreach ($products as $product)
                            <option value="{{ $product->id }}"
                                {{ old('product_id', request('product_id')) == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} -
                                Current Stock: {{ $product->stock }}
                            </option>
                        @endforeach

                    </select>

                </div>

                {{-- Type --}}
                <div>

                    <label class="block text-sm text-stone-400 mb-2">
                        Inventory Action
                    </label>

                    <select name="type" required
                        class="w-full bg-stone-800 border border-stone-700 rounded-xl px-4 py-3 text-stone-100 focus:outline-none focus:border-amber-500">

                        <option value="stock_in">
                            Stock In
                        </option>

                        <option value="stock_out">
                            Stock Out
                        </option>

                        <option value="adjustment">
                            Stock Adjustment
                        </option>

                    </select>

                </div>

                {{-- Quantity --}}
                <div>

                    <label class="block text-sm text-stone-400 mb-2">
                        Quantity
                    </label>

                    <input type="number" name="quantity" min="0" value="{{ old('quantity') }}" required
                        class="w-full bg-stone-800 border border-stone-700 rounded-xl px-4 py-3 text-stone-100 focus:outline-none focus:border-amber-500"
                        placeholder="Enter quantity">

                    <p class="text-xs text-stone-500 mt-2">
                        For Stock Adjustment, enter the final stock quantity.
                    </p>

                </div>

                {{-- Reason --}}
                <div>

                    <label class="block text-sm text-stone-400 mb-2">
                        Reason
                    </label>

                    <input type="text" name="reason" value="{{ old('reason') }}"
                        placeholder="e.g. New shipment, damaged item, stock correction"
                        class="w-full bg-stone-800 border border-stone-700 rounded-xl px-4 py-3 text-stone-100 focus:outline-none focus:border-amber-500">

                </div>

                {{-- Notes --}}
                <div>

                    <label class="block text-sm text-stone-400 mb-2">
                        Notes
                    </label>

                    <textarea name="notes" rows="4" placeholder="Additional notes..."
                        class="w-full bg-stone-800 border border-stone-700 rounded-xl px-4 py-3 text-stone-100 focus:outline-none focus:border-amber-500">{{ old('notes') }}</textarea>

                </div>

                {{-- Buttons --}}
                <div class="flex items-center justify-end gap-3 pt-4">

                    <a href="{{ route('admin.inventory.index') }}"
                        class="px-5 py-3 rounded-xl border border-stone-700 hover:bg-stone-800 text-stone-300 transition">
                        Cancel
                    </a>

                    <button type="submit"
                        class="px-5 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-stone-950 font-semibold transition">
                        Update Inventory
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
