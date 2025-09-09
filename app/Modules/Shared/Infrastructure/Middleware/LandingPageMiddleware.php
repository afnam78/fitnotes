<?php

declare(strict_types=1);

namespace App\Modules\Shared\Infrastructure\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class LandingPageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
