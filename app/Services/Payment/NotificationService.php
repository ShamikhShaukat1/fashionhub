<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\GenericNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    public function sendToUser(
        User $user,
        string $title,
        string $message,
        string $type = 'info',
        ?string $url = null,
        array $data = []
    ): void {
        $user->notify(
            new GenericNotification(
                $title,
                $message,
                $type,
                $url,
                $data
            )
        );
    }

    public function sendToUsers(
        iterable $users,
        string $title,
        string $message,
        string $type = 'info',
        ?string $url = null,
        array $data = []
    ): void {
        Notification::send(
            $users,
            new GenericNotification(
                $title,
                $message,
                $type,
                $url,
                $data
            )
        );
    }

    public function sendToAdmins(
        string $title,
        string $message,
        string $type = 'info',
        ?string $url = null,
        array $data = []
    ): void {
        $admins = User::where('role', 'admin')->get();

        $this->sendToUsers(
            $admins,
            $title,
            $message,
            $type,
            $url,
            $data
        );
    }

    public function sendToAllUsers(
        string $title,
        string $message,
        string $type = 'info',
        ?string $url = null,
        array $data = []
    ): void {
        $users = User::all();

        $this->sendToUsers(
            $users,
            $title,
            $message,
            $type,
            $url,
            $data
        );
    }

    public function unreadCount(User $user): int
    {
        return $user->unreadNotifications()->count();
    }

    public function recentNotifications(
        User $user,
        int $limit = 10
    ): Collection {
        return $user->notifications()
            ->latest()
            ->limit($limit)
            ->get();
    }
}
