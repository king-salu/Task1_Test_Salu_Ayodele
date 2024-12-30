<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Protect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = $request->header('Authorization');

            if (!$token) $token = $request->cookie('blm_jwt');

            if (!$token) throw new JWTException('no token provided');

            if (preg_match("/^Bearer/", $token)) {
                $tk_split = explode(' ', $token);
                $token = $tk_split[1] ?? $token;
            }
            JWTAuth::setToken($token);
            $user = JWTAuth::authenticate();

            $request->attributes->set('user', $user);
        } catch (JWTException $ex) {
            return response()->json(['message' => 'invalid access, please login'], 401);
        }
        return $next($request);
    }
}
