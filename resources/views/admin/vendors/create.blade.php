@extends('layouts.app')
@section('title', 'Add Vendor')
@section('content')
    <div class="min-h-screen bg-stone-950 px-6 py-10">
        <div class="max-w-5xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('admin.vendors.index') }}"
                    class="text-xs uppercase tracking-widest text-stone-500 hover:text-amber-400 transition">
                    ← Back to Vendors
                </a>

                <p class="text-xs uppercase tracking-[0.25em] text-amber-400 font-semibold mt-6">
                    Vendor Management
                </p>

                <h1 class="text-3xl font-bold text-white mt-2">
                    Add Vendor
                </h1>

                <p class="text-sm text-stone-500 mt-2">
                    Create a vendor account and store.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-6 px-5 py-4 rounded-xl bg-red-500/10 border border-red-500/20">
                    <ul class="list-disc list-inside text-sm text-red-400 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.vendors.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
                    <h2 class="text-lg font-semibold text-white mb-6">
                        Account Information
                    </h2>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-stone-500 mb-2">
                                Vendor Name
                            </label>

                            <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none">
                        </div>

                        <div>
                            <label class="block text-xs uppercase tracking-widest text-stone-500 mb-2">
                                Email
                            </label>

                            <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none">
                        </div>

                        <div>
                            <label class="block text-xs uppercase tracking-widest text-stone-500 mb-2">
                                Password
                            </label>

                            <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none">
                        </div>

                        <div>
                            <label class="block text-xs uppercase tracking-widest text-stone-500 mb-2">
                                Confirm Password
                            </label>

                            <input type="password" name="password_confirmation" required class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none">
                        </div>

                    </div>
                </div>

                <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
                    <h2 class="text-lg font-semibold text-white mb-6">
                        Store Information
                    </h2>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-stone-500 mb-2">
                                Store Name
                            </label>

                            <input type="text" name="store_name" value="{{ old('store_name') }}" required class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none">
                        </div>

                        <div>
                            <label class="block text-xs uppercase tracking-widest text-stone-500 mb-2">
                                Description
                            </label>

                            <textarea name="description" rows="5" class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none">{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs uppercase tracking-widest text-stone-500 mb-2">
                                Phone
                            </label>

                            <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none">
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-stone-500 mb-2">
                                    Store Logo
                                </label>

                                <input type="file" name="logo" accept="image/*" class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-stone-400">
                            </div>

                            <div>
                                <label class="block text-xs uppercase tracking-widest text-stone-500 mb-2">
                                    Store Banner
                                </label>

                                <input type="file" name="banner" accept="image/*" class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-stone-400">
                            </div>

                        </div>
                    </div>
                </div>

                <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
                    <h2 class="text-lg font-semibold text-white mb-6">
                        Store Address
                    </h2>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-stone-500 mb-2">
                                Address
                            </label>

                            <input type="text" name="address" value="{{ old('address') }}" class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white">
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <input type="text" name="city" placeholder="City" value="{{ old('city') }}" class="px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white">

                            <input type="text" name="state" placeholder="State / Province" value="{{ old('state') }}" class="px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white">

                            <input type="text" name="country" placeholder="Country" value="{{ old('country') }}" class="px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white">

                            <input type="text" name="postal_code" placeholder="Postal Code" value="{{ old('postal_code') }}" class="px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white">
                        </div>
                    </div>
                </div>

                <div class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
                    <label class="block text-xs uppercase tracking-widest text-stone-500 mb-2">
                        Vendor Status
                    </label>

                    <select name="status" class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white">
                        <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="suspended" {{ old('status') === 'suspended' ? 'selected' : '' }}>
                            Suspended
                        </option>

                        <option value="rejected" {{ old('status') === 'rejected' ? 'selected' : '' }}>
                            Rejected
                        </option>
                    </select>

                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.vendors.index') }}" class="px-6 py-3 rounded-xl bg-stone-800 hover:bg-stone-700 text-stone-300 text-sm font-semibold transition">
                        Cancel
                    </a>

                    <button type="submit" class="px-6 py-3 rounded-xl bg-amber-400 hover:bg-amber-300 text-stone-950 text-sm font-bold transition">
                        Create Vendor
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
