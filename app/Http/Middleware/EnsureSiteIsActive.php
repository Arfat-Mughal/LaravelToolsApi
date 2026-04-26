<?php

namespace App\Http\Middleware;

use App\Models\Site;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSiteIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $site = $request->user();

        if (! $site instanceof Site) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 401);
        }

        if (! $site->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'This site is inactive.',
            ], 403);
        }

        return $next($request);
    }
}
