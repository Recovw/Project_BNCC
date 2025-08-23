<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class SimpleAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check())
        {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role ?? 'user';

        if ($userRole === 'admin' && $request->routeIs('showLogin')) {
            return redirect()->route('create');
        }

        if (!empty($roles) && !in_array($userRole, $roles))
        {
            return redirect()->route('welcomePage');
        }

        return $next($request);
    }
}
