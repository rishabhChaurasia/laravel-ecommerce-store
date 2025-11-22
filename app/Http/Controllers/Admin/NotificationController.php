<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->latest()->paginate(15);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function unread()
    {
        $notifications = auth()->user()->unreadNotifications()->latest()->paginate(15);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function delete($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();

        return redirect()->back()->with('success', 'Notification deleted.');
    }
}