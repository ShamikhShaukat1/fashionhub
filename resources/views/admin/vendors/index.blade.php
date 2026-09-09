@extends('layouts.app')
@section('title', 'Vendors')
@section('content')
    <div class="min-h-screen bg-stone-950 px-6 py-10">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <p class="text-xs uppercase tracking-[0.25em] text-amber-400 font-semibold">
                        Management
                    </p>

                    <h1 class="text-3xl font-bold text-white mt-2">
                        Vendors
                    </h1>

                    <p class="text-sm text-stone-500 mt-2">
                        Manage Fashion Hub vendors and stores.
                    </p>
                </div>

                <a href="{{ route('admin.vendors.create') }}" class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-amber-400 hover:bg-amber-300 text-stone-950 text-sm font-bold transition">
                    + Add Vendor
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 px-5 py-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 px-5 py-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-stone-900 border border-stone-800 rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-stone-800/60 border-b border-stone-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-[10px] uppercase tracking-widest text-stone-500">
                                    Vendor
                                </th>

                                <th class="px-6 py-4 text-left text-[10px] uppercase tracking-widest text-stone-500">
                                    Store
                                </th>

                                <th class="px-6 py-4 text-left text-[10px] uppercase tracking-widest text-stone-500">
                                    Location
                                </th>

                                <th class="px-6 py-4 text-left text-[10px] uppercase tracking-widest text-stone-500">
                                    Products
                                </th>

                                <th class="px-6 py-4 text-left text-[10px] uppercase tracking-widest text-stone-500">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-right text-[10px] uppercase tracking-widest text-stone-500">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-stone-800">
                            @forelse ($vendors as $vendor)
                                <tr class="hover:bg-stone-800/40 transition">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-full bg-amber-400 text-stone-950 flex items-center justify-center font-bold">
                                                {{ strtoupper(substr($vendor->user->name ?? 'V', 0, 1)) }}
                                            </div>

                                            <div>
                                                <p class="text-sm font-semibold text-white">
                                                    {{ $vendor->user->name }}
                                                </p>

                                                <p class="text-xs text-stone-500">
                                                    {{ $vendor->user->email }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-5">
                                        <p class="text-sm font-medium text-white">
                                            {{ $vendor->store_name }}
                                        </p>

                                        <p class="text-xs text-stone-500 mt-1">
                                            /{{ $vendor->slug }}
                                        </p>
                                    </td>

                                    <td class="px-6 py-5 text-sm text-stone-400">
                                        {{ $vendor->city ?? '—' }}
                                        @if ($vendor->country)
                                            , {{ $vendor->country }}
                                        @endif
                                    </td>

                                    <td class="px-6 py-5 text-sm text-stone-300">
                                        {{ $vendor->products_count ?? $vendor->products()->count() }}
                                    </td>

                                    <td class="px-6 py-5">
                                        @if ($vendor->status === 'active')
                                            <span class="px-3 py-1 rounded-full text-[10px] uppercase tracking-wider font-bold bg-emerald-500/10 text-emerald-400">
                                                Active
                                            </span>
                                        @elseif ($vendor->status === 'pending')
                                            <span class="px-3 py-1 rounded-full text-[10px] uppercase tracking-wider font-bold bg-amber-500/10 text-amber-400">
                                                Pending
                                            </span>
                                        @elseif ($vendor->status === 'suspended')
                                            <span class="px-3 py-1 rounded-full text-[10px] uppercase tracking-wider font-bold bg-orange-500/10 text-orange-400">
                                                Suspended
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-[10px] uppercase tracking-wider font-bold bg-red-500/10 text-red-400">
                                                Rejected
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-5">
                                        <div class="flex justify-end items-center gap-2">
                                            <a href="{{ route('admin.vendors.show', $vendor) }}" class="px-3 py-2 rounded-lg bg-stone-800 hover:bg-stone-700 text-stone-300 hover:text-white text-xs font-semibold transition">
                                                View
                                            </a>

                                            <a href="{{ route('admin.vendors.edit', $vendor) }}" class="px-3 py-2 rounded-lg bg-amber-400/10 hover:bg-amber-400/20 text-amber-400 text-xs font-semibold transition">
                                                Edit
                                            </a>

                                            <a href="{{ route('admin.vendors.delete', $vendor) }}" class="px-3 py-2 rounded-lg bg-red-500/10 hover:bg-red-500/20 text-red-400 text-xs font-semibold transition">
                                                Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="text-4xl mb-4">
                                            ◆
                                        </div>
                                        <h3 class="text-lg font-semibold text-white">
                                            No vendors found
                                        </h3>
                                        <p class="text-sm text-stone-500 mt-2">
                                            Start by creating your first vendor.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($vendors->hasPages())
                <div class="mt-6">
                    {{ $vendors->links() }}
                </div>
            @endif

        </div>
    </div>

@endsection
