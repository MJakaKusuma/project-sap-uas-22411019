<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCompanyMatch
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        $resource = $request->route()->parameter('employee') ?? null;

        if ($resource && $resource->company_id !== $user->company_id) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }

}
