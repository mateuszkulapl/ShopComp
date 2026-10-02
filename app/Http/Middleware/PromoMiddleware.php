<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PromoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless($this->hasAccess($request), Response::HTTP_NOT_FOUND);

        return $next($request);
    }

    private function hasAccess(Request $request): bool
    {
        if (config('promo.enabled')) {
            return true;
        }

        $configKey = config('promo.key');
        $cookieKey = $request->cookie('key');
        return is_string($configKey) && $configKey !== '' && is_string($cookieKey)
            && hash_equals($configKey, $cookieKey);
    }
}
