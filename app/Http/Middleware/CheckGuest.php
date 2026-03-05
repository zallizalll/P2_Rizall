<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckGuest
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = session('token');

        if ($token) {
            try {
                $user = JWTAuth::setToken($token)->authenticate();

                if ($user) {
                    return redirect('/');
                }
            } catch (\Exception $e) {
                session()->forget(['token', 'user']);
            }
        }

        return $next($request);
    }
}
