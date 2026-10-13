@if (session('success'))
    <div class="mb-6 flex items-start justify-between gap-4 rounded-xl border border-green-500/30 bg-green-950/30 px-5 py-4 text-sm text-green-400"
        role="alert">
        <p class="flex-1">{{ session('success') }}</p>

        <button type="button" onclick="this.parentElement.remove()"
            class="shrink-0 text-green-400 hover:text-white text-xl font-bold leading-none transition"
            aria-label="Close success message">
            &times;
        </button>
    </div>
@endif

@if (session('error'))
    <div class="mb-6 flex items-start justify-between gap-4 rounded-xl border border-red-500/30 bg-red-950/30 px-5 py-4 text-sm text-red-400"
        role="alert">
        <p class="flex-1">{{ session('error') }}</p>

        <button type="button" onclick="this.parentElement.remove()"
            class="shrink-0 text-red-400 hover:text-white text-xl font-bold leading-none transition"
            aria-label="Close error message">
            &times;
        </button>
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 flex items-start justify-between gap-4 rounded-xl border border-red-500/30 bg-red-950/30 px-5 py-4 text-sm text-red-400"
        role="alert">
        <div class="flex-1">
            <p class="font-semibold mb-2">Please correct the following errors:</p>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

        <button type="button" onclick="this.parentElement.remove()"
            class="shrink-0 text-red-400 hover:text-white text-xl font-bold leading-none transition"
            aria-label="Close validation errors">
            &times;
        </button>
    </div>
@endif
