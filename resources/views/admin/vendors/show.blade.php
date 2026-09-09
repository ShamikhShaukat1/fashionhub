@extends('layouts.app')
@section('title', $vendor->store_name)
@section('content')
    <div class="min-h-screen bg-stone-950 px-6 py-10">
        <div class="max-w-6xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('admin.vendors.index') }}" class="text-xs uppercase tracking-widest text-stone-500 hover:text-amber-400 transition">
                    ← Back to Vendors
                </a>

            </div>

            <div class="bg-stone-900 border border-stone-800 rounded-2xl overflow-hidden mb-8">
                @if ($vendor->banner)
                    <div class="h-56 overflow-hidden">
                        <img src="{{ asset('storage/' . $vendor->banner) }}" alt="{{ $vendor->store_name }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="h-40 bg-stone-800 flex items-center justify-center">
                        <span class="text-stone-600 text-4xl">◆</span>
                    </div>
                @endif

                <div class="p-8">
                    <div class="flex flex-col md:flex-row md:items-center gap-6">
                        @if ($vendor->logo)
                            <img src="{{ asset('storage/' . $vendor->logo) }}" alt="{{ $vendor->store_name }}" class="w-24 h-24 rounded-2xl object-cover border border-stone-700">
                        @else
                            <div class="w-24 h-24 rounded-2xl bg-amber-400 text-stone-950 flex items-center justify-center text-3xl font-bold">
                                {{ strtoupper(substr($vendor->store_name, 0, 1)) }}
                            </div>
                        @endif

                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-white">
                                {{ $vendor->store_name }}
                            </h1>

                            <p class="text-sm text-stone-500 mt-1">
                                {{ $vendor->user->name }} · {{ $vendor->user->email }}
                            </p>
                        </div>

                        <div>
                            @if ($vendor->status === 'active')
                                <span class="px-4 py-2 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-400">
                                    Active
                                </span>
                            @elseif ($vendor->status === 'pending')
                                <span class="px-4 py-2 rounded-full text-xs font-bold bg-amber-500/10 text-amber-400">
                                    Pending
                                </span>
                            @elseif ($vendor->status === 'suspended')
                                <span class="px-4 py-2 rounded-full text-xs font-bold bg-orange-500/10 text-orange-400">
                                    Suspended
                                </span>
                            @else
                                <span class="px-4 py-2 rounded-full text-xs font-bold bg-red-500/10 text-red-400">
                                    Rejected
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div
                    class="mb-6 px-5 py-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mb-6 px-5 py-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
                    <h2 class="text-lg font-semibold text-white mb-6">
                        Store Information
                    </h2>

                    <div class="space-y-5">
                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-stone-600">
                                Store Name
                            </p>
                            <p class="text-sm text-stone-300 mt-1">
                                {{ $vendor->store_name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-stone-600">
                                Store URL
                            </p>
                            <p class="text-sm text-amber-400 mt-1">
                                /{{ $vendor->slug }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-stone-600">
                                Phone
                            </p>
                            <p class="text-sm text-stone-300 mt-1">
                                {{ $vendor->phone ?? 'Not provided' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-stone-600">
                                Description
                            </p>
                            <p class="text-sm text-stone-400 mt-1 leading-6">
                                {{ $vendor->description ?? 'No description available.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
                    <h2 class="text-lg font-semibold text-white mb-6">
                        Store Address
                    </h2>

                    <div class="space-y-5">
                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-stone-600">
                                Address
                            </p>
                            <p class="text-sm text-stone-300 mt-1">
                                {{ $vendor->address ?? 'Not provided' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-stone-600">
                                City
                            </p>
                            <p class="text-sm text-stone-300 mt-1">
                                {{ $vendor->city ?? 'Not provided' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-stone-600">
                                State
                            </p>
                            <p class="text-sm text-stone-300 mt-1">
                                {{ $vendor->state ?? 'Not provided' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-stone-600">
                                Country
                            </p>
                            <p class="text-sm text-stone-300 mt-1">
                                {{ $vendor->country ?? 'Not provided' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-stone-900 border border-stone-800 rounded-2xl overflow-hidden">
                <div class="p-6 border-b border-stone-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-white">
                                Vendor Products
                            </h2>
                            <p class="text-xs text-stone-500 mt-1">
                                Products belonging to this vendor.
                            </p>
                        </div>
                        <span class="text-sm text-amber-400 font-semibold">
                            {{ $vendor->products->count() }} Products
                        </span>
                    </div>
                </div>

                @if ($vendor->products->count())
                    <div class="divide-y divide-stone-800">
                        @foreach ($vendor->products as $product)
                            <div class="p-5 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-white">
                                        {{ $product->name }}
                                    </p>
                                    <p class="text-xs text-stone-500 mt-1">
                                        {{ $product->category->name ?? 'No category' }}
                                    </p>
                                </div>

                                <div class="text-right">
                                    <p class="text-sm text-amber-400 font-semibold">
                                        Rs. {{ number_format($product->sale_price ?? $product->price, 2) }}
                                    </p>
                                    <p class="text-xs text-stone-500">
                                        Stock: {{ $product->stock }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-12 text-center">
                        <p class="text-sm text-stone-500">
                            This vendor has no products yet.
                        </p>
                    </div>
                @endif
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('admin.vendors.edit', $vendor) }}" class="px-6 py-3 rounded-xl bg-amber-400 hover:bg-amber-300 text-stone-950 text-sm font-bold transition">
                    Edit Vendor
                </a>

                <a href="{{ route('admin.vendors.delete', $vendor) }}" class="px-6 py-3 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-400 text-sm font-semibold transition">
                    Delete Vendor
                </a>
            </div>
        </div>
    </div>

@endsection
