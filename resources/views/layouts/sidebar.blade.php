@php

    $isAdmin = Auth::check() && Auth::user()->role === 'admin';
    $adminMenuItems = [
        [
            'name' => 'Dashboard',
            'route' => 'admin.dashboard',
            'active_pattern' => 'admin.dashboard',
            'icon' => '⌂',
        ],
        [
            'name' => 'Products',
            'route' => 'admin.products.index',
            'active_pattern' => 'admin.products.*',
            'icon' => '▣',
        ],
        [
            'name' => 'Categories',
            'route' => 'admin.categories.index',
            'active_pattern' => 'admin.categories.*',
            'icon' => '▣',
        ],
    ];

    $userMenuItems = [
        [
            'name' => 'Dashboard',
            'route' => 'dashboard',
            'active_pattern' => 'dashboard',
            'icon' => '⌂',
        ],
        [
            'name' => 'Products',
            'route' => 'products.index',
            'active_pattern' => 'products.*',
            'icon' => '▣',
        ],
    ];

    $menuItems = $isAdmin ? $adminMenuItems : $userMenuItems;

@endphp


<aside class="fixed left-0 top-0 z-40 w-64 h-screen bg-stone-900 border-r border-stone-800 flex flex-col">
    <div class="h-20 flex items-center px-6 border-b border-stone-800">
        <div>
            <div class="text-sm uppercase tracking-[0.25em] font-bold text-amber-400">
                Fashion Hub
            </div>

            <div class="text-[10px] uppercase tracking-widest text-stone-500 mt-1">
                {{ $isAdmin ? 'Administration' : 'Store' }}
            </div>
        </div>
    </div>

    <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
        @foreach ($menuItems as $item)
            @php
                $isActive =
                    request()->routeIs($item['route']) ||
                    request()->routeIs($item['active_pattern']);
            @endphp

            @if(Route::has($item['route']))
                <a href="{{ route($item['route']) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition
                           {{ $isActive ? 'bg-amber-400 text-stone-950 shadow-md font-semibold' : 'text-stone-400 hover:bg-stone-800 hover:text-white' }}">
                    <span class="w-5 text-center text-lg">
                        {{ $item['icon'] }}
                    </span>
                    {{ $item['name'] }}
                </a>
            @endif
        @endforeach

        @if($isAdmin)
            <div class="border-t border-stone-800 my-4"></div>
            <div class="px-4 py-2">
                <p class="text-[10px] uppercase tracking-[0.2em] text-stone-600">
                    Management
                </p>
            </div>

            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-stone-500 hover:bg-stone-800 hover:text-white transition">
                <span class="w-5 text-center">
                    □
                </span>
                Orders
                <span class="ml-auto text-[9px] text-stone-600">
                    Soon
                </span>
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-stone-500 hover:bg-stone-800 hover:text-white transition">
                <span class="w-5 text-center">
                    ♙
                </span>
                Customers
                <span class="ml-auto text-[9px] text-stone-600">
                    Soon
                </span>
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-stone-500 hover:bg-stone-800 hover:text-white transition">
                <span class="w-5 text-center">
                    ◆
                </span>
                Vendors
                <span class="ml-auto text-[9px] text-stone-600">
                    Soon
                </span>
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-stone-500 hover:bg-stone-800 hover:text-white transition">
                <span class="w-5 text-center">
                    ▤
                </span>
                Inventory
                <span class="ml-auto text-[9px] text-stone-600">
                    Soon
                </span>
            </a>

        @endif

        <div class="border-t border-stone-800 my-4"></div>

        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-stone-500 hover:bg-stone-800 hover:text-white transition">
            <span class="w-5 text-center">
                ◫
            </span>
            Reports
            <span class="ml-auto text-[9px] text-stone-600">
                Soon
            </span>
        </a>

        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-stone-500 hover:bg-stone-800 hover:text-white transition">
            <span class="w-5 text-center">
                ⚙
            </span>
            Settings
            <span class="ml-auto text-[9px] text-stone-600">
                Soon
            </span>
        </a>

    </nav>

    <div class="p-4 border-t border-stone-800">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-full bg-amber-400 text-stone-950 flex items-center justify-center font-bold">
                {{ strtoupper(
                    substr(Auth::user()->name ?? 'D', 0, 1)
                ) }}
            </div>

            <div class="min-w-0">
                <p class="text-sm font-medium text-white truncate">
                    {{ Auth::user()->name ?? 'Designer' }}
                </p>

                <p class="text-xs text-stone-500 truncate">
                    {{ Auth::user()->email ?? 'designer@example.com' }}
                </p>
            </div>

        </div>

        @if($isAdmin)

            <div class="mb-3 px-3 py-2 rounded-lg bg-amber-400/10 border border-amber-400/20">
                <p class="text-[10px] uppercase tracking-widest text-amber-400 font-semibold">
                    Administrator
                </p>
            </div>

        @else

            <div class="mb-3 px-3 py-2 rounded-lg bg-stone-800/50 border border-stone-800">
                <p class="text-[10px] uppercase tracking-widest text-stone-500 font-semibold">
                    Customer
                </p>
            </div>

        @endif

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full px-4 py-2.5 rounded-xl bg-stone-800 hover:bg-stone-700 text-stone-300 hover:text-white text-xs uppercase tracking-wider font-semibold transition">
                Sign Out
            </button>
        </form>

    </div>
</aside>
