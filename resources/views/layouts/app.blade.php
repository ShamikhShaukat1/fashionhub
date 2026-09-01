<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title> @yield('title', 'Fashion Hub') </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-stone-950 text-stone-100 min-h-screen">
    @include('layouts.sidebar')
    <div class="ml-64 min-h-screen">

        <nav class="h-20 sticky top-0 z-30 border-b border-stone-800/80 bg-stone-950/90 backdrop-blur-md">
            <div class="h-full px-8 flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2 text-xs uppercase tracking-[0.2em]">
                        <span class="text-stone-500">
                            Fashion Hub
                        </span>

                        <span class="text-stone-700">
                            /
                        </span>

                        <span class="text-amber-400">
                            @yield('page', 'Dashboard')
                        </span>

                    </div>

                    <h1 class="text-lg font-semibold text-white mt-1">
                        @yield('heading', 'Dashboard')
                    </h1>

                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:block text-right">
                        <p class="text-sm font-medium text-white">
                            {{ Auth::user()->name ?? 'Designer' }}
                        </p>

                        <p class="text-xs text-stone-500">
                            {{ Auth::user()->role === 'admin' ? 'Administrator': 'Customer' }}
                        </p>

                    </div>

                    <div
                        class="w-10 h-10 rounded-full bg-amber-400 text-stone-950 flex items-center justify-center font-bold">
                        {{ strtoupper(substr(Auth::user()->name ?? 'D', 0, 1))}}
                    </div>

                </div>
            </div>

        </nav>

        <main class="px-8 py-8">
            @yield('content')
        </main>

    </div>

</body>
</html>
