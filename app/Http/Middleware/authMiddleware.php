<?php

namespace App\Http\Middleware;

use App\Services\Token\JwtCreator;
use App\Services\Token\JwtToken;
use App\Services\user;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class authMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');
        if (! $token) {
            return response()->json(['message' => 'Token is missing'], 401);
        }
        $jwtToken = new JwtToken($token);
        if (! $user = $jwtToken->getUser()) {
            return response()->json(['message' => '失效的token'], 401);
        }
        app()->singleton(user::class, function () use ($user) {
            return $user;
        });
        return $next($request);
    }
}
