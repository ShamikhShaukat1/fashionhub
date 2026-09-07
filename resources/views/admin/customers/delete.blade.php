@extends('layouts.app')
@section('title', 'Delete Customer')
@section('content')

    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <p class="text-xs uppercase tracking-[0.2em] text-red-400 mb-2">
                Customer Management
            </p>

            <h1 class="text-2xl font-bold text-white">
                Delete Customer
            </h1>

            <p class="text-sm text-stone-500 mt-1">
                Review the customer before permanently deleting the account.
            </p>

        </div>

        <div class="bg-stone-900 border border-red-500/20 rounded-2xl overflow-hidden">
            <div class="px-6 py-5 border-b border-stone-800 bg-red-500/5">
                <div class="flex items-start gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-white">
                            Permanently delete this customer?
                        </h2>

                        <p class="text-sm text-stone-500 mt-1">
                            This action cannot be undone.
                        </p>

                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="bg-stone-950 border border-stone-800 rounded-xl p-5">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-14 h-14 shrink-0 rounded-full bg-amber-400 text-stone-950 flex items-center justify-center text-lg font-bold">
                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                        </div>

                        <div class="min-w-0">
                            <p class="text-lg font-semibold text-white truncate">
                                {{ $customer->name }}
                            </p>

                            <p class="text-sm text-stone-500 truncate">
                                {{ $customer->email }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 pt-5 border-t border-stone-800 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-stone-600">
                                Customer ID
                            </p>

                            <p class="text-sm text-stone-300 mt-1">
                                #{{ $customer->id }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-stone-600">
                                Account Type
                            </p>

                            <p class="text-sm text-amber-400 mt-1">
                                Customer
                            </p>
                        </div>

                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-stone-600">
                                Email
                            </p>

                            <p class="text-sm text-stone-300 mt-1 break-all">
                                {{ $customer->email }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-stone-600">
                                Registered
                            </p>

                            <p class="text-sm text-stone-300 mt-1">
                                {{ $customer->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-5 px-4 py-4 rounded-xl bg-red-500/5 border border-red-500/10">
                    <p class="text-sm text-red-400 font-medium">
                        Warning
                    </p>

                    <p class="text-xs text-stone-500 mt-1 leading-5">
                        Deleting this account will permanently remove this customer from FashionHub. Make sure you want to continue before confirming this action.
                    </p>
                </div>

                <div class="mt-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                    <a href="{{ route('admin.customers.index') }}" class="w-full sm:w-auto px-5 py-3 rounded-xl bg-stone-800 hover:bg-stone-700 border border-stone-700 text-stone-300 hover:text-white text-sm font-semibold text-center transition">
                        Cancel
                    </a>

                    <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="w-full sm:w-auto">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="w-full sm:w-auto px-5 py-3 rounded-xl bg-red-500 hover:bg-red-400 text-white text-sm font-semibold transition">
                            Permanently Delete Customer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
