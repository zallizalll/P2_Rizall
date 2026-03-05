<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = session('user');

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->jabatan->slug !== 'administrator') {
            return $this->redirectToDashboard($user->jabatan->slug);
        }

        return $next($request);
    }

    private function redirectToDashboard($slug)
    {
        return match($slug) {
            'kepala_lurah'    => redirect()->route('dashboard.lurah'),
            'sekre_lurah'     => redirect()->route('dashboard.sekre'),
            'staff_pelayanan' => redirect()->route('dashboard.staff'),
            default           => redirect()->route('login')
        };
    }
}