<?php

namespace App\Http\Middleware;

use App\Models\Maintenance;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenance
{
    public function handle(Request $request, Closure $next): Response
    {
        $maintenance = Maintenance::first();

        if ($maintenance && $maintenance->is_active == 1) {
            return response()->view('user.maintenance');
        }

        return $next($request);
    }
}