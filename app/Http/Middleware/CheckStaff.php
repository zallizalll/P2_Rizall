<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckStaff
{
    public function handle(Request $request, Closure $next)
    {
        $user = session('user');

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->jabatan->slug !== 'staff_pelayanan') {
            return $this->redirectToDashboard($user->jabatan->slug);
        }

        return $next($request);
    }

    private function redirectToDashboard($slug)
    {
        return match($slug) {
            'administrator'   => redirect()->route('dashboard.admin'),
            'kepala_lurah'    => redirect()->route('dashboard.lurah'),
            'sekre_lurah'     => redirect()->route('dashboard.sekre'),
            default           => redirect()->route('login')
        };
    }
}