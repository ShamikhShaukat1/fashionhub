@extends('layouts.app')
@section('title', 'Customer Details')
@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <p class="text-xs uppercase tracking-widest text-amber-400 mb-2">
                    Customer
                </p>

                <h1 class="text-2xl font-bold text-white">
                    {{ $customer->name }}
                </h1>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.customers.edit', $customer) }}" class="px-4 py-2 rounded-xl bg-amber-400 hover:bg-amber-300 text-stone-950 text-sm font-semibold">
                    Edit Customer
                </a>

                <a href="{{ route('admin.customers.index') }}" class="px-4 py-2 rounded-xl bg-stone-800 hover:bg-stone-700 text-stone-300 text-sm font-semibold">
                    Back
                </a>
            </div>
        </div>

        <div class="bg-stone-900 border border-stone-800 rounded-2xl p-8">
            <div class="flex items-center gap-5 mb-8">
                <div class="w-20 h-20 rounded-full bg-amber-400 text-stone-950 flex items-center justify-center text-2xl font-bold">
                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                </div>

                <div>
                    <h2 class="text-xl font-bold text-white">
                        {{ $customer->name }}
                    </h2>

                    <p class="text-stone-500">
                        {{ $customer->email }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-stone-950 rounded-xl p-5">
                    <p class="text-xs uppercase tracking-wider text-stone-500">
                        Customer ID
                    </p>

                    <p class="mt-2 text-white font-semibold">
                        #{{ $customer->id }}
                    </p>
                </div>

                <div class="bg-stone-950 rounded-xl p-5">
                    <p class="text-xs uppercase tracking-wider text-stone-500">
                        Role
                    </p>

                    <p class="mt-2 text-amber-400 font-semibold">
                        Customer
                    </p>
                </div>

                <div class="bg-stone-950 rounded-xl p-5">
                    <p class="text-xs uppercase tracking-wider text-stone-500">
                        Email
                    </p>

                    <p class="mt-2 text-white font-semibold">
                        {{ $customer->email }}
                    </p>
                </div>

                <div class="bg-stone-950 rounded-xl p-5">
                    <p class="text-xs uppercase tracking-wider text-stone-500">
                        Registered
                    </p>

                    <p class="mt-2 text-white font-semibold">
                        {{ $customer->created_at->format('F d, Y') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-6 bg-stone-900 border border-stone-800 rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-white">
                Customer Activity
            </h3>

            <p class="text-sm text-stone-500 mt-2">
                Orders, wishlist, addresses and other customer activity will appear here when those modules are implemented.
            </p>
        </div>
    </div>

@endsection
