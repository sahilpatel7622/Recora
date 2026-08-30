<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            session(['admin_name' => Auth::user()->name]);
        }

        $totalUsers = User::where('role', '!=', 'admin')->count();
        $activeUsers = User::where('role', '!=', 'admin')->where('status', 1)->count();
        $inactiveUsers = User::where('role', '!=', 'admin')->where('status', 0)->count();

        $totalFolders = 0;
        $totalInvoices = 0;
        $todayInvoices = 0;
        $recentActivitiesCount = 0;

        $recentUsers = User::where('role', '!=', 'admin')->latest()->take(5)->get();

        return view('admin.dashboard.index', compact(
            'totalUsers',
            'activeUsers',
            'inactiveUsers',
            'totalFolders',
            'totalInvoices',
            'todayInvoices',
            'recentActivitiesCount',
            'recentUsers'
        ));
    }
}
