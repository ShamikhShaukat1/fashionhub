<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title> @yield('title', 'Fashion Hub') </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
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

                <div class="flex items-center gap-4">

                    @auth
                        @php
                            $navbarUnreadCount = auth()->user()->unreadNotifications()->count();
                            $navbarNotifications = auth()->user()->notifications()->latest()->limit(3)->get();
                        @endphp

                        <details class="relative">
                            <summary
                                class="relative flex h-11 w-11 cursor-pointer
                                       list-none items-center justify-center
                                       rounded-xl border border-stone-800
                                       bg-stone-900 text-stone-300
                                       transition hover:border-amber-500
                                       hover:text-amber-400">

                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9" />
                                    <path d="M10 21h4" />
                                </svg>

                                @if ($navbarUnreadCount > 0)
                                    <span
                                        class="absolute -right-1 -top-1
                                               flex h-5 min-w-5 items-center justify-center
                                               rounded-full bg-amber-500 px-1
                                               text-[10px] font-bold text-stone-950">
                                        {{ $navbarUnreadCount > 99 ? '99+' : $navbarUnreadCount }}
                                    </span>
                                @endif
                            </summary>

                            <div
                                class="absolute right-0 z-50 mt-3 w-80
                                       overflow-hidden rounded-2xl border
                                       border-stone-800 bg-stone-950 shadow-2xl
                                       sm:w-96">

                                <div
                                    class="flex items-center justify-between
                                           border-b border-stone-800 px-4 py-4">
                                    <div>
                                        <h3 class="font-semibold text-white">
                                            Notifications
                                        </h3>
                                        <p class="mt-1 text-xs text-stone-400">
                                            {{ $navbarUnreadCount }} unread
                                        </p>
                                    </div>

                                    <a href="{{ route('notifications.index') }}"
                                        class="text-xs font-semibold text-amber-400
                                               hover:text-amber-300">
                                        View all
                                    </a>
                                </div>

                                <div class="max-h-96 overflow-y-auto">
                                    @forelse($navbarNotifications as $item)
                                        <a href="{{ route('notifications.open', $item->id) }}"
                                            class="flex gap-3 border-b border-stone-800/70
                                                   px-4 py-3 transition last:border-b-0
                                                   hover:bg-stone-900">

                                            <span
                                                class="mt-2 h-2 w-2 shrink-0 rounded-full
                                                       {{ $item->read_at ? 'bg-stone-700' : 'bg-amber-400' }}">
                                            </span>

                                            <div class="min-w-0 flex-1">
                                                <p class="truncate text-sm font-semibold text-stone-100">
                                                    {{ $item->data['title'] ?? 'Notification' }}
                                                </p>

                                                <p class="mt-1 line-clamp-2 text-xs leading-5 text-stone-400">
                                                    {{ $item->data['message'] ?? '' }}
                                                </p>

                                                <p class="mt-1 text-[11px] text-stone-500">
                                                    {{ $item->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </a>
                                    @empty
                                        <p class="px-4 py-8 text-center text-sm text-stone-400">
                                            You're all caught up.
                                        </p>
                                    @endforelse
                                </div>

                                <a href="{{ route('notifications.index') }}"
                                    class="block border-t border-stone-800
                                           px-4 py-3 text-center text-sm font-semibold
                                           text-amber-400 hover:bg-stone-900">
                                    See all notifications
                                </a>
                            </div>
                        </details>
                    @endauth

                    @auth
                        <div class="flex items-center gap-3 border-l border-stone-800 pl-4">
                            <div class="hidden sm:block text-right">
                                <p class="text-sm font-medium text-white">
                                    {{ Auth::user()->name ?? 'Designer' }}
                                </p>
                                <p class="text-xs text-stone-500">
                                    {{ Auth::user()->role === 'admin' ? 'Administrator' : 'Customer' }}
                                </p>
                            </div>

                            <div
                                class="w-10 h-10 rounded-full bg-amber-400 text-stone-950 flex items-center justify-center font-bold">
                                {{ strtoupper(substr(Auth::user()->name ?? 'D', 0, 1)) }}
                            </div>
                        </div>
                    @endauth

                </div>
            </div>
        </nav>

        <main class="px-8 py-8">
            @yield('content')
        </main>

    </div>

</body>

</html>
