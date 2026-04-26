<?php

namespace App\Http\Middleware;

use App\Models\Site;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateSiteKey
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

        $siteKey = $request->input('site_key');
        if ($siteKey !== null && $siteKey !== '' && $siteKey !== $site->site_key) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'site_key' => ['The site_key does not match the authenticated token.'],
                ],
            ], 422);
        }

        return $next($request);
    }
}
