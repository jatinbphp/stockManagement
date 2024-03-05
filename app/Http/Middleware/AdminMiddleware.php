<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && in_array(auth()->user()->role, ['super_admin', 'admin', 'stock_clerk', 'accountant', 'general_admin', 'shop_manager'])) {
            return $next($request);
        }

        \Session::flash('danger', 'You cannot log in!');
        return redirect()->route('admin.login');
    }
}
