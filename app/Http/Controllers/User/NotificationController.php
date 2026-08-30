<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SendNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $notifications = SendNotification::where('user_id', $userId)
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'is_read' => (bool) $notification->is_read,
                    'time' => $notification->created_at?->diffForHumans(),
                ];
            });

        $unreadCount = SendNotification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'count' => $unreadCount,
            'notifications' => $notifications,
        ]);
    }

    public function markAsRead(Request $request, int $id): JsonResponse
    {
        $notification = SendNotification::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $notification->update([
            'is_read' => true,
        ]);

        return response()->json([
            'success' => true,
        ]);
    }

    public function markAllAsRead(Request $request): JsonResponse
    {
        SendNotification::where('user_id', $request->user()->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
            ]);

        return response()->json([
            'success' => true,
        ]);
    }
}