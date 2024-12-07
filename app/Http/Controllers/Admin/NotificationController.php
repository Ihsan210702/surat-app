<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Notifications\DatabaseNotification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = DatabaseNotification::find($id);

        if ($notification && $notification->notifiable_id == auth()->id()) {
            $notification->markAsRead();
            
            return redirect(data_get($notification->data, 'url', '/home'));
        }

        return redirect()->back()->with('error', 'Notifikasi tidak ditemukan atau Anda tidak memiliki akses.');
    }
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }
}