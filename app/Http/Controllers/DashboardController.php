<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('dashboard.admin');
    }

    public function lurah()
    {
        return view('dashboard.lurah');
    }

    public function sekre()
    {
        return view('dashboard.sekre');
    }

    public function staff()
    {
        return view('dashboard.staff');
    }
}