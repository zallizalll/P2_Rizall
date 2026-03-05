<?php

namespace App\Http\Controllers;

use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function loginWeb(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $user = $this->userRepository->findByEmail($request->email);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withErrors(['email' => 'Email atau password salah'])
                ->withInput();
        }

        $user->load('jabatan');

        $token = JWTAuth::fromUser($user);

        session([
            'token' => $token,
            'user' => $user
        ]);

        $redirectRoute = match ($user->jabatan->slug) {
            'administrator'  => 'dashboard.admin',
            'kepala_lurah'   => 'dashboard.lurah',
            'sekre_lurah'    => 'dashboard.sekre',
            'staff_pelayanan' => 'dashboard.staff',
            default          => 'dashboard.admin'
        };

        return redirect()->route($redirectRoute)->with([
            'jwt_token' => $token,
            'user_data' => $user
        ]);
    }

    public function logoutWeb(Request $request)
    {
        $token = session('token');

        if ($token) {
            try {
                JWTAuth::setToken($token)->invalidate();
            } catch (\Exception $e) {
            }
        }

        session()->forget(['token', 'user']);
        session()->flush();

        return redirect()->route('login')->with('success', 'Logout berhasil');
    }
}
