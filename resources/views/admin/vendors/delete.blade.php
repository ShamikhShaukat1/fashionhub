@extends('layouts.app')
@section('title', 'Delete Vendor')
@section('content')
    <div class="min-h-screen bg-stone-950 px-6 py-10">
        <div class="max-w-2xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('admin.vendors.show', $vendor) }}" class="inline-flex items-center text-xs uppercase tracking-widest text-stone-500 hover:text-amber-400 transition">
                    ← Back to Vendor
                </a>
            </div>

            <div class="bg-stone-900 border border-stone-800 rounded-2xl overflow-hidden">
                <div class="px-8 py-6 border-b border-stone-800">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 flex items-center justify-center text-xl font-bold">
                            !
                        </div>

                        <div>
                            <p class="text-[10px] uppercase tracking-[0.25em] text-red-400 font-semibold">
                                Danger Zone
                            </p>

                            <h1 class="text-2xl font-bold text-white mt-1">
                                Delete Vendor
                            </h1>

                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div class="bg-stone-950 border border-stone-800 rounded-xl p-5 mb-6">
                        <div class="flex items-center gap-4">
                            @if ($vendor->logo)
                                <img src="{{ asset('storage/' . $vendor->logo) }}" alt="{{ $vendor->store_name }}" class="w-16 h-16 rounded-xl object-cover border border-stone-800">
                            @else
                                <div class="w-16 h-16 rounded-xl bg-amber-400 text-stone-950 flex items-center justify-center text-xl font-bold">
                                    {{ strtoupper(substr($vendor->store_name, 0, 1)) }}
                                </div>
                            @endif

                            <div class="min-w-0">
                                <h2 class="text-lg font-semibold text-white truncate">
                                    {{ $vendor->store_name }}
                                </h2>

                                <p class="text-sm text-stone-500 mt-1">
                                    {{ $vendor->user->name }}
                                </p>

                                <p class="text-xs text-stone-600 mt-1">
                                    {{ $vendor->user->email }}
                                </p>

                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-white mb-3">
                            Are you sure you want to delete this vendor?
                        </h3>

                        <p class="text-sm text-stone-500 leading-6">
                            This action will permanently remove the vendor account and vendor profile from Fashion Hub. This action cannot be undone.
                        </p>
                    </div>

                    @if ($vendor->products->count() > 0)
                        <div class="mb-6 p-5 rounded-xl bg-amber-400/10 border border-amber-400/20">
                            <div class="flex gap-3">
                                <div class="text-amber-400 text-lg">
                                    ⚠
                                </div>

                                <div>
                                    <p class="text-sm font-semibold text-amber-400">
                                        Vendor has products
                                    </p>

                                    <p class="text-xs text-stone-500 mt-2 leading-5">
                                        This vendor currently has
                                        <span class="text-white font-semibold">
                                            {{ $vendor->products->count() }}
                                        </span>
                                        product(s).
                                        You cannot delete this vendor until these products are removed or reassigned.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="mb-6 p-5 rounded-xl bg-red-500/5 border border-red-500/10">
                            <p class="text-xs text-red-400 leading-5">
                                <span class="font-semibold">
                                    Warning:
                                </span>
                                Deleting this vendor will also delete the associated vendor account.
                            </p>
                        </div>
                    @endif

                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3">
                        <a href="{{ route('admin.vendors.show', $vendor) }}" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-stone-800 hover:bg-stone-700 text-stone-300 hover:text-white text-sm font-semibold text-center transition">
                            Cancel
                        </a>

                        @if ($vendor->products->count() == 0)
                            <form action="{{ route('admin.vendors.destroy', $vendor) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-red-500 hover:bg-red-400 text-white text-sm font-bold transition">
                                    Delete Vendor
                                </button>
                            </form>
                        @else
                            <button type="button" disabled class="w-full sm:w-auto px-6 py-3 rounded-xl bg-stone-800 text-stone-600 text-sm font-bold cursor-not-allowed">
                                Delete Vendor
                            </button>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
