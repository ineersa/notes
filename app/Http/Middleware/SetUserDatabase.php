<?php

namespace App\Http\Middleware;

use App\Services\UserDatabasesService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetUserDatabase
{
    public function __construct(
        private readonly UserDatabasesService $userDatabasesService
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $this->userDatabasesService->setupDatabase(auth()->id());
        }

        return $next($request);
    }
}
