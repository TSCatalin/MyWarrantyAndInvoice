<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
  public function index()
{
    $notifications = Auth::user()->notifications->sortByDesc('created_at')->values();

    return response()->json($notifications);
}


    public function unread()
    {
        return response()->json(Auth::user()->unreadNotifications);
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications->where('id', $id)->firstOrFail();
        $notification->markAsRead();

        return response()->json(['message' => 'Notification marked as read.']);
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return response()->json(['message' => 'All notifications have been marked as read.']);
    }

    public function show($id)
    {
        $notification = Auth::user()->notifications->where('id', $id)->firstOrFail();

        return response()->json($notification);
    }

    public function countUnread()
    {
        $unreadNotificationsCount = Auth::user()->unreadNotifications->count();

        return response()->json([
            'unread_notifications_count' => $unreadNotificationsCount
        ]);
    }
}
