<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = session('token');

        if (!$token) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu')
                ->with('intended', $request->fullUrl());
        }

        try {
            $user = JWTAuth::setToken($token)->authenticate();

            if (!$user) {
                session()->forget(['token', 'user']);
                return redirect()->route('login')->with('error', 'Session expired, silakan login kembali');
            }
        } catch (\Exception $e) {
            session()->forget(['token', 'user']);
            return redirect()->route('login')->with('error', 'Session expired, silakan login kembali');
        }

        return $next($request);
    }
}
