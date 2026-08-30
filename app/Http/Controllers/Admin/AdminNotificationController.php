<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;

class AdminNotificationController extends Controller
{
    public function index(): JsonResponse
    {
        $notifications = Notification::with('user')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($notif) {
                return [
                    'id' => $notif->id,
                    'title' => $notif->title,
                    'message' => $notif->message,
                    'type' => $notif->type,
                    'is_read' => $notif->is_read,
                    'user_name' => $notif->user ? $notif->user->name : null,
                    'time' => $notif->created_at->diffForHumans(),
                ];
            });

        $unreadCount = Notification::where('is_read', false)->count();

        return response()->json([
            'count' => $unreadCount,
            'notifications' => $notifications,
        ]);
    }

    public function readAll()
    {
        Notification::where('is_read', 0)
            ->update([
                'is_read' => 1,
            ]);

        return response()->json([
            'success' => true,
        ]);
    }


}