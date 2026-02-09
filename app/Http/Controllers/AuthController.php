<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Login pakai Laravel Auth biasa
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Generate JWT token untuk keperluan lain (API, dll)
            $user = Auth::user();
            $token = JWTAuth::fromUser($user);
            session(['jwt_token' => $token]);

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.'
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        try {
            $token = session('jwt_token');
            if ($token) {
                JWTAuth::setToken($token)->invalidate();
            }
        } catch (\Exception $e) {
            // Ignore
        }

        session()->forget('jwt_token');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function me()
    {
        return response()->json(Auth::user());
    }
}
