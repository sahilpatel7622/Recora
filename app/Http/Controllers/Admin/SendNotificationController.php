<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SendNotification;
use App\Models\User;
use Illuminate\Http\Request;

class SendNotificationController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $filter = $request->query('filter', 'all');

        $query = SendNotification::with('user');

        if ($filter === 'deleted') {
            $query->onlyTrashed();
        } else {
            if ($filter === 'read') {
                $query->where('is_read', true);
            } elseif ($filter === 'unread') {
                $query->where('is_read', false);
            }
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $notifications = $query->latest()->paginate(10);

        $totalNotifications = SendNotification::count();
        $readNotifications = SendNotification::where('is_read', true)->count();
        $unreadNotifications = SendNotification::where('is_read', false)->count();
        $deletedNotifications = SendNotification::onlyTrashed()->count();

        return view('admin.notifications.index', compact(
            'notifications',
            'search',
            'filter',
            'totalNotifications',
            'readNotifications',
            'unreadNotifications',
            'deletedNotifications'
        ));
    }

    public function create()
    {
        $users = User::where('role', 'user')
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        return view('admin.notifications.send', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_type' => [
                'required',
                'in:user,all'
            ],
            'user_id' => [
                'required_if:recipient_type,user',
                'nullable',
                'exists:users,id',
            ],
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'message' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);

        if ($request->recipient_type === 'all') {
            SendNotification::create([
                'recipient_type' => 'all',
                'user_id' => null,
                'title' => $request->title,
                'message' => $request->message,
                'is_read' => false,
            ]);

            return back()->with('success', 'Notification sent to all active users.');
        }

        $user = User::where('id', $request->user_id)
            ->where('role', 'user')
            ->where('status', 1)
            ->firstOrFail();

        SendNotification::create([
            'recipient_type' => 'user',
            'user_id' => $user->id,
            'title' => $request->title,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return back()->with(
            'success',
            'Notification sent to ' . $user->name . '.'
        );
    }

    public function destroy($id)
    {
        $notification = SendNotification::findOrFail($id);
        $notification->delete();

        return back()->with('success', 'Notification moved to deleted items.');
    }

    public function restore($id)
    {
        $notification = SendNotification::withTrashed()->findOrFail($id);
        $notification->restore();

        return back()->with('success', 'Notification restored successfully.');
    }

    public function forceDelete($id)
    {
        $notification = SendNotification::withTrashed()->findOrFail($id);
        $notification->forceDelete();

        return back()->with('success', 'Notification permanently deleted.');
    }
}