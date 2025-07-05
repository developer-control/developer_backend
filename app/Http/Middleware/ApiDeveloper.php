<?php

namespace App\Http\Middleware;

use App\Models\Developer;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiDeveloper
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route('developer') ?? $request->route('slug');

        if (!$slug) {
            return response()->json(['message' => 'Developer slug is missing'], 400);
        }

        $developer = Developer::where('slug', $slug)->first();

        if (!$developer) {
            return response()->json(['message' => 'Developer not found'], 404);
        }

        // // Inject developer ke request
        $request->merge(['developer' => $developer]);

        return $next($request);
    }
}
