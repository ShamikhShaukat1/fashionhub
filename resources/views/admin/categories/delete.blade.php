@extends('layouts.app')
@section('title', 'Delete Category')
@section('content')
<div class="max-w-3xl mx-auto px-6 py-12">
    <div class="bg-stone-900 border border-stone-800 rounded-2xl overflow-hidden">
        <div class="px-6 py-5 border-b border-stone-800">
            <h1 class="text-2xl font-bold text-stone-100">
                Delete Category
            </h1>

            <p class="text-stone-400 mt-1">
                Please review the category before deleting it.
            </p>

        </div>

        <div class="p-6">
            <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/30">
                <div class="flex items-start gap-3">
                    <div class="text-red-400 text-xl">
                        ⚠
                    </div>

                    <div>
                        <h2 class="font-semibold text-red-400">
                            Are you sure you want to delete this category?
                        </h2>

                        <p class="text-sm text-stone-400 mt-1">
                            This action cannot be undone.
                        </p>

                    </div>
                </div>
            </div>

            <div class="bg-stone-800 border border-stone-700 rounded-xl p-5 mb-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>

                        <p class="text-xs uppercase tracking-widest text-stone-500 mb-1">
                            Category Name
                        </p>

                        <p class="text-lg font-semibold text-stone-100">
                            {{ $category->name }}
                        </p>

                    </div>

                    <div>

                        <p class="text-xs uppercase tracking-widest text-stone-500 mb-1">
                            Slug
                        </p>

                        <p class="text-stone-300">
                            {{ $category->slug }}
                        </p>

                    </div>

                    <div>

                        <p class="text-xs uppercase tracking-widest text-stone-500 mb-1">
                            Products
                        </p>

                        <p class="text-stone-300">

                            {{ $category->products_count }}
                            {{ $category->products_count == 1 ? 'Product' : 'Products' }}

                        </p>

                    </div>

                    <div>

                        <p class="text-xs uppercase tracking-widest text-stone-500 mb-1">
                            Status
                        </p>

                        @if($category->status)
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-green-500/10 border border-green-500/20 text-green-400">
                                Active
                            </span>

                        @else
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-red-500/10 border border-red-500/20 text-red-400">
                                Inactive
                            </span>

                        @endif

                    </div>
                </div>
            </div>

            @if($category->products_count > 0)
                <div class="mb-6 p-4 rounded-xl bg-amber-400/10 border border-amber-400/30">
                    <p class="text-amber-400 font-semibold">
                        This category contains {{ $category->products_count }}
                        {{ $category->products_count == 1 ? 'product' : 'products' }}.
                    </p>

                    <p class="text-sm text-stone-400 mt-1">
                        You cannot delete this category until all products assigned to it have been moved to another category or removed.
                    </p>

                </div>

            @endif

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.categories.index') }}"
                class="px-6 py-3 bg-stone-800 hover:bg-stone-700 border border-stone-700 text-stone-300 font-semibold text-xs uppercase tracking-widest rounded-xl transition">
                    Cancel
                </a>

                @if($category->products_count == 0)
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="px-6 py-3 bg-red-500 hover:bg-red-400 text-white font-semibold text-xs uppercase tracking-widest rounded-xl transition">
                            Delete Category
                        </button>

                    </form>

                @else

                    <button type="button" disabled class="px-6 py-3 bg-stone-700 text-stone-500 font-semibold text-xs uppercase tracking-widest rounded-xl cursor-not-allowed">
                        Cannot Delete
                    </button>

                @endif
            </div>
        </div>
    </div>
</div>

@endsection
