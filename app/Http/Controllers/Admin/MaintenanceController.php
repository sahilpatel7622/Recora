<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;

class MaintenanceController extends Controller
{
    public function status()
    {
        $maintenance = Maintenance::first();

        return response()->json([
            'status' => $maintenance?->is_active ?? 0
        ]);
    }

    public function toggle()
    {
        $maintenance = Maintenance::firstOrCreate(
            ['id' => 1],
            ['is_active' => 0]
        );

        $maintenance->is_active = $maintenance->is_active == 1 ? 0 : 1;
        $maintenance->save();

        return response()->json([
            'success' => true,
            'status' => $maintenance->is_active
        ]);
    }

    public function check()
    {
        $maintenance = Maintenance::first();

        return response()->json([
            'status' => $maintenance?->is_active ?? 0
        ]);
    }
}