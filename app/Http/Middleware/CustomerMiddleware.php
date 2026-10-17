<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::guard('customer')->check()) {
            session([
                'url.intended' => url()->full(),
            ]);

            return redirect()->route('account.login');
        }
        abort_unless(Auth::guard('customer')->user()->status && Auth::guard('customer')->user()->type === 'customer', 403);

        return $next($request);
    }
}
