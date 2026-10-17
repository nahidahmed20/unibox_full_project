<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureStaff
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        abort_unless($user && $user->status && in_array($user->type, ['super_admin', 'admin', 'manager', 'cashier'], true), 403);

        return $next($request);
    }
}
