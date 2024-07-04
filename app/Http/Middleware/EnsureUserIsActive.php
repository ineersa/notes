<?php

namespace App\Http\Middleware;

use App\Contracts\IsActiveUserContract;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user ||
            ($user instanceof IsActiveUserContract && ! $user->isActiveUser())
        ) {
            if ($request->expectsJson()) {
                abort(403, 'Your email address is not verified.');
            }
            return \Redirect::guest(\URL::route($user->redirectRoute()));
        }

        return $next($request);
    }
}
