<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OfficePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$types): Response
    {
        $user = $request->user();
        if (!$user) {
            abort(403, 'User is not logged in.');
        }
        $routeRaw = $request->route()->getName();  // misal 'property.index'
        if (!$routeRaw) {
            abort(403, 'Route is not named.');
        }
        $routeParts = explode('.', $routeRaw);
        $routeName = end($routeParts);

        foreach ($types as $type) {
            $routeParts[count($routeParts) - 1] = $type;
            $perm = implode('>', $routeParts);

            if ($user->hasOfficePermissionTo($perm)) {
                return $next($request);
            }
        }
        abort(403, 'User does not have the right permissions.');
    }
}
