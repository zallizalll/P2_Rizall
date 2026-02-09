<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = session('jwt_token');
        
        if (!$token) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        try {
            // Set token dan authenticate
            JWTAuth::setToken($token);
            $user = JWTAuth::authenticate();

            if (!$user) {
                session()->forget('jwt_token');
                return redirect('/login')->with('error', 'User tidak ditemukan');
            }

            // Set user ke request agar bisa diakses di view
            $request->setUserResolver(function () use ($user) {
                return $user;
            });

        } catch (JWTException $e) {
            session()->forget('jwt_token');
            return redirect('/login')->with('error', 'Token expired atau tidak valid');
        }

        return $next($request);
    }
}