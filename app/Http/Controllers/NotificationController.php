<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->latest()->paginate(5);
        $unreadCount = $user->unreadNotifications()->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function open(string $notification)
    {
        $user = Auth::user();
        $item = $user->notifications()->whereKey($notification)->firstOrFail();

        if (is_null($item->read_at)) {
            $item->markAsRead();
        }

        $target = $item->data['url'] ?? null;

        if (is_string($target) && Str::startsWith($target, '/') && ! Str::startsWith($target, '//')) {
            return redirect()->to($target);
        }

        return redirect()->route('notifications.index');
    }

    public function markAsRead(string $notification)
    {
        $item = Auth::user()->notifications()->whereKey($notification)->firstOrFail();
        $item->markAsRead();

        return back()->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications()->update(['read_at' => now()]);

        return back()->with('success', 'All notifications marked as read.');
    }

    public function destroy(string $notification)
    {
        Auth::user()->notifications()->whereKey($notification)->firstOrFail()->delete();

        return back()->with('success', 'Notification deleted successfully.');
    }
}
