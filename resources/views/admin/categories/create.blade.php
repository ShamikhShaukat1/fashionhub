@extends('layouts.app')
@section('title', 'Add Category')
@section('content')

<div class="max-w-3xl mx-auto px-6 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-stone-100">
            Add Category
        </h1>

        <p class="text-stone-400 mt-1">
            Create a new product category
        </p>

    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="bg-stone-900 border border-stone-800 rounded-2xl p-6">
        @csrf

        <div class="mb-6">
            <label for="name" class="block mb-2 text-sm font-semibold text-stone-300">
                Category Name
            </label>

            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Men's Clothing"
                   class="w-full bg-stone-800 border border-stone-700 focus:border-amber-400 focus:ring-1 focus:ring-amber-400 text-stone-100 placeholder-stone-500 rounded-xl px-4 py-3 outline-none transition">

                @error('name')

                    <p class="text-red-400 text-sm mt-2">
                        {{ $message }}
                    </p>

                @enderror

        </div>

        <div class="mb-6">
            <label for="description" class="block mb-2 text-sm font-semibold text-stone-300">
                Description
            </label>

            <textarea id="description" name="description" rows="5" placeholder="Category description"
                      class="w-full bg-stone-800 border border-stone-700 focus:border-amber-400 focus:ring-1 focus:ring-amber-400 text-stone-100 placeholder-stone-500 rounded-xl px-4 py-3 outline-none transition resize-none">{{ old('description') }}</textarea>

                @error('description')

                    <p class="text-red-400 text-sm mt-2">
                        {{ $message }}
                    </p>

                @enderror

        </div>

        <div class="mb-8">
            <label for="status" class="block mb-2 text-sm font-semibold text-stone-300">
                Status
            </label>

            <select id="status" name="status" class="w-full bg-stone-800 border border-stone-700 focus:border-amber-400 focus:ring-1 focus:ring-amber-400 text-stone-100 rounded-xl px-4 py-3 outline-none transition">

                <option value="1"
                    {{ old('status', '1') == '1' ? 'selected' : '' }}>
                    Active
                </option>

                <option value="0"
                    {{ old('status') === '0' ? 'selected' : '' }}>
                    Inactive
                </option>

            </select>

            @error('status')

                <p class="text-red-400 text-sm mt-2">
                    {{ $message }}
                </p>

            @enderror

        </div>

        <div class="pt-4 border-t border-stone-800/80 flex items-center justify-end gap-4">
            <a href="{{ route('admin.categories.index') }}"
               class="px-6 py-3 bg-stone-800 hover:bg-stone-700 border border-stone-700 text-stone-300 font-semibold text-xs uppercase tracking-widest rounded-xl transition">
                Cancel
            </a>

            <button type="submit" class="px-6 py-3 bg-amber-400 hover:bg-amber-300 text-stone-950 font-semibold text-xs uppercase tracking-widest rounded-xl transition">
                Create Category
            </button>

        </div>
    </form>
</div>

@endsection
