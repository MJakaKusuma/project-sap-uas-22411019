<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EnsureRolePrefixMatches
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $prefix = $request->route()?->getPrefix();
            $role = auth()->user()->role;

            // Cocokkan prefix dengan role
            if ($prefix && !Str::contains($prefix, $role)) {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with('error', 'Akses tidak sah.');
            }
        }

        return $next($request);
    }
}
