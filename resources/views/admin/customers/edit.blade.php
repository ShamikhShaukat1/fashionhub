@extends('layouts.app')
@section('title', 'Edit Customer')
@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <p class="text-xs uppercase tracking-widest text-amber-400 mb-2">
                Customer Management
            </p>

            <h1 class="text-2xl font-bold text-white">
                Edit Customer
            </h1>

            <p class="text-sm text-stone-500 mt-1">
                Update customer information
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20">
                <ul class="space-y-1 text-sm text-red-400">
                    @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-stone-900 border border-stone-800 rounded-2xl p-8">
            <form action="{{ route('admin.customers.update', $customer) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="block text-sm font-medium text-stone-300 mb-2">
                        Name
                    </label>

                    <input type="text" name="name" value="{{ old('name', $customer->name) }}" required class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none">
                    @error('name')
                        <p class="text-xs text-red-400 mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-stone-300 mb-2">
                        Email
                    </label>

                    <input type="email" name="email" value="{{ old('email', $customer->email) }}" required class="w-full px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-white focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none">
                    @error('email')
                        <p class="text-xs text-red-400 mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-medium text-stone-300 mb-2">
                        Account Type
                    </label>

                    <div class="px-4 py-3 rounded-xl bg-stone-950 border border-stone-800 text-amber-400">
                        Customer
                    </div>

                    <p class="text-xs text-stone-600 mt-2">
                        Customer role cannot be changed from this screen.
                    </p>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.customers.index') }}" class="px-5 py-3 rounded-xl bg-stone-800 hover:bg-stone-700 text-stone-300 text-sm font-semibold">
                        Cancel
                    </a>


                    <button type="submit" class="px-5 py-3 rounded-xl bg-amber-400 hover:bg-amber-300 text-stone-950 text-sm font-semibold">
                        Update Customer
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
