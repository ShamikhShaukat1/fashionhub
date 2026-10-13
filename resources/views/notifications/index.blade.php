@extends('layouts.app')
@section('title', 'Notifications - Fashion Hub')
@section('page', 'Notifications')
@section('heading', 'Notifications')
@section('content')

    <div class="mx-auto max-w-6xl space-y-6">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-white">
                    Notifications
                </h1>

                <p class="mt-1 text-sm text-stone-400">
                    View and manage your latest updates.
                </p>
            </div>

            @if ($unreadCount > 0)
                <form method="POST" action="{{ route('notifications.readAll') }}">
                    @csrf
                    @method('PATCH')

                    <button type="submit"
                        class="rounded-xl border border-stone-700 px-4 py-2.5
                           text-sm font-semibold text-stone-200
                           transition hover:border-amber-500 hover:text-amber-400">
                        Mark all as read
                    </button>
                </form>
            @endif
        </div>

        @include('components.alerts')

        <div class="overflow-hidden rounded-2xl border border-stone-800/80 bg-stone-900/60">
            <style>
                .custom-scrollbar::-webkit-scrollbar {
                    width: 6px;
                }

                .custom-scrollbar::-webkit-scrollbar-track {
                    background: transparent;
                }

                .custom-scrollbar::-webkit-scrollbar-thumb {
                    background: rgba(168, 162, 158, 0.2);
                    border-radius: 9999px;
                }

                .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                    background: rgba(251, 191, 36, 0.4);
                }
            </style>

            <div class="max-h-[650px] overflow-y-auto custom-scrollbar">
                @forelse($notifications as $notification)
                    @php
                        $data = $notification->data;
                        $type = $data['type'] ?? 'info';
                        $typeClasses = [
                            'success' => 'border-emerald-500/30 text-emerald-400',
                            'info' => 'border-sky-500/30 text-sky-400',
                            'warning' => 'border-amber-500/30 text-amber-400',
                            'error' => 'border-red-500/30 text-red-400',
                        ];

                        $typeClass = $typeClasses[$type] ?? $typeClasses['info'];
                    @endphp

                    <div
                        class="flex flex-col gap-4 border-b border-stone-800/80 p-5 transition last:border-b-0 hover:bg-stone-800/30 sm:flex-row sm:items-start">
                        <div class="flex min-w-0 flex-1 gap-4">
                            <div
                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border {{ $typeClass }}">
                                <span class="text-lg">
                                    @switch($type)
                                        @case('success')
                                            ✓
                                        @break

                                        @case('warning')
                                            !
                                        @break

                                        @case('error')
                                            ×
                                        @break

                                        @default
                                            i
                                    @endswitch
                                </span>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h2 class="font-semibold text-white">
                                        {{ $data['title'] ?? 'Notification' }}
                                    </h2>

                                    @if (!$notification->read_at)
                                        <span
                                            class="rounded-full bg-amber-500/10 px-2 py-0.5 text-xs font-medium text-amber-400">
                                            New
                                        </span>
                                    @endif
                                </div>

                                <p class="mt-1 text-sm leading-6 text-stone-400">
                                    {{ $data['message'] ?? '' }}
                                </p>

                                <p class="mt-2 text-xs text-stone-500">
                                    {{ $notification->created_at->format('d M Y, h:i A') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex shrink-0 flex-wrap items-center gap-3 sm:justify-end">
                            @if (!empty($data['url']))
                                <a href="{{ route('notifications.open', $notification->id) }}"
                                    class="text-sm font-semibold text-amber-400 transition hover:text-amber-300">
                                    View
                                </a>
                            @elseif(!$notification->read_at)
                                <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="text-sm font-medium text-stone-300 hover:text-amber-400">
                                        Mark read
                                    </button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="text-sm font-medium text-red-400 transition hover:text-red-300">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                        <div class="px-6 py-16 text-center">
                            <div
                                class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-stone-700 bg-stone-800">
                                <span class="text-2xl text-stone-400">♧</span>
                            </div>

                            <h2 class="mt-4 font-semibold text-white">
                                No notifications yet
                            </h2>

                            <p class="mt-2 text-sm text-stone-400">
                                Updates from your Fashion Hub activity will appear here.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="text-stone-300">
                {{ $notifications->links() }}
            </div>

        </div>
    @endsection
