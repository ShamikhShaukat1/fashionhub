@extends('layouts.app')
@section('title', 'Customers')
@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-white">
                    Customers
                </h1>

                <p class="text-sm text-stone-500 mt-1">
                    Manage FashionHub customers
                </p>
            </div>

            <div class="px-4 py-2 rounded-xl bg-stone-900 border border-stone-800">
                <span class="text-xs text-stone-500">
                    Total Customers
                </span>

                <span class="ml-2 text-sm font-bold text-amber-400">
                    {{ $customers->total() }}
                </span>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 px-4 py-3 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-stone-900 border border-stone-800 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-stone-950 border-b border-stone-800">
                        <tr>
                            <th class="text-left px-6 py-4 text-xs uppercase tracking-wider text-stone-500">
                                Customer
                            </th>

                            <th class="text-left px-6 py-4 text-xs uppercase tracking-wider text-stone-500">
                                Email
                            </th>

                            <th class="text-left px-6 py-4 text-xs uppercase tracking-wider text-stone-500">
                                Registered
                            </th>

                            <th class="text-right px-6 py-4 text-xs uppercase tracking-wider text-stone-500">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stone-800">
                        @forelse($customers as $customer)
                            <tr class="hover:bg-stone-800/40 transition">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-amber-400 text-stone-950 flex items-center justify-center font-bold">
                                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                                        </div>

                                        <div>
                                            <p class="font-semibold text-white">
                                                {{ $customer->name }}
                                            </p>

                                            <p class="text-xs text-stone-500">
                                                Customer #{{ $customer->id }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-5 text-stone-400">
                                    {{ $customer->email }}
                                </td>

                                <td class="px-6 py-5 text-stone-400">
                                    {{ $customer->created_at->format('M d, Y') }}
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ route('admin.customers.show', $customer) }}" class="px-3 py-2 rounded-lg bg-stone-800 hover:bg-stone-700 text-stone-300 text-xs font-semibold">
                                            View
                                        </a>

                                        <a href="{{ route('admin.customers.edit', $customer) }}" class="px-3 py-2 rounded-lg bg-amber-400 hover:bg-amber-300 text-stone-950 text-xs font-semibold">
                                            Edit
                                        </a>

                                        <a href="{{ route('admin.customers.delete', $customer) }}"
                                            class="px-3 py-2 rounded-lg bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white text-xs font-semibold transition">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-stone-500">
                                    No customers found.
                                </td>

                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


            @if ($customers->hasPages())
                <div class="px-6 py-4 border-t border-stone-800">
                    {{ $customers->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection
